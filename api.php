<?php
// api.php — CRUD API v3 (hero_class categorization)
require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    $db = getDB();
    ensureSchema($db);

    // ── LIST MATCHES ──────────────────────────────────────────
    if ($method === 'GET' && $action === 'list') {
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

    // ── GET ONE MATCH ─────────────────────────────────────────
    } elseif ($method === 'GET' && $action === 'get') {
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        echo json_encode($row ? ['success' => true, 'data' => $row] : ['error' => 'Not found']);

    // ── GET DISTINCT ROUNDS ───────────────────────────────────
    } elseif ($method === 'GET' && $action === 'rounds') {
        $stmt = $db->query("SELECT DISTINCT round FROM matches ORDER BY round");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)]);

    // ── GET MATCH PLAYERS ─────────────────────────────────────
    } elseif ($method === 'GET' && $action === 'get_players') {
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $db->prepare(
            "SELECT * FROM match_players WHERE match_id = ? ORDER BY team_side ASC, slot ASC"
        );
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);

    // ── LIST ASSETS ───────────────────────────────────────────
    } elseif ($method === 'GET' && $action === 'list_assets') {
        ensureAssetsTable($db);
        $stmt = $db->query(
            "SELECT * FROM assets ORDER BY type ASC, hero_class ASC, name ASC"
        );
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);

    // ── CREATE MATCH ──────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'create') {
        $team_a  = trim($_POST['team_a']  ?? '');
        $team_b  = trim($_POST['team_b']  ?? '');
        $score_a = (int)($_POST['score_a'] ?? 0);
        $score_b = (int)($_POST['score_b'] ?? 0);
        $winner  = trim($_POST['winner']  ?? '');
        $round   = trim($_POST['round']   ?? '');
        $flag_a  = sanitizeCountryCode(trim($_POST['flag_a'] ?? ''));
        $flag_b  = sanitizeCountryCode(trim($_POST['flag_b'] ?? ''));

        if (!$team_a || !$team_b || !$winner || !$round) {
            echo json_encode(['error' => 'All fields are required']); exit;
        }

        $img_a = (isset($_FILES['team_a_img']) && $_FILES['team_a_img']['error'] === 0)
            ? uploadImage($_FILES['team_a_img'], 'team_a') : null;
        $img_b = (isset($_FILES['team_b_img']) && $_FILES['team_b_img']['error'] === 0)
            ? uploadImage($_FILES['team_b_img'], 'team_b') : null;

        $stmt = $db->prepare(
            "INSERT INTO matches (team_a,team_b,team_a_img,team_b_img,score_a,score_b,winner,round,flag_a,flag_b)
             VALUES (?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->execute([$team_a,$team_b,$img_a,$img_b,$score_a,$score_b,$winner,$round,$flag_a,$flag_b]);
        $newId = $db->lastInsertId();
        ensurePlayerSlots($db, $newId);
        echo json_encode(['success' => true, 'id' => $newId]);

    // ── UPDATE MATCH ──────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'update') {
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
            echo json_encode(['error' => 'All fields are required']); exit;
        }

        $existing = $db->prepare("SELECT team_a_img,team_b_img FROM matches WHERE id=?");
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
            "UPDATE matches SET team_a=?,team_b=?,team_a_img=?,team_b_img=?,
             score_a=?,score_b=?,winner=?,round=?,flag_a=?,flag_b=? WHERE id=?"
        );
        $stmt->execute([$team_a,$team_b,$img_a,$img_b,$score_a,$score_b,$winner,$round,$flag_a,$flag_b,$id]);
        echo json_encode(['success' => true]);

    // ── UPLOAD ASSET (with hero_class) ────────────────────────
    } elseif ($method === 'POST' && $action === 'upload_asset') {
        ensureAssetsTable($db);
        $type       = trim($_POST['type']       ?? '');
        $name       = trim($_POST['name']       ?? '');
        $hero_class = trim($_POST['hero_class'] ?? '');

        if (!in_array($type, ['hero','role','badge'])) {
            echo json_encode(['error' => 'Invalid asset type']); exit;
        }
        if (!$name) { echo json_encode(['error' => 'Name is required']); exit; }
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            echo json_encode(['error' => 'File upload failed']); exit;
        }

        $allowed_classes = ['Tank','Fighter','Assassin','Mage','Marksman','Support',''];
        if ($type !== 'hero') $hero_class = '';
        elseif (!in_array($hero_class, $allowed_classes)) $hero_class = '';

        $filename = uploadImage($_FILES['file'], 'asset_' . $type);
        if (!$filename) {
            echo json_encode(['error' => 'Invalid file (max 2MB, jpg/png/gif/webp)']); exit;
        }

        $stmt = $db->prepare("INSERT INTO assets (type, name, filename, hero_class) VALUES (?,?,?,?)");
        $stmt->execute([$type, $name, $filename, $hero_class]);
        echo json_encode(['success' => true, 'id' => $db->lastInsertId(), 'filename' => $filename]);

    // ── UPDATE ASSET CLASS ────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'update_asset_class') {
        ensureAssetsTable($db);
        $id         = (int)($_POST['id']         ?? 0);
        $hero_class = trim($_POST['hero_class']  ?? '');
        $allowed    = ['Tank','Fighter','Assassin','Mage','Marksman','Support',''];
        if (!in_array($hero_class, $allowed)) $hero_class = '';
        $db->prepare("UPDATE assets SET hero_class=? WHERE id=? AND type='hero'")->execute([$hero_class,$id]);
        echo json_encode(['success' => true]);

    // ── DELETE ASSET ──────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'delete_asset') {
        ensureAssetsTable($db);
        $id   = (int)($_POST['id'] ?? 0);
        $stmt = $db->prepare("SELECT filename FROM assets WHERE id=?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if ($row) {
            deleteImage($row['filename']);
            $db->prepare("DELETE FROM assets WHERE id=?")->execute([$id]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Asset not found']);
        }

    // ── SAVE PLAYERS ──────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'save_players') {
        $matchId = (int)($_POST['match_id'] ?? 0);
        if (!$matchId) { echo json_encode(['error' => 'Missing match_id']); exit; }

        ensurePlayerSlots($db, $matchId);
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

        foreach (['A','B'] as $side) {
            for ($slot = 1; $slot <= 5; $slot++) {
                $k     = $side . '_' . $slot;
                $rowId = $existing[$side][$slot] ?? null;
                if (!$rowId) continue;

                $ign          = trim($_POST['ign'][$k]          ?? '');
                $kills        = (int)($_POST['kills'][$k]       ?? 0);
                $deaths       = (int)($_POST['deaths'][$k]      ?? 0);
                $assists      = (int)($_POST['assists'][$k]     ?? 0);
                $badge        = $_POST['badge'][$k]             ?? 'none';
                $heroFilename = trim($_POST['hero_filename'][$k] ?? '');
                $heroName     = trim($_POST['hero_name'][$k]    ?? '');
                $roleFilename = trim($_POST['role_filename'][$k] ?? '');
                $roleName     = trim($_POST['role_name'][$k]   ?? '');

                $allowed = ['none','bronze','silver','gold','mvp','mvp_lose'];
                if (!in_array($badge, $allowed)) $badge = 'none';

                $heroImg = $heroFilename ? validateAssetFilename($db, $heroFilename) : null;
                $roleImg = $roleFilename ? validateAssetFilename($db, $roleFilename) : null;

                $upd->execute([$ign,$kills,$deaths,$assists,$badge,$heroImg,$heroName,$roleImg,$roleName,$rowId]);
            }
        }
        echo json_encode(['success' => true]);

    // ── DELETE MATCH ──────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'delete') {
        $id   = (int)($_POST['id'] ?? 0);
        $stmt = $db->prepare("SELECT team_a_img,team_b_img FROM matches WHERE id=?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if ($row) {
            deleteImage($row['team_a_img']);
            deleteImage($row['team_b_img']);
            $db->prepare("DELETE FROM matches WHERE id=?")->execute([$id]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Record not found']);
        }

    } else {
        echo json_encode(['error' => 'Invalid request']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// ── HELPERS ───────────────────────────────────────────────────

function ensureSchema(PDO $db): void {
    ensureAssetsTable($db);

    $cols = getColumnNames($db, 'matches');
    if (!in_array('flag_a', $cols))
        $db->exec("ALTER TABLE matches ADD COLUMN flag_a VARCHAR(5) NOT NULL DEFAULT ''");
    if (!in_array('flag_b', $cols))
        $db->exec("ALTER TABLE matches ADD COLUMN flag_b VARCHAR(5) NOT NULL DEFAULT ''");

    $pcols = getColumnNames($db, 'match_players');
    if (!in_array('hero_name', $pcols))
        $db->exec("ALTER TABLE match_players ADD COLUMN hero_name VARCHAR(100) NOT NULL DEFAULT ''");
    if (!in_array('role_img', $pcols))
        $db->exec("ALTER TABLE match_players ADD COLUMN role_img VARCHAR(255) DEFAULT NULL");
    if (!in_array('role_name', $pcols))
        $db->exec("ALTER TABLE match_players ADD COLUMN role_name VARCHAR(100) NOT NULL DEFAULT ''");
}

function getColumnNames(PDO $db, string $table): array {
    try {
        $stmt = $db->query("SHOW COLUMNS FROM `$table`");
        return array_column($stmt->fetchAll(), 'Field');
    } catch (Exception $e) { return []; }
}

function ensurePlayerSlots(PDO $db, int $matchId): void {
    foreach (['A','B'] as $side) {
        for ($slot = 1; $slot <= 5; $slot++) {
            $check = $db->prepare(
                "SELECT id FROM match_players WHERE match_id=? AND team_side=? AND slot=?"
            );
            $check->execute([$matchId, $side, $slot]);
            if (!$check->fetch()) {
                $db->prepare(
                    "INSERT INTO match_players (match_id,team_side,slot) VALUES (?,?,?)"
                )->execute([$matchId, $side, $slot]);
            }
        }
    }
}

function ensureAssetsTable(PDO $db): void {
    $db->exec("
        CREATE TABLE IF NOT EXISTS `assets` (
            `id`         INT(11)      NOT NULL AUTO_INCREMENT,
            `type`       ENUM('hero','role','badge') NOT NULL DEFAULT 'hero',
            `name`       VARCHAR(100) NOT NULL,
            `filename`   VARCHAR(255) NOT NULL,
            `hero_class` VARCHAR(50)  NOT NULL DEFAULT '',
            `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    $cols = getColumnNames($db, 'assets');
    if (!in_array('hero_class', $cols))
        $db->exec("ALTER TABLE `assets` ADD COLUMN `hero_class` VARCHAR(50) NOT NULL DEFAULT ''");
    try {
        $db->exec("ALTER TABLE `assets` MODIFY COLUMN `type` ENUM('hero','role','badge') NOT NULL DEFAULT 'hero'");
    } catch (Exception $e) {}
}

function validateAssetFilename(PDO $db, string $filename): ?string {
    if (!$filename) return null;
    $filename = basename($filename);
    try {
        $stmt = $db->prepare("SELECT filename FROM assets WHERE filename=? LIMIT 1");
        $stmt->execute([$filename]);
        $row = $stmt->fetch();
        return $row ? $row['filename'] : null;
    } catch (Exception $e) { return null; }
}

function sanitizeCountryCode(string $code): string {
    $code = strtoupper(preg_replace('/[^A-Za-z]/', '', $code));
    return strlen($code) === 2 ? $code : '';
}