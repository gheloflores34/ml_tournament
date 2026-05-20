<?php
// api/matches/delete_match.php
// POST ?action=delete
// Removes a match and its team logo files from disk.
// Player rows are deleted automatically by the ON DELETE CASCADE FK.
// ────────────────────────────────────────────────────────────────────
$id   = (int)($_POST['id'] ?? 0);
$stmt = $db->prepare("SELECT team_a_img, team_b_img FROM matches WHERE id=?");
$stmt->execute([$id]);
$row  = $stmt->fetch();

if ($row) {
    deleteImage($row['team_a_img']);
    deleteImage($row['team_b_img']);
    $db->prepare("DELETE FROM matches WHERE id=?")->execute([$id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Record not found']);
}
