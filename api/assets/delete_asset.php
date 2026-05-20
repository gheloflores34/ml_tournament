<?php
// api/assets/delete_asset.php
// POST ?action=delete_asset
// Removes an asset record and its uploaded file from disk.
// ─────────────────────────────────────────────────────────
$id   = (int)($_POST['id'] ?? 0);
$stmt = $db->prepare("SELECT filename FROM assets WHERE id=?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if ($row) {
    deleteImage($row['filename']);
    $db->prepare("DELETE FROM assets WHERE id=?")->execute([$id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Asset not found']);
}
