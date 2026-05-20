<?php
// api/matches/get_players.php
// GET ?action=get_players&id=<match_id>
// Returns all player rows for a match, ordered by team side then slot.
// ─────────────────────────────────────────────────────────────────────
$id   = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare(
    "SELECT * FROM match_players WHERE match_id = ? ORDER BY team_side ASC, slot ASC"
);
$stmt->execute([$id]);
echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
