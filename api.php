<?php
// api.php — handles all AJAX CRUD requests
require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    $db = getDB();

    // ── LIST MATCHES ─────────────────────────────────────────
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

    // ── GET ONE MATCH ────────────────────────────────────────
    } elseif ($method === 'GET' && $action === 'get') {
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        echo json_encode($row ? ['success' => true, 'data' => $row] : ['error' => 'Not found']);

    // ── GET DISTINCT ROUNDS ──────────────────────────────────
    } elseif ($method === 'GET' && $action === 'rounds') {
        $stmt = $db->query("SELECT DISTINCT round FROM matches ORDER BY round");
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_COLUMN)]);

    // ── GET MATCH PLAYERS ────────────────────────────────────
    } elseif ($method === 'GET' && $action === 'get_players') {
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $db->prepare(
            "SELECT * FROM match_players WHERE match_id = ? ORDER BY team_side ASC, slot ASC"
        );
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);

    // ── CREATE MATCH ─────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'create') {
        $team_a  = trim($_POST['team_a']  ?? '');
        $team_b  = trim($_POST['team_b']  ?? '');
        $score_a = (int)($_POST['score_a'] ?? 0);
        $score_b = (int)($_POST['score_b'] ?? 0);
        $winner  = trim($_POST['winner']  ?? '');
        $round   = trim($_POST['round']   ?? '');

        if (!$team_a || !$team_b || !$winner || !$round) {
            echo json_encode(['error' => 'All fields are required']); exit;
        }

        $img_a = (isset($_FILES['team_a_img']) && $_FILES['team_a_img']['error'] === 0)
            ? uploadImage($_FILES['team_a_img'], 'team_a') : null;
        $img_b = (isset($_FILES['team_b_img']) && $_FILES['team_b_img']['error'] === 0)
            ? uploadImage($_FILES['team_b_img'], 'team_b') : null;

        $stmt = $db->prepare(
            "INSERT INTO matches (team_a,team_b,team_a_img,team_b_img,score_a,score_b,winner,round)
             VALUES (?,?,?,?,?,?,?,?)"
        );
        $stmt->execute([$team_a, $team_b, $img_a, $img_b, $score_a, $score_b, $winner, $round]);
        $newId = $db->lastInsertId();

        // Insert blank player rows (5 per side) so edit always has rows to work with
        ensurePlayerSlots($db, $newId);

        echo json_encode(['success' => true, 'id' => $newId]);

    // ── UPDATE MATCH ─────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'update') {
        $id      = (int)($_POST['id']     ?? 0);
        $team_a  = trim($_POST['team_a']  ?? '');
        $team_b  = trim($_POST['team_b']  ?? '');
        $score_a = (int)($_POST['score_a'] ?? 0);
        $score_b = (int)($_POST['score_b'] ?? 0);
        $winner  = trim($_POST['winner']  ?? '');
        $round   = trim($_POST['round']   ?? '');

        if (!$id || !$team_a || !$team_b || !$winner || !$round) {
            echo json_encode(['error' => 'All fields are required']); exit;
        }

        $existing = $db->prepare("SELECT team_a_img,team_b_img FROM matches WHERE id=?");
        $existing->execute([$id]);
        $old = $existing->fetch();

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
             score_a=?,score_b=?,winner=?,round=? WHERE id=?"
        );
        $stmt->execute([$team_a, $team_b, $img_a, $img_b, $score_a, $score_b, $winner, $round, $id]);
        echo json_encode(['success' => true]);

    // ── SAVE PLAYERS ─────────────────────────────────────────
    // Receives: match_id, then arrays: ign[], kills[], deaths[], assists[], badge[]
    // And optionally file arrays: hero_img_A_1 .. hero_img_B_5
    } elseif ($method === 'POST' && $action === 'save_players') {
        $matchId = (int)($_POST['match_id'] ?? 0);
        if (!$matchId) { echo json_encode(['error' => 'Missing match_id']); exit; }

        // Ensure rows exist
        ensurePlayerSlots($db, $matchId);

        // Fetch existing rows keyed by side+slot
        $stmt = $db->prepare(
            "SELECT id, team_side, slot, hero_img FROM match_players WHERE match_id=?"
        );
        $stmt->execute([$matchId]);
        $existing = [];
        foreach ($stmt->fetchAll() as $r) {
            $existing[$r['team_side']][$r['slot']] = ['id' => $r['id'], 'hero_img' => $r['hero_img']];
        }

        $upd = $db->prepare(
            "UPDATE match_players
             SET ign=?, kills=?, deaths=?, assists=?, badge=?, hero_img=?
             WHERE id=?"
        );

        foreach (['A','B'] as $side) {
            for ($slot = 1; $slot <= 5; $slot++) {
                $k    = $side . '_' . $slot;
                $rowId    = $existing[$side][$slot]['id']       ?? null;
                $oldHero  = $existing[$side][$slot]['hero_img'] ?? null;
                if (!$rowId) continue;

                $ign     = trim(($_POST['ign'][$k]     ?? ''));
                $kills   = (int)($_POST['kills'][$k]   ?? 0);
                $deaths  = (int)($_POST['deaths'][$k]  ?? 0);
                $assists = (int)($_POST['assists'][$k] ?? 0);
                $badge   = $_POST['badge'][$k]          ?? 'none';
                $allowed = ['none','bronze','silver','gold','mvp'];
                if (!in_array($badge, $allowed)) $badge = 'none';

                // Hero image upload
                $fileKey = 'hero_' . $k;
                $heroImg = $oldHero;
                if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === 0) {
                    deleteImage($oldHero);
                    $heroImg = uploadImage($_FILES[$fileKey], 'hero_' . strtolower($k));
                    if (!$heroImg) $heroImg = $oldHero;
                }

                $upd->execute([$ign, $kills, $deaths, $assists, $badge, $heroImg, $rowId]);
            }
        }

        echo json_encode(['success' => true]);

    // ── DELETE MATCH ─────────────────────────────────────────
    } elseif ($method === 'POST' && $action === 'delete') {
        $id   = (int)($_POST['id'] ?? 0);
        $stmt = $db->prepare("SELECT team_a_img,team_b_img FROM matches WHERE id=?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();

        if ($row) {
            // Delete hero images too
            $pStmt = $db->prepare("SELECT hero_img FROM match_players WHERE match_id=?");
            $pStmt->execute([$id]);
            foreach ($pStmt->fetchAll() as $p) { deleteImage($p['hero_img']); }

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

// ── HELPERS ──────────────────────────────────────────────
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
