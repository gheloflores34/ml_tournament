<?php
// api/matches/add_match.php
// POST ?action=create
// Inserts a new match record (with optional team logos) and
// pre-creates empty player slots for both teams.
// ─────────────────────────────────────────────────────────────
$team_a  = trim($_POST['team_a']  ?? '');
$team_b  = trim($_POST['team_b']  ?? '');
$score_a = (int)($_POST['score_a'] ?? 0);
$score_b = (int)($_POST['score_b'] ?? 0);
$winner  = trim($_POST['winner']  ?? '');
$round   = trim($_POST['round']   ?? '');
$flag_a  = sanitizeCountryCode(trim($_POST['flag_a'] ?? ''));
$flag_b  = sanitizeCountryCode(trim($_POST['flag_b'] ?? ''));

if (!$team_a || !$team_b || !$winner || !$round) {
    echo json_encode(['error' => 'All fields are required']); return;
}

$img_a = (isset($_FILES['team_a_img']) && $_FILES['team_a_img']['error'] === 0)
    ? uploadImage($_FILES['team_a_img'], 'team_a') : null;
$img_b = (isset($_FILES['team_b_img']) && $_FILES['team_b_img']['error'] === 0)
    ? uploadImage($_FILES['team_b_img'], 'team_b') : null;

$stmt = $db->prepare(
    "INSERT INTO matches (team_a,team_b,team_a_img,team_b_img,score_a,score_b,winner,round,flag_a,flag_b)
     VALUES (?,?,?,?,?,?,?,?,?,?)"
);
$stmt->execute([$team_a, $team_b, $img_a, $img_b, $score_a, $score_b, $winner, $round, $flag_a, $flag_b]);

$newId = (int)$db->lastInsertId();
ensurePlayerSlots($db, $newId);

echo json_encode(['success' => true, 'id' => $newId]);
