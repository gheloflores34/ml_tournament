<?php
// api/matches/save_players.php
// POST ?action=save_players
// Bulk-updates all 10 player rows for a match (5 per side).
// Hero / role images are validated against the assets table before saving.
// ─────────────────────────────────────────────────────────────────────────
$matchId = (int)($_POST['match_id'] ?? 0);
if (!$matchId) {
    echo json_encode(['error' => 'Missing match_id']); return;
}

// Make sure all 10 slots exist (idempotent)
ensurePlayerSlots($db, $matchId);

// Build a map of existing slot → row id
$stmt = $db->prepare("SELECT id, team_side, slot FROM match_players WHERE match_id=?");
$stmt->execute([$matchId]);
$existing = [];
foreach ($stmt->fetchAll() as $r) {
    $existing[$r['team_side']][$r['slot']] = $r['id'];
}

$upd = $db->prepare(
    "UPDATE match_players
     SET ign=?, kills=?, deaths=?, assists=?, badge=?,
         hero_img=?, hero_name=?, role_img=?, role_name=?
     WHERE id=?"
);

$allowedBadges = ['none', 'bronze', 'silver', 'gold', 'mvp', 'mvp_lose'];

foreach (['A', 'B'] as $side) {
    for ($slot = 1; $slot <= 5; $slot++) {
        $k     = $side . '_' . $slot;
        $rowId = $existing[$side][$slot] ?? null;
        if (!$rowId) continue;

        $ign          = trim($_POST['ign'][$k]           ?? '');
        $kills        = (int)($_POST['kills'][$k]        ?? 0);
        $deaths       = (int)($_POST['deaths'][$k]       ?? 0);
        $assists      = (int)($_POST['assists'][$k]      ?? 0);
        $badge        = $_POST['badge'][$k]              ?? 'none';
        $heroFilename = trim($_POST['hero_filename'][$k] ?? '');
        $heroName     = trim($_POST['hero_name'][$k]    ?? '');
        $roleFilename = trim($_POST['role_filename'][$k] ?? '');
        $roleName     = trim($_POST['role_name'][$k]    ?? '');

        if (!in_array($badge, $allowedBadges)) $badge = 'none';

        // Validate filenames against the assets table (prevents directory traversal)
        $heroImg = $heroFilename ? validateAssetFilename($db, $heroFilename) : null;
        $roleImg = $roleFilename ? validateAssetFilename($db, $roleFilename) : null;

        $upd->execute([$ign, $kills, $deaths, $assists, $badge, $heroImg, $heroName, $roleImg, $roleName, $rowId]);
    }
}

echo json_encode(['success' => true]);
