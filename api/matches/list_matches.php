<?php
// api/matches/list_matches.php
// GET ?action=list[&search=][&round=]
// Returns all matches, optionally filtered by search term and/or round.
// ─────────────────────────────────────────────────────────────────────
$search = trim($_GET['search'] ?? '');
$round  = trim($_GET['round']  ?? '');

$sql    = "SELECT * FROM matches WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql .= " AND (team_a LIKE :s OR team_b LIKE :s2 OR winner LIKE :s3)";
    $params[':s'] = $params[':s2'] = $params[':s3'] = "%$search%";
}
if ($round !== '') {
    $sql .= " AND round = :round";
    $params[':round'] = $round;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
