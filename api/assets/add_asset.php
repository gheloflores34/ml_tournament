<?php
// api/assets/add_asset.php
// POST ?action=upload_asset
// Uploads a new hero / role / badge image and inserts a record.
// ─────────────────────────────────────────────────────────────
$type       = trim($_POST['type']       ?? '');
$name       = trim($_POST['name']       ?? '');
$hero_class = trim($_POST['hero_class'] ?? '');

if (!in_array($type, ['hero', 'role', 'badge'])) {
    echo json_encode(['error' => 'Invalid asset type']); return;
}
if (!$name) {
    echo json_encode(['error' => 'Name is required']); return;
}
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    echo json_encode(['error' => 'File upload failed']); return;
}

$allowed_classes = ['Tank', 'Fighter', 'Assassin', 'Mage', 'Marksman', 'Support', ''];
if ($type !== 'hero') {
    $hero_class = '';
} elseif (!in_array($hero_class, $allowed_classes)) {
    $hero_class = '';
}

$filename = uploadImage($_FILES['file'], 'asset_' . $type);
if (!$filename) {
    echo json_encode(['error' => 'Invalid file (max 2MB, jpg/png/gif/webp)']); return;
}

$stmt = $db->prepare("INSERT INTO assets (type, name, filename, hero_class) VALUES (?,?,?,?)");
$stmt->execute([$type, $name, $filename, $hero_class]);
echo json_encode(['success' => true, 'id' => $db->lastInsertId(), 'filename' => $filename]);
