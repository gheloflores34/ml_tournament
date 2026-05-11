-- ============================================
-- Mobile Legends Tournament System
-- Database Setup Script
-- Run this in MySQL / phpMyAdmin / VSCode DB
-- ============================================

CREATE DATABASE IF NOT EXISTS ml_tournament
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ml_tournament;

-- ── MATCHES TABLE ─────────────────────────────
CREATE TABLE IF NOT EXISTS matches (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  team_a      VARCHAR(100)  NOT NULL,
  team_b      VARCHAR(100)  NOT NULL,
  team_a_img  VARCHAR(255)  DEFAULT NULL,
  team_b_img  VARCHAR(255)  DEFAULT NULL,
  score_a     INT           NOT NULL DEFAULT 0,
  score_b     INT           NOT NULL DEFAULT 0,
  winner      VARCHAR(100)  NOT NULL,
  round       VARCHAR(50)   NOT NULL,
  created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── MATCH PLAYERS TABLE ───────────────────────
-- Stores per-player detail rows (5 per team = 10 per match)
CREATE TABLE IF NOT EXISTS match_players (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  match_id    INT           NOT NULL,
  team_side   ENUM('A','B') NOT NULL,
  slot        TINYINT       NOT NULL DEFAULT 1,  -- 1-5 player slot per team
  ign         VARCHAR(100)  NOT NULL DEFAULT '',
  hero_img    VARCHAR(255)  DEFAULT NULL,         -- uploaded hero portrait
  kills       TINYINT       NOT NULL DEFAULT 0,
  deaths      TINYINT       NOT NULL DEFAULT 0,
  assists     TINYINT       NOT NULL DEFAULT 0,
  badge       ENUM('none','bronze','silver','gold','mvp') NOT NULL DEFAULT 'none',
  FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── SAMPLE DATA ───────────────────────────────
INSERT INTO matches (team_a, team_b, score_a, score_b, winner, round) VALUES
  ('Onic PH', 'RORA PH',  2, 0, 'Onic PH', 'Quarter Finals'),
  ('Falcon',   'BlackList International',   0, 2, 'BlackList International',    'Quarter Finals');

-- ============================================
-- CRUD Reference Queries (for VSCode SQLTools)
-- ============================================

-- View all matches
-- SELECT * FROM matches ORDER BY created_at DESC;

-- View players for match id=1
-- SELECT * FROM match_players WHERE match_id=1 ORDER BY team_side, slot;

-- Delete match (cascades to match_players)
-- DELETE FROM matches WHERE id=1;

-- Update a player row
-- UPDATE match_players SET kills=5, deaths=2, assists=10, badge='mvp' WHERE id=1;
