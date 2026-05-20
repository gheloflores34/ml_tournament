<?php
// api/assets/list_assets.php
// GET ?action=list_assets
// Returns all assets ordered by type → hero_class → name.
// ─────────────────────────────────────────────────────────
$stmt = $db->query(
    "SELECT * FROM assets ORDER BY type ASC, hero_class ASC, name ASC"
);
echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
