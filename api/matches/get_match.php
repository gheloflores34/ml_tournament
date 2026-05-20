<?php
// api/matches/get_match.php
// GET ?action=get&id=<match_id>
// Returns a single match row by its primary key.
// ─────────────────────────────────────────────────────────────
$id   = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT * FROM matches WHERE id = ?");
$stmt->execute([$id]);
$row  = $stmt->fetch();
echo json_encode($row
    ? ['success' => true, 'data' => $row]
    : ['error' => 'Not found']
);
