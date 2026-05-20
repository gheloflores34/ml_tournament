<?php
// api/api.php — Main Router (v3 Modular)
// ============================================================
// All requests from index.php land here.
// This file ONLY handles headers, schema bootstrap, and routing.
// Business logic lives in the action-specific files below.
// ============================================================

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/schema.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    $db = getDB();
    ensureSchema($db); // idempotent — safe on every request

    // ── Route table ──────────────────────────────────────────
    //   GET  actions  →  api/assets/ or api/matches/
    //   POST actions  →  same folders
    // ---------------------------------------------------------
    $routes = [
        // Matches — GET
        'GET:list'        => __DIR__ . '/matches/list_matches.php',
        'GET:get'         => __DIR__ . '/matches/get_match.php',
        'GET:rounds'      => __DIR__ . '/matches/list_rounds.php',
        'GET:get_players' => __DIR__ . '/matches/get_players.php',
        // Matches — POST
        'POST:create'     => __DIR__ . '/matches/add_match.php',
        'POST:update'     => __DIR__ . '/matches/update_match.php',
        'POST:delete'     => __DIR__ . '/matches/delete_match.php',
        'POST:save_players' => __DIR__ . '/matches/save_players.php',
        // Assets — GET
        'GET:list_assets' => __DIR__ . '/assets/list_assets.php',
        // Assets — POST
        'POST:upload_asset'      => __DIR__ . '/assets/add_asset.php',
        'POST:update_asset_class'=> __DIR__ . '/assets/update_asset_class.php',
        'POST:delete_asset'      => __DIR__ . '/assets/delete_asset.php',
    ];

    $key = $method . ':' . $action;

    if (isset($routes[$key])) {
        require $routes[$key];
    } else {
        echo json_encode(['error' => 'Invalid action: ' . htmlspecialchars($action)]);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
