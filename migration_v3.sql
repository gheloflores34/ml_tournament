-- ============================================================
-- ml_tournament1 — Schema Migration v3
-- Run this ONCE against your existing database.
-- Safe to run on a fresh install too (uses IF NOT EXISTS / IF).
-- ============================================================

-- ── 1. assets table: add hero_class column ──────────────────
ALTER TABLE `assets`
  ADD COLUMN IF NOT EXISTS `hero_class` VARCHAR(50) NOT NULL DEFAULT ''
  AFTER `filename`;

-- Update existing hero assets that have no class (optional starter mapping)
-- You can customise these to match your real hero roster.
UPDATE `assets` SET `hero_class` = 'Assassin'  WHERE `type` = 'hero' AND `name` IN ('Selena','Aamon','Benedetta','Lancelot','Hayabusa','Natalia','Karina','Helcurt','Fanny','Gusion','Ling');
UPDATE `assets` SET `hero_class` = 'Fighter'   WHERE `type` = 'hero' AND `name` IN ('Khaleed','Lapu-Lapu','Paquito','Yu Zhong','Chou','Aulus','Barats','Ruby','Sun','Lukas','Phovious');
UPDATE `assets` SET `hero_class` = 'Mage'      WHERE `type` = 'hero' AND `name` IN ('Harith','Yve','Cyclops','Kagura','Lou Yi','Obsidia','Zetian','Kalea','Suyou','Sora','Hirara');
UPDATE `assets` SET `hero_class` = 'Marksman'  WHERE `type` = 'hero' AND `name` IN ('Yi Sun-Shin','Brody','Natan','Beatrix','Moskov');
UPDATE `assets` SET `hero_class` = 'Support'   WHERE `type` = 'hero' AND `name` IN ('Estes','Mathilda','Floryn');
UPDATE `assets` SET `hero_class` = 'Tank'      WHERE `type` = 'hero' AND `name` IN ('Edith','Grock','Baxia','Gloo','Jhonson','Franco','Hylos','Tigreal');

-- ── 2. matches table: flag columns ──────────────────────────
ALTER TABLE `matches`
  ADD COLUMN IF NOT EXISTS `flag_a` VARCHAR(5) NOT NULL DEFAULT ''
  AFTER `round`;

ALTER TABLE `matches`
  ADD COLUMN IF NOT EXISTS `flag_b` VARCHAR(5) NOT NULL DEFAULT ''
  AFTER `flag_a`;

-- ── 3. match_players table: hero_name, role_img, role_name ──
ALTER TABLE `match_players`
  ADD COLUMN IF NOT EXISTS `hero_name` VARCHAR(100) NOT NULL DEFAULT ''
  AFTER `hero_img`;

ALTER TABLE `match_players`
  ADD COLUMN IF NOT EXISTS `role_img` VARCHAR(255) DEFAULT NULL
  AFTER `hero_name`;

ALTER TABLE `match_players`
  ADD COLUMN IF NOT EXISTS `role_name` VARCHAR(100) NOT NULL DEFAULT ''
  AFTER `role_img`;

-- ── 4. Backfill hero_name from existing hero_img filenames ──
--    (links asset filenames to names automatically)
UPDATE `match_players` mp
  INNER JOIN `assets` a ON a.filename = mp.hero_img AND a.type = 'hero'
  SET mp.hero_name = a.name
  WHERE mp.hero_img IS NOT NULL AND mp.hero_name = '';

UPDATE `match_players` mp
  INNER JOIN `assets` a ON a.filename = mp.role_img AND a.type = 'role'
  SET mp.role_name = a.name
  WHERE mp.role_img IS NOT NULL AND mp.role_name = '';

-- ── Done ─────────────────────────────────────────────────────
-- Your schema is now v3-compatible.
-- ─────────────────────────────────────────────────────────────
