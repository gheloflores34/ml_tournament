# 🏆 Mobile Legends Tournament Results System

## Requirements
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.4+
- Apache / Nginx (XAMPP, WAMP, or Laragon recommended)

---

## Setup Steps

### 1. Database
1. Open VSCode → install **SQLTools** + **SQLTools MySQL Driver** (see `.vscode/extensions.json`)
2. Connect to your local MySQL (host: `localhost`, user: `root`, no password by default in XAMPP)
3. Open `database.sql` and run it — this creates the DB and table

### 2. Configure Connection
Edit `includes/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');   // your MySQL user
define('DB_PASS', '');       // your MySQL password
define('DB_NAME', 'ml_tournament');
```

### 3. Run the App
- Place the `ml_tournament/` folder inside `htdocs/` (XAMPP) or `www/` (WAMP)
- Start Apache + MySQL in XAMPP/WAMP
- Open browser: `http://localhost/ml_tournament/`

---

## File Structure
```
ml_tournament/
├── index.php           ← Main UI (Frontend)
├── api.php             ← CRUD API (Backend)
├── ml_logo.png         ← Mobile Legends logo
├── database.sql        ← SQL setup script (run once)
├── uploads/            ← Team logo images (auto-used)
├── includes/
│   └── config.php      ← DB config & helpers
└── .vscode/
    ├── settings.json   ← VSCode settings
    └── extensions.json ← Recommended extensions
```

---

## Features
- ✅ Add / Edit / Delete match records
- ✅ Upload team logos (Team A & Team B)
- ✅ Display logos in results table & winner badge
- ✅ Filter by round
- ✅ Search by team name or winner
- ✅ Live stats (total matches, rounds, teams)
- ✅ Blue & Dark Blue theme with ML branding
