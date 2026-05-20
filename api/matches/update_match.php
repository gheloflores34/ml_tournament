<?php
// api/matches/update_match.php
// POST ?action=update
// Updates an existing match. Re-uses old team logo if no new file is uploaded;
// deletes the old file from disk when replaced.
// ─────────────────────────────────────────────────────────────────────────────
$id      = (int)($_POST['id']      ?? 0);
$team_a  = trim($_POST['team_a']   ?? '');
$team_b  = trim($_POST['team_b']   ?? '');
$score_a = (int)($_POST['score_a'] ?? 0);
$score_b = (int)($_POST['score_b'] ?? 0);
$winner  = trim($_POST['winner']   ?? '');
$round   = trim($_POST['round']    ?? '');
$flag_a  = sanitizeCountryCode(trim($_POST['flag_a'] ?? ''));
$flag_b  = sanitizeCountryCode(trim($_POST['flag_b'] ?? ''));

if (!$id || !$team_a || !$team_b || !$winner || !$round) {
    echo json_encode(['error' => 'All fields are required']); return;
}

// Fetch current logo filenames so we can preserve or clean up
$existing = $db->prepare("SELECT team_a_img, team_b_img FROM matches WHERE id=?");
$existing->execute([$id]);
$old   = $existing->fetch();
$img_a = $old['team_a_img'];
$img_b = $old['team_b_img'];

if (isset($_FILES['team_a_img']) && $_FILES['team_a_img']['error'] === 0) {
    deleteImage($old['team_a_img']);
    $img_a = uploadImage($_FILES['team_a_img'], 'team_a');
}
if (isset($_FILES['team_b_img']) && $_FILES['team_b_img']['error'] === 0) {
    deleteImage($old['team_b_img']);
    $img_b = uploadImage($_FILES['team_b_img'], 'team_b');
}

$stmt = $db->prepare(
    "UPDATE matches
     SET team_a=?, team_b=?, team_a_img=?, team_b_img=?,
         score_a=?, score_b=?, winner=?, round=?, flag_a=?, flag_b=?
     WHERE id=?"
);
$stmt->execute([$team_a, $team_b, $img_a, $img_b, $score_a, $score_b, $winner, $round, $flag_a, $flag_b, $id]);

echo json_encode(['success' => true]);
