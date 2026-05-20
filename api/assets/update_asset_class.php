<?php
// api/assets/update_asset_class.php
// POST ?action=update_asset_class
// Updates the hero_class field on an existing hero asset.
// ─────────────────────────────────────────────────────────
$id         = (int)($_POST['id']        ?? 0);
$hero_class = trim($_POST['hero_class'] ?? '');
$allowed    = ['Tank', 'Fighter', 'Assassin', 'Mage', 'Marksman', 'Support', ''];

if (!in_array($hero_class, $allowed)) {
    $hero_class = '';
}

$db->prepare("UPDATE assets SET hero_class=? WHERE id=? AND type='hero'")
   ->execute([$hero_class, $id]);

echo json_encode(['success' => true]);
