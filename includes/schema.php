<?php
// includes/schema.php — Idempotent schema bootstrap
// Extracted from api.php so any entry-point can call ensureSchema().
// ============================================================

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
