<?php
// api/matches/list_rounds.php
// GET ?action=rounds
// Returns the distinct round names stored in the matches table.
// ─────────────────────────────────────────────────────────────
$stmt = $db->query("SELECT DISTINCT round FROM matches ORDER BY round");
echo json_encode(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)]);
