<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ML Tournament — Soul Photographer</title>
  <link rel="icon" type="image/png" href="ml_logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Exo+2:wght@300;400;600;700&family=Rajdhani:wght@400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════
   ROOT TOKENS
══════════════════════════════════════════════ */
:root {
  --void:     #010710;
  --deep:     #030e1f;
  --mid:      #061628;
  --glass:    rgba(6,18,44,.38);
  --glassbtn: rgba(255,255,255,.05);
  --border:   rgba(30,80,155,.4);
  --border2:  rgba(60,130,210,.5);
  --borderg:  rgba(255,255,255,.08);
  --blue:     #1565c0;
  --blue2:    #1976d2;
  --blue3:    #2196f3;
  --accent:   #42a5f5;
  --bright:   #90caf9;
  --plat:     #d4dce8;
  --silver:   #b8c8d8;
  --muted:    #4a6a90;
  --muted2:   #6a8aaa;
  --gold:     #e8c96a;
  --gold2:    #d4a82a;
  --gold3:    #f0d888;
  --glowG:    rgba(212,168,42,.55);
  --win:      #48d890;
  --bronze-c: #c87850;
  --silver-c: #90a8b8;
  --gold-c:   #d4a82a;
  --mvp-c:    #f0d888;
  --hdr-h:    70px;
  --nav-h:    52px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
  background: var(--void) url('Backgroundyes.png') center center / cover fixed no-repeat;
  color: var(--plat);
  font-family: 'Exo 2', sans-serif;
  min-height: 100vh;
  overflow-x: hidden;
  padding-top: calc(var(--hdr-h) + var(--nav-h));
}

/* Atmospheric dark overlay */
body::before {
  content: '';
  position: fixed; inset: 0;
  background:
    linear-gradient(180deg,rgba(0,5,14,.75) 0%,rgba(0,8,20,.50) 35%,rgba(0,5,14,.65) 100%),
    radial-gradient(ellipse 70% 50% at 50% 20%,rgba(30,90,200,.18) 0%,transparent 60%);
  pointer-events: none; z-index: 0;
}
/* Subtle grid lines */
body::after {
  content: '';
  position: fixed; inset: 0;
  background:
    radial-gradient(ellipse 100% 100% at 50% 50%, transparent 55%, rgba(0,3,10,.72) 100%);
  pointer-events: none; z-index: 0;
}

/* ══ INTRO VIDEO ════════════════════════════ */
#intro-screen {
  position: fixed; inset: 0; z-index: 9999;
  background: #000;
  display: flex; align-items: center; justify-content: center;
  transition: opacity .9s cubic-bezier(.4,0,1,1);
}
#intro-screen.fade-out { opacity: 0; pointer-events: none; }
#intro-screen.hidden   { display: none; }
#intro-video { width:100%;height:100%;object-fit:cover; }
#intro-skip {
  position: absolute; bottom: 32px; right: 36px;
  background: var(--glassbtn);
  border: 1px solid rgba(255,255,255,.12);
  color: rgba(255,255,255,.65);
  padding: 9px 24px;
  font-family: 'Rajdhani', sans-serif;
  font-size: .8rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase;
  border-radius: 6px; cursor: pointer;
  backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
  transition: border-color .2s, color .2s;
}
#intro-skip:hover { border-color: rgba(255,255,255,.45); color: #fff; }
/* Fallback splash */
#intro-fallback {
  position: absolute; inset: 0;
  display: none; flex-direction: column; align-items: center; justify-content: center; gap: 20px;
  background: linear-gradient(160deg, #010913, #020d20, #030e1f);
}
#intro-fallback img { width:110px; filter:drop-shadow(0 0 28px rgba(66,165,245,.85)); animation: logoGlow 2.2s ease-in-out infinite; }
.if-title {
  font-family:'Cinzel',serif; font-size: clamp(1.4rem,4vw,2.6rem); font-weight:900;
  letter-spacing:.15em; text-transform:uppercase;
  background: linear-gradient(135deg,var(--gold3),var(--gold),var(--gold3));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.if-sub { font-family:'Rajdhani',sans-serif; font-size:.88rem; letter-spacing:.3em; color:var(--muted); text-transform:uppercase; }
.intro-bar-wrap { width:260px; height:2px; background:rgba(255,255,255,.1); border-radius:2px; overflow:hidden; }
.intro-bar { height:100%; width:0; background:linear-gradient(90deg,var(--blue3),var(--gold)); animation:introLoad 2.5s linear forwards; }
@keyframes introLoad { to { width:100%; } }

/* ══ HEADER ═════════════════════════════════ */
#site-header {
  position:fixed; top:0; left:0; right:0; height:var(--hdr-h);
  background: linear-gradient(180deg,rgba(2,8,24,.88) 0%,rgba(4,14,36,.72) 100%);
  border-bottom: 1px solid rgba(66,140,255,.22);
  backdrop-filter: blur(28px) saturate(1.4); -webkit-backdrop-filter: blur(28px) saturate(1.4);
  z-index: 100;
  display:flex; align-items:center; gap:14px; padding:0 28px;
  box-shadow: 0 4px 40px rgba(0,0,0,.55), inset 0 -1px 0 rgba(30,80,200,.15);
}
#site-header::before {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  background: linear-gradient(90deg,transparent,rgba(66,165,245,.35),rgba(212,168,42,.6),rgba(66,165,245,.35),transparent);
}
.hdr-logo { width:44px;height:44px; filter:drop-shadow(0 0 14px rgba(66,165,245,.85)) brightness(1.3); animation:logoGlow 3.6s ease-in-out infinite; flex-shrink:0; }
@keyframes logoGlow {
  0%,100% { filter:drop-shadow(0 0 14px rgba(66,165,245,.7)) brightness(1.25); }
  50%      { filter:drop-shadow(0 0 32px rgba(100,181,246,1)) brightness(1.55); }
}
.hdr-title {
  font-family:'Cinzel',serif; font-size:clamp(.9rem,2.4vw,1.4rem); font-weight:700; letter-spacing:.2em; text-transform:uppercase;
  background:linear-gradient(135deg,var(--gold3),var(--gold),var(--gold3));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
  filter:drop-shadow(0 0 18px rgba(212,168,42,.35));
}
.hdr-sep { width:1px; height:26px; background:rgba(30,80,155,.4); flex-shrink:0; }
.hdr-sub { font-family:'Rajdhani',sans-serif; font-size:.68rem; letter-spacing:.3em; color:var(--muted); text-transform:uppercase; }
.hdr-spacer { flex:1; }
/* Glass action buttons in header */
.hdr-btn {
  display:inline-flex; align-items:center; gap:7px;
  padding:8px 18px;
  background: var(--glassbtn);
  border: 1px solid var(--borderg);
  backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px);
  border-radius:8px; color:var(--plat);
  font-family:'Rajdhani',sans-serif; font-size:.8rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
  cursor:pointer; transition:all .2s; white-space:nowrap; flex-shrink:0;
}
.hdr-btn:hover { background:rgba(255,255,255,.09); border-color:rgba(255,255,255,.2); }
.hdr-btn.gold  { border-color:rgba(212,168,42,.25); color:var(--gold3); }
.hdr-btn.gold:hover { background:rgba(212,168,42,.1); border-color:rgba(212,168,42,.45); }
.hdr-btn.primary { border-color:rgba(66,165,245,.28); color:var(--bright); }
.hdr-btn.primary:hover { background:rgba(66,165,245,.12); border-color:rgba(66,165,245,.5); }

/* ══ NAV ════════════════════════════════════ */
#site-nav {
  position:fixed; top:var(--hdr-h); left:0; right:0; height:var(--nav-h);
  background: linear-gradient(180deg,rgba(2,8,24,.72) 0%,rgba(2,10,28,.55) 100%);
  border-bottom: 1px solid rgba(30,80,155,.22);
  backdrop-filter:blur(22px) saturate(1.3); -webkit-backdrop-filter:blur(22px) saturate(1.3);
  z-index:99;
  display:flex; align-items:center; gap:10px; padding:0 22px;
  box-shadow: 0 2px 20px rgba(0,0,0,.35);
}
.round-filters { display:flex; gap:6px; flex:1; flex-wrap:wrap; overflow:hidden; }
.rf-pill {
  padding:5px 15px;
  background: linear-gradient(135deg,rgba(8,20,52,.6),rgba(5,12,35,.7));
  border: 1px solid rgba(40,90,180,.22);
  backdrop-filter:blur(12px) saturate(1.2);
  border-radius:20px;
  font-family:'Rajdhani',sans-serif; font-size:.76rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
  color:var(--muted2); cursor:pointer; transition:all .22s cubic-bezier(.16,1,.3,1); white-space:nowrap;
  box-shadow: 0 1px 8px rgba(0,0,0,.3), inset 0 1px 0 rgba(255,255,255,.05);
  position:relative; overflow:hidden;
}
.rf-pill::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.06) 0%,transparent 55%); pointer-events:none; border-radius:20px; }
.rf-pill:hover { background:linear-gradient(135deg,rgba(14,38,95,.7),rgba(9,24,65,.8)); border-color:rgba(66,165,245,.38); color:var(--accent); transform:translateY(-1px); box-shadow:0 3px 14px rgba(0,0,0,.4),0 0 10px rgba(66,165,245,.1); }
.rf-pill.active { background:linear-gradient(135deg,rgba(20,60,150,.72),rgba(14,42,110,.82)); border-color:rgba(66,165,245,.5); color:var(--bright); box-shadow:0 3px 18px rgba(0,0,0,.45),0 0 18px rgba(66,165,245,.18),inset 0 1px 0 rgba(100,180,255,.1); }
.nav-search { position:relative; flex-shrink:0; }
.nav-search input {
  background:var(--glassbtn); border:1px solid var(--borderg); color:var(--plat);
  padding:7px 12px 7px 32px; border-radius:8px;
  font-family:'Exo 2',sans-serif; font-size:.82rem; outline:none; width:190px;
  backdrop-filter:blur(10px);
  transition:border-color .2s, box-shadow .2s;
}
.nav-search input:focus { border-color:rgba(66,165,245,.4); box-shadow:0 0 0 2px rgba(66,165,245,.08); }
.nav-search input::placeholder { color:var(--muted); }
.nav-search::before { content:'⌕'; position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.95rem; color:var(--muted); pointer-events:none; }

/* ══ WRAP ════════════════════════════════════ */
.wrap { max-width:1440px; margin:0 auto; padding:28px 20px 90px; position:relative; z-index:1; }

/* Stats */
.stats { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:36px; }
.stat {
  flex:1; min-width:100px;
  background:var(--glass); border:1px solid var(--borderg);
  border-radius:14px; padding:14px 18px; text-align:center;
  backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
  transition:border-color .25s, transform .2s;
}
.stat:hover { border-color:rgba(212,168,42,.35); transform:translateY(-2px); }
.stat-n { font-family:'Cinzel',serif; font-size:2rem; font-weight:700; color:var(--gold); line-height:1; text-shadow:0 0 22px rgba(212,168,42,.4); }
.stat-l { font-family:'Rajdhani',sans-serif; font-size:.66rem; letter-spacing:.22em; color:var(--muted); text-transform:uppercase; margin-top:5px; }

.section-hdr { display:flex; align-items:center; gap:14px; margin-bottom:30px; }
.section-hdr-line { height:1px; flex:1; background:linear-gradient(90deg,var(--border),transparent); }
.section-hdr-txt { font-family:'Cinzel',serif; font-size:.58rem; font-weight:700; letter-spacing:.26em; text-transform:uppercase; color:var(--muted); white-space:nowrap; }

/* ══════════════════════════════════════════════
   ISOLATED CAROUSEL — one card, no bleed
══════════════════════════════════════════════ */
.carousel-outer {
  position:relative;
  display:flex; align-items:center; justify-content:center;
  padding:60px 0 48px;
  overflow:hidden;
  min-height:460px;
}
/* Aggressive side blackout — hide adjacent cards completely */
.carousel-outer::before, .carousel-outer::after {
  content:''; position:absolute; top:0; bottom:0; width:40%;
  z-index:10; pointer-events:none;
}
.carousel-outer::before { left:0;  background:linear-gradient(90deg, var(--void) 0%,rgba(1,7,16,.99) 60%,transparent 100%); }
.carousel-outer::after  { right:0; background:linear-gradient(270deg,var(--void) 0%,rgba(1,7,16,.99) 60%,transparent 100%); }

.carousel-track-wrap { overflow:hidden; width:100%; clip-path:inset(0); }
.carousel-track { display:flex; transition:transform .55s cubic-bezier(.4,0,.2,1); will-change:transform; align-items:center; }

/* ── MATCH CARD ── */
.match-card {
  flex:0 0 var(--card-w,700px);
  cursor:pointer; position:relative;
  transition:transform .5s cubic-bezier(.4,0,.2,1), opacity .5s;
  padding:0 18px; user-select:none;
}
/* Adjacent & far cards: invisible + unclickable */
.match-card.side   { transform:scale(.55); opacity:0; pointer-events:none; }
.match-card.adj    { transform:scale(.7);  opacity:0; pointer-events:none; }
.match-card.center { transform:scale(1);   opacity:1; pointer-events:auto; }

/* Ghost logos 200%+ atmospheric */
.card-ghost-wrap { position:absolute; inset:-50px; pointer-events:none; overflow:hidden; border-radius:28px; z-index:0; }
.ghost-logo { position:absolute; top:50%; transform:translateY(-50%); width:400px; height:400px; object-fit:contain; opacity:.13; filter:blur(16px) saturate(2.4) brightness(.85); }
.ghost-logo.a { left:-110px; }
.ghost-logo.b { right:-110px; }
.ghost-ph { position:absolute; top:50%; transform:translateY(-50%); font-family:'Cinzel',serif; font-size:8rem; font-weight:900; color:var(--accent); opacity:.055; }
.ghost-ph.a { left:-20px; }
.ghost-ph.b { right:-20px; }

/* ── ZERO-BOX card: everything floats on background ── */
.card-inner {
  position:relative; z-index:2;
  padding:36px 40px 38px;
  text-align:center;
  /* No solid background — purely transparent glass */
  background: linear-gradient(160deg,rgba(4,14,38,.55),rgba(1,7,22,.48));
  border: 1px solid rgba(80,140,255,.14);
  border-radius:24px;
  backdrop-filter:blur(22px) saturate(1.5); -webkit-backdrop-filter:blur(22px) saturate(1.5);
  box-shadow:0 8px 60px rgba(0,0,0,.55), 0 0 0 1px rgba(255,255,255,.04), inset 0 1px 0 rgba(255,255,255,.06);
}
/* Faint top shimmer */
.card-inner::before {
  content:''; position:absolute; top:0; left:18px; right:18px; height:1px;
  background:linear-gradient(90deg,transparent,rgba(212,168,42,.35),rgba(66,165,245,.25),rgba(212,168,42,.35),transparent);
}
/* Diagonal split graphic behind VS — Team A blue / Team B red tinge */
.card-split {
  position:absolute; inset:0; border-radius:24px; overflow:hidden; pointer-events:none; z-index:1;
}
.card-split::before {
  content:''; position:absolute; inset:0;
  background: linear-gradient(105deg,
    rgba(21,101,192,.1) 0%, rgba(21,101,192,.06) 42%,
    transparent 50%,
    rgba(100,30,30,.06) 58%, rgba(100,30,30,.1) 100%
  );
}
/* Angled divider line */
.card-split::after {
  content:''; position:absolute; top:0; bottom:0;
  left:50%; width:1px;
  background:linear-gradient(180deg,transparent,rgba(212,168,42,.22),rgba(255,255,255,.07),rgba(212,168,42,.22),transparent);
  transform:skewX(-8deg) translateX(-50%);
}
"
.card-header-txt { font-family:'Rajdhani',sans-serif; font-size:.68rem; font-weight:700; letter-spacing:.24em; text-transform:uppercase; color:var(--muted); margin-bottom:26px; opacity:.7; position:relative; z-index:3; }

/* Teams row */
.card-teams-row { display:flex; align-items:center; justify-content:center; gap:0; position:relative; z-index:3; }
.card-team-block { display:flex; flex-direction:column; align-items:center; gap:13px; flex:1; position:relative; }

/* Mythical Glory Trophy above winner — rendered as SVG inline */
.card-trophy {
  position:absolute; top:-54px; left:50%; transform:translateX(-50%);
  width:58px; height:58px;
  filter:drop-shadow(0 0 16px rgba(212,168,42,1)) drop-shadow(0 0 36px rgba(232,201,106,.6));
  animation:trophyFloat 2.5s ease-in-out infinite;
  z-index:6;
}
@keyframes trophyFloat {
  0%,100% { transform:translateX(-50%) translateY(0);   filter:drop-shadow(0 0 16px rgba(212,168,42,.9)); }
  50%      { transform:translateX(-50%) translateY(-6px); filter:drop-shadow(0 0 30px rgba(240,216,136,1)) drop-shadow(0 0 58px rgba(212,168,42,.55)); }
}

/* Winner gold aura */
.card-logo-aura {
  position:absolute; inset:-14px; border-radius:50%;
  background:radial-gradient(ellipse,rgba(212,168,42,.32) 0%,rgba(212,168,42,.1) 52%,transparent 72%);
  pointer-events:none;
  animation:auraBreath 2.8s ease-in-out infinite;
}
@keyframes auraBreath {
  0%,100% { opacity:.85; transform:scale(1); }
  50%      { opacity:1;   transform:scale(1.06); }
}

.card-logo-img {
  width:110px; height:110px; border-radius:50%; object-fit:cover;
  border:2px solid rgba(255,255,255,.09);
  filter:drop-shadow(0 4px 26px rgba(0,0,0,.8));
  transition:filter .35s, transform .35s;
}
.card-logo-img.is-winner {
  filter:drop-shadow(0 0 24px rgba(212,168,42,.85)) drop-shadow(0 0 50px rgba(232,201,106,.45)) brightness(1.18);
  border-color:rgba(212,168,42,.7); transform:scale(1.08);
}
.card-logo-ph {
  width:110px; height:110px; border-radius:50%;
  background:linear-gradient(135deg,rgba(14,40,74,.85),rgba(6,18,42,.9));
  border:2px solid var(--border2);
  display:flex; align-items:center; justify-content:center;
  font-family:'Cinzel',serif; font-size:1.35rem; font-weight:700; color:var(--muted);
}
.card-logo-ph.is-winner { border-color:rgba(212,168,42,.6); box-shadow:0 0 26px rgba(212,168,42,.28); }

.card-team-name { font-family:'Rajdhani',sans-serif; font-size:.9rem; font-weight:700; letter-spacing:.08em; color:var(--plat); }
.card-flag-wrap { display:flex; align-items:center; gap:6px; }
.card-flag { width:22px; height:14px; border-radius:2px; object-fit:cover; border:1px solid rgba(255,255,255,.12); }
.card-flag-code { font-family:'Rajdhani',sans-serif; font-size:.68rem; font-weight:700; letter-spacing:.08em; color:var(--muted2); }

/* ── VS Centerpiece ── */
.card-vs-block { display:flex; flex-direction:column; align-items:center; padding:0 10px; flex-shrink:0; position:relative; z-index:4; }
.vs-badge { width:76px; height:76px; }
.vs-badge svg { width:100%; height:100%; filter:drop-shadow(0 0 18px rgba(33,150,243,.6)) drop-shadow(0 0 34px rgba(212,168,42,.25)); }
.card-score-line { 
  font-family:'Orbitron',sans-serif;
  font-size:3rem; font-weight:900; line-height:1;
  display:flex; align-items:center; gap:6px; color:var(--bright);
  text-shadow:0 0 36px rgba(66,165,245,.6), 0 2px 0 rgba(0,0,0,.7);
  margin-top:10px;
}
.card-score-sep { color:rgba(255,255,255,.14); font-size:2.4rem; }

/* Footer */
.card-footer-row { display:flex; flex-direction:column; align-items:center; gap:11px; margin-top:28px; position:relative; z-index:3; }
.card-round-pill {
  background:rgba(255,255,255,.05); border:1px solid rgba(66,165,245,.18); color:var(--bright);
  padding:4px 18px; border-radius:20px;
  font-family:'Rajdhani',sans-serif; font-size:.74rem; font-weight:700; letter-spacing:.12em;
  backdrop-filter:blur(8px);
}
.card-winner-line {
  display:inline-flex; align-items:center; gap:7px;
  font-family:'Rajdhani',sans-serif; font-size:.85rem; font-weight:700; letter-spacing:.07em;
  color:var(--gold); text-shadow:0 0 14px rgba(212,168,42,.5);
}
.card-actions-row { display:flex; gap:8px; justify-content:center; }

/* ── Carousel nav ── */
.carousel-btn {
  position:absolute; top:50%; transform:translateY(-50%);
  width:44px; height:44px;
  background:var(--glassbtn); border:1px solid var(--borderg);
  backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);
  border-radius:50%; color:var(--bright); font-size:1.5rem;
  cursor:pointer; z-index:15;
  display:flex; align-items:center; justify-content:center;
  transition:all .2s;
}
.carousel-btn:hover { background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.2); }
.carousel-btn:disabled { opacity:.25; cursor:default; }
.carousel-btn.prev { left:14px; }
.carousel-btn.next { right:14px; }
.carousel-dots { display:flex; justify-content:center; gap:8px; padding:8px 0 0; }
.carousel-dot { width:7px; height:7px; border-radius:50%; background:var(--border2); cursor:pointer; transition:all .22s; }
.carousel-dot.active { background:var(--gold2); transform:scale(1.5); box-shadow:0 0 10px rgba(212,168,42,.55); }
.carousel-empty { text-align:center; padding:80px 40px; color:var(--muted); font-family:'Rajdhani',sans-serif; font-size:.92rem; letter-spacing:.06em; width:100%; }
.carousel-empty .ei { font-size:3rem; margin-bottom:14px; opacity:.35; display:block; }

/* Small glass buttons on card */
.btn {
  display:inline-flex; align-items:center; gap:5px; padding:7px 16px; border:none; border-radius:9px;
  font-family:'Rajdhani',sans-serif; font-size:.78rem; font-weight:700; letter-spacing:.09em; text-transform:uppercase;
  cursor:pointer; transition:all .25s cubic-bezier(.16,1,.3,1); white-space:nowrap; flex-shrink:0;
  position:relative; overflow:hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,.38), inset 0 1px 0 rgba(255,255,255,.06);
}
.btn::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.07) 0%,transparent 55%); pointer-events:none; }
.btn:active { transform:translateY(1px) scale(.98); }
.btn-sm { padding:5px 11px; font-size:.7rem; }
.btn-edit { background:linear-gradient(135deg,rgba(10,35,90,.7),rgba(6,22,60,.8)); border:1px solid rgba(66,165,245,.28); color:var(--accent); backdrop-filter:blur(10px); }
.btn-edit:hover { background:linear-gradient(135deg,rgba(16,50,130,.75),rgba(10,32,90,.85)); border-color:rgba(66,165,245,.55); transform:translateY(-1px); box-shadow:0 4px 18px rgba(0,0,0,.45),0 0 14px rgba(66,165,245,.16); }
.btn-del  { background:linear-gradient(135deg,rgba(70,10,10,.65),rgba(45,5,5,.75)); border:1px solid rgba(239,154,154,.24); color:#ef9a9a; backdrop-filter:blur(10px); }
.btn-del:hover { background:linear-gradient(135deg,rgba(110,15,15,.75),rgba(75,8,8,.85)); border-color:#ef9a9a; transform:translateY(-1px); box-shadow:0 4px 18px rgba(0,0,0,.45),0 0 14px rgba(239,80,80,.16); }
.btn-primary { background:linear-gradient(135deg,rgba(15,50,130,.72),rgba(10,32,90,.82)); border:1px solid rgba(66,165,245,.32); color:var(--bright); backdrop-filter:blur(10px); }
.btn-primary:hover { background:linear-gradient(135deg,rgba(22,70,180,.78),rgba(14,45,130,.88)); border-color:rgba(66,165,245,.58); transform:translateY(-1px); box-shadow:0 4px 20px rgba(0,0,0,.5),0 0 18px rgba(66,165,245,.2); }
.btn-gold { background:linear-gradient(135deg,rgba(70,48,8,.68),rgba(50,32,4,.78)); border:1px solid rgba(212,168,42,.36); color:var(--gold3); backdrop-filter:blur(10px); }
.btn-gold:hover { background:linear-gradient(135deg,rgba(100,68,10,.75),rgba(70,45,6,.85)); border-color:rgba(212,168,42,.62); transform:translateY(-1px); box-shadow:0 4px 20px rgba(0,0,0,.5),0 0 18px rgba(212,168,42,.22); }
.btn-cancel { background:linear-gradient(135deg,rgba(10,20,45,.6),rgba(6,12,30,.7)); border:1px solid rgba(255,255,255,.1); color:var(--muted2); backdrop-filter:blur(10px); }
.btn-cancel:hover { background:linear-gradient(135deg,rgba(16,30,65,.7),rgba(10,18,45,.8)); border-color:rgba(255,255,255,.2); color:var(--plat); }

/* ══════════════════════════════════════════════
   FULL-SCREEN DETAIL OVERLAY
══════════════════════════════════════════════ */
#detail-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(0,4,12,.88);
  backdrop-filter:blur(26px); -webkit-backdrop-filter:blur(26px);
  z-index:300;
  align-items:flex-start; justify-content:center;
  padding:14px; overflow-y:auto;
}
#detail-overlay.open { display:flex; animation:detailFadeIn .3s ease; }
@keyframes detailFadeIn { from { opacity:0; } to { opacity:1; } }

.detail-panel {
  width:100%; max-width:1340px;
  background:linear-gradient(160deg,rgba(4,14,36,.97),rgba(1,6,15,.99));
  border:1px solid rgba(60,120,200,.4); border-radius:22px; overflow:hidden;
  box-shadow:0 50px 140px rgba(0,0,0,.92), inset 0 0 0 1px rgba(66,165,245,.035);
  animation:panelRise .38s cubic-bezier(.16,1,.3,1); margin:auto;
}
@keyframes panelRise { from { opacity:0; transform:translateY(26px) scale(.97); } to { opacity:1; transform:none; } }

/* Detail hero banner */
.dp-hero-banner {
  position:relative; display:flex; align-items:center; justify-content:center;
  padding:50px 36px 36px; overflow:hidden; min-height:210px;
}
.dp-hero-banner::before {
  content:''; position:absolute; inset:0;
  background:linear-gradient(90deg,rgba(21,101,192,.22) 0%,rgba(2,10,26,.35) 40%,rgba(2,10,26,.35) 60%,rgba(100,25,25,.18) 100%);
}
.dp-hero-banner::after {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  background:linear-gradient(90deg,transparent,var(--blue3),var(--gold2),var(--blue3),transparent);
}
.dp-banner-ghost {
  position:absolute; top:0; bottom:0; width:52%; object-fit:contain;
  opacity:.09; filter:blur(16px) saturate(2.6); pointer-events:none;
}
.dp-banner-ghost.a { left:0; object-position:left center; }
.dp-banner-ghost.b { right:0; object-position:right center; }

.dp-banner-teams { display:flex; align-items:center; justify-content:center; width:100%; position:relative; z-index:2; }
.dp-banner-col   { flex:1; display:flex; flex-direction:column; align-items:center; gap:12px; }
.dp-banner-logo-wrap { position:relative; }
.dp-banner-logo { width:90px; height:90px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,.1); }
.dp-banner-logo.is-winner { border-color:rgba(212,168,42,.7); filter:drop-shadow(0 0 22px rgba(212,168,42,.8)) brightness(1.14); }
.dp-banner-logo-ph { width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,var(--mid),var(--deep)); border:2px solid var(--border2); display:flex; align-items:center; justify-content:center; font-family:'Cinzel',serif; font-size:1.2rem; font-weight:700; color:var(--muted); }
.dp-banner-trophy { position:absolute; top:-44px; left:50%; transform:translateX(-50%); width:52px; height:52px; filter:drop-shadow(0 0 14px rgba(212,168,42,1)) drop-shadow(0 0 30px rgba(232,201,106,.65)); animation:trophyFloat 2.5s ease-in-out infinite; }
.dp-banner-flag { width:28px; height:19px; border-radius:2px; object-fit:cover; border:1px solid rgba(255,255,255,.14); }
.dp-banner-score-num { font-family:'Cinzel',serif; font-size:3.4rem; font-weight:700; line-height:1; }
.dp-banner-score-num.win  { color:var(--win); text-shadow:0 0 28px rgba(72,216,144,.55); }
.dp-banner-score-num.lose { color:rgba(255,255,255,.16); }
.dp-banner-vs { display:flex; flex-direction:column; align-items:center; padding:0 30px; flex-shrink:0; gap:9px; }
.dp-banner-vs-badge { width:80px; height:80px; }
.dp-banner-vs-badge svg { width:100%; height:100%; filter:drop-shadow(0 0 16px rgba(33,150,243,.55)) drop-shadow(0 0 32px rgba(212,168,42,.2)); }
.dp-banner-round { font-family:'Rajdhani',sans-serif; font-size:.74rem; font-weight:700; letter-spacing:.13em; color:var(--bright); background:rgba(21,101,192,.12); border:1px solid rgba(66,165,245,.2); padding:3px 14px; border-radius:14px; backdrop-filter:blur(8px); }
.dp-close { position:absolute; top:14px; right:14px; width:36px; height:36px; background:var(--glassbtn); border:1px solid var(--borderg); color:var(--muted2); border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:.92rem; transition:all .2s; z-index:5; backdrop-filter:blur(10px); }
.dp-close:hover { color:var(--plat); background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.2); }
.dp-actions { position:absolute; bottom:14px; right:14px; display:flex; gap:8px; z-index:5; }

/* Horizontal 5v5 grid — no vertical scroll */
.dp-players { display:grid; grid-template-columns:1fr 1fr; min-height:420px; }
.dp-team-col { border-right:1px solid rgba(20,55,110,.4); }
.dp-team-col:last-child { border-right:none; }
.dp-col-hdr { display:grid; grid-template-columns:50px 40px 1fr 58px 108px; gap:6px; padding:8px 22px 7px; font-family:'Orbitron',sans-serif; font-size:.49rem; letter-spacing:.14em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid rgba(255,255,255,.04); }
.dp-player-row { display:grid; grid-template-columns:50px 40px 1fr 58px 108px; gap:6px; align-items:center; padding:12px 22px; border-bottom:1px solid rgba(10,40,84,.28); transition:background .15s; }
.dp-player-row:last-child { border-bottom:none; }
.dp-player-row:hover { background:rgba(21,101,192,.07); }
.dp-hero { width:44px; height:44px; border-radius:9px; object-fit:cover; border:1px solid var(--border2); }
.dp-hero-ph { width:44px; height:44px; border-radius:9px; background:var(--glass); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:1rem; color:var(--muted); }
.dp-role-icon { width:36px; height:36px; border-radius:7px; object-fit:cover; border:1px solid rgba(255,255,255,.08); }
.dp-role-ph { width:36px; height:36px; border-radius:7px; background:rgba(21,101,192,.1); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:.72rem; color:var(--muted); }
.dp-ign { font-family:'Rajdhani',sans-serif; font-size:.95rem; font-weight:700; color:var(--plat); }
.dp-ign-role { font-family:'Exo 2',sans-serif; font-size:.6rem; color:var(--muted); margin-top:2px; }
.dp-kda { font-family:'Orbitron',sans-serif; font-size:.86rem; font-weight:700; color:var(--bright); text-align:center; }
.dp-kda-lbl { font-size:.48rem; color:var(--muted); text-align:center; letter-spacing:.1em; margin-top:2px; }
.dp-badge { display:flex; align-items:center; justify-content:center; flex-direction:column; gap:2px; }
.dp-badge-img { width:48px; height:48px; object-fit:contain; filter:drop-shadow(0 0 8px rgba(212,168,42,.5)); }
.dp-empty { text-align:center; padding:44px; color:var(--muted); font-style:italic; font-size:.84rem; grid-column:1/-1; }

/* ══ MODAL BASE ══════════════════════════════ */
.ov { display:none; position:fixed; inset:0; background:rgba(0,4,14,.78); backdrop-filter:blur(16px) saturate(1.2); -webkit-backdrop-filter:blur(16px) saturate(1.2); z-index:200; align-items:center; justify-content:center; padding:14px; }
.ov.open { display:flex; }
.modal {
  background:linear-gradient(160deg,rgba(4,14,38,.92),rgba(2,8,26,.96));
  border:1px solid rgba(60,120,220,.32); border-radius:16px;
  width:100%; max-height:94vh; overflow-y:auto;
  animation:mIn .24s cubic-bezier(.16,1,.3,1);
  box-shadow:0 32px 100px rgba(0,0,0,.82), 0 0 0 1px rgba(255,255,255,.03), inset 0 1px 0 rgba(100,160,255,.06);
  position:relative; backdrop-filter:blur(28px) saturate(1.4);
}
.modal::before { content:''; position:absolute; top:0; left:22px; right:22px; height:1px; background:linear-gradient(90deg,transparent,var(--border2),var(--gold2),var(--border2),transparent); border-radius:4px; }
@keyframes mIn { from { opacity:0; transform:translateY(-18px) scale(.97); } to { opacity:1; transform:none; } }
.mh { display:flex; align-items:center; justify-content:space-between; padding:16px 22px; border-bottom:1px solid rgba(30,80,155,.3); position:sticky; top:0; background:linear-gradient(180deg,rgba(6,18,44,.99),rgba(6,18,44,.92)); z-index:3; backdrop-filter:blur(6px); }
.mt { font-family:'Cinzel',serif; font-size:.94rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--gold); }
.mc { background:var(--glassbtn); border:1px solid var(--borderg); color:var(--muted2); font-size:.9rem; cursor:pointer; width:32px; height:32px; border-radius:7px; display:flex; align-items:center; justify-content:center; transition:all .2s; flex-shrink:0; backdrop-filter:blur(6px); }
.mc:hover { color:var(--plat); background:rgba(255,255,255,.09); border-color:rgba(255,255,255,.18); }
.mb { padding:22px; }
.em { max-width:820px; }
.cm { max-width:370px; }
.am { max-width:960px; }

/* Form fields */
.fg { display:grid; grid-template-columns:1fr 1fr; gap:15px; }
.fgrp { display:flex; flex-direction:column; gap:7px; }
label.lbl { font-family:'Orbitron',sans-serif; font-size:.54rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--muted2); }
.fi { background:rgba(2,8,22,.65); border:1px solid rgba(30,80,155,.35); color:var(--plat); padding:10px 12px; border-radius:8px; font-family:'Exo 2',sans-serif; font-size:.86rem; outline:none; width:100%; transition:border-color .2s, box-shadow .2s; backdrop-filter:blur(6px); }
.fi:focus { border-color:rgba(66,165,245,.45); box-shadow:0 0 0 2px rgba(66,165,245,.09); }
.fi::placeholder { color:var(--muted); }
.fi option { background:#07142a; }
.uz { background:rgba(2,8,22,.4); border:2px dashed rgba(30,80,155,.4); border-radius:10px; padding:13px 9px; text-align:center; cursor:pointer; transition:border-color .2s, background .2s; min-height:88px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px; backdrop-filter:blur(6px); }
.uz:hover { border-color:rgba(66,165,245,.4); background:rgba(66,165,245,.04); }
.uz.got { border-style:solid; border-color:rgba(212,168,42,.45); }
.uz-prev { width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid var(--gold2); display:none; }
.uz.got .uz-prev { display:block; }
.uz-lbl { font-family:'Rajdhani',sans-serif; font-size:.7rem; color:var(--muted); pointer-events:none; letter-spacing:.07em; }
.uz.got .uz-lbl { color:var(--gold); font-size:.66rem; }
.divider { display:flex; align-items:center; gap:12px; margin:24px 0 14px; }
.divider-line { flex:1; height:1px; background:linear-gradient(90deg,var(--border),transparent); }
.divider-txt { font-family:'Orbitron',sans-serif; font-size:.55rem; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); white-space:nowrap; }
.fa { display:flex; gap:10px; justify-content:flex-end; margin-top:20px; padding-top:15px; border-top:1px solid rgba(30,80,155,.28); }

/* ══ PLAYER EDITOR ═══════════════════════════ */
.ptabs { display:flex; border-radius:8px 8px 0 0; overflow:hidden; border:1px solid rgba(30,80,155,.35); }
.ptab { flex:1; padding:10px; text-align:center; cursor:pointer; font-family:'Rajdhani',sans-serif; font-size:.82rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; background:rgba(6,18,44,.8); color:var(--muted); border:none; transition:all .2s; backdrop-filter:blur(8px); }
.ptab.on-a { background:rgba(21,101,192,.2); color:var(--accent); box-shadow:inset 0 -2px 0 var(--blue2); }
.ptab.on-b { background:rgba(139,18,18,.18); color:#ef9a9a; box-shadow:inset 0 -2px 0 #b71c1c; }
.ppanel { border:1px solid rgba(30,80,155,.3); border-top:none; border-radius:0 0 10px 10px; background:rgba(0,0,0,.12); display:none; padding:10px; }
.ppanel.vis { display:block; }
.pchdr { display:grid; grid-template-columns:56px 56px 1fr 52px 52px 52px 1fr; gap:8px; padding:5px 4px 8px; font-family:'Orbitron',sans-serif; font-size:.5rem; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid rgba(255,255,255,.04); margin-bottom:4px; }
.pchdr span { text-align:center; }
.pchdr span:nth-child(3) { text-align:left; }
.prow { display:grid; grid-template-columns:56px 56px 1fr 52px 52px 52px 1fr; gap:8px; align-items:center; padding:8px 4px; border-bottom:1px solid rgba(10,40,84,.28); }
.prow:last-child { border-bottom:none; }

/* Hero Class Picker */
.hero-picker { display:flex; flex-direction:column; gap:4px; }
.hpick-tabs { display:flex; flex-wrap:wrap; gap:3px; margin-bottom:3px; }
.hpick-tab {
  padding:3px 9px;
  background:var(--glassbtn); border:1px solid var(--borderg);
  backdrop-filter:blur(8px);
  border-radius:4px; font-family:'Rajdhani',sans-serif; font-size:.62rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase;
  color:var(--muted2); cursor:pointer; transition:all .18s; white-space:nowrap;
}
.hpick-tab:hover { border-color:rgba(66,165,245,.3); color:var(--accent); }
.hpick-tab.active { background:rgba(212,168,42,.15); border-color:rgba(212,168,42,.4); color:var(--gold3); }
.hpick-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(48px,1fr)); gap:4px; max-height:120px; overflow-y:auto; }
.hpick-item {
  display:flex; flex-direction:column; align-items:center; gap:2px;
  padding:4px 2px; border-radius:6px; cursor:pointer;
  border:1px solid transparent; transition:all .18s;
  background:var(--glassbtn); backdrop-filter:blur(6px);
}
.hpick-item:hover { border-color:rgba(66,165,245,.3); background:rgba(66,165,245,.08); }
.hpick-item.selected { border-color:rgba(212,168,42,.55); background:rgba(212,168,42,.1); }
.hpick-item img { width:40px; height:40px; border-radius:6px; object-fit:cover; }
.hpick-item span { font-family:'Rajdhani',sans-serif; font-size:.52rem; color:var(--muted2); text-align:center; line-height:1.1; }
.hpick-empty { font-family:'Rajdhani',sans-serif; font-size:.72rem; color:var(--muted); padding:10px; text-align:center; }

.asset-dd { display:flex; flex-direction:column; align-items:center; gap:3px; }
.asset-dd-img { width:50px; height:50px; border-radius:9px; object-fit:cover; border:1px solid var(--border2); background:var(--mid); }
.asset-dd-sel { background:rgba(2,8,22,.85); border:1px solid rgba(30,80,155,.35); color:var(--plat); font-family:'Exo 2',sans-serif; font-size:.55rem; padding:2px 4px; border-radius:4px; outline:none; width:56px; cursor:pointer; }
.asset-dd-sel option { background:#07142a; }
.kda-in { text-align:center; padding:9px 4px; }
.badge-sel { background:rgba(2,8,22,.85); border:1px solid rgba(30,80,155,.35); color:var(--plat); font-family:'Rajdhani',sans-serif; font-size:.72rem; padding:9px 5px; border-radius:8px; outline:none; width:100%; }
.badge-sel option { background:#07142a; }

/* ══ ASSET LIBRARY ═══════════════════════════ */
.asset-tabs { display:flex; border:1px solid rgba(30,80,155,.35); border-radius:9px; overflow:hidden; margin-bottom:16px; }
.asset-tab { flex:1; padding:11px; background:rgba(6,18,44,.7); color:var(--muted); border:none; cursor:pointer; font-family:'Rajdhani',sans-serif; font-size:.82rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; transition:all .2s; backdrop-filter:blur(8px); }
.asset-tab.active { background:rgba(212,168,42,.1); color:var(--gold); box-shadow:inset 0 -2px 0 var(--gold2); }
.asset-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(118px,1fr)); gap:12px; max-height:380px; overflow-y:auto; padding:4px; }
.asset-item { background:var(--glass); border:1px solid var(--borderg); border-radius:11px; padding:12px; text-align:center; cursor:pointer; transition:all .22s; position:relative; display:flex; flex-direction:column; align-items:center; gap:7px; backdrop-filter:blur(12px); }
.asset-item:hover { border-color:rgba(212,168,42,.4); background:rgba(212,168,42,.05); }
.asset-item img { width:72px; height:72px; object-fit:cover; border-radius:9px; border:1px solid var(--border2); }
.asset-item.badge-asset img { object-fit:contain; border-radius:4px; background:rgba(0,0,0,.3); border-color:rgba(212,168,42,.22); }
.asset-item-name { font-family:'Rajdhani',sans-serif; font-size:.73rem; font-weight:700; color:var(--plat); }
.asset-class-badge { font-family:'Orbitron',sans-serif; font-size:.47rem; letter-spacing:.1em; padding:2px 7px; border-radius:4px; background:rgba(21,101,192,.18); border:1px solid rgba(66,165,245,.2); color:var(--accent); }
.asset-class-sel { background:rgba(2,8,22,.85); border:1px solid rgba(30,80,155,.3); color:var(--plat); font-family:'Rajdhani',sans-serif; font-size:.65rem; padding:3px 5px; border-radius:5px; outline:none; width:100%; margin-top:3px; cursor:pointer; }
.asset-class-sel option { background:#07142a; }
.asset-upload-form { background:rgba(2,8,22,.5); border:1px solid rgba(30,80,155,.3); border-radius:11px; padding:16px; margin-bottom:16px; backdrop-filter:blur(12px); }
.asset-upload-form h4 { font-family:'Cinzel',serif; font-size:.6rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); margin-bottom:12px; }
.asset-form-row { display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap; }
.asset-form-row .fgrp { flex:1; min-width:110px; }
.asset-del-btn { position:absolute; top:5px; right:5px; width:22px; height:22px; background:rgba(139,18,18,.88); border:none; border-radius:4px; color:#fff; font-size:.64rem; display:none; align-items:center; justify-content:center; cursor:pointer; }
.asset-item:hover .asset-del-btn { display:flex; }

/* ══ DELETE MODAL ════════════════════════════ */
.ct { color:var(--muted2); font-size:.88rem; line-height:1.8; text-align:center; padding:4px 0; }
.ct strong { color:var(--plat); }
.del-icon { width:58px; height:58px; border-radius:50%; background:rgba(139,18,18,.12); border:2px solid rgba(239,154,154,.22); display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin:0 auto 14px; }

/* ══ TOAST ═══════════════════════════════════ */
#toast { position:fixed; bottom:26px; right:26px; background:rgba(8,22,46,.92); border:1px solid var(--border2); border-radius:10px; padding:12px 20px; font-family:'Rajdhani',sans-serif; font-size:.86rem; font-weight:600; letter-spacing:.04em; z-index:999; transform:translateY(70px); opacity:0; transition:all .3s cubic-bezier(.16,1,.3,1); pointer-events:none; max-width:320px; box-shadow:0 10px 40px rgba(0,0,0,.6); backdrop-filter:blur(16px); }
#toast.show { transform:none; opacity:1; }
#toast.ok  { border-color:var(--win);  color:var(--win); }
#toast.err { border-color:#ef9a9a; color:#ef9a9a; }

.spin { display:inline-block; width:16px; height:16px; border:2px solid rgba(66,165,245,.2); border-top-color:var(--accent); border-radius:50%; animation:sp .65s linear infinite; vertical-align:middle; }
@keyframes sp { to { transform:rotate(360deg); } }

::-webkit-scrollbar { width:4px; height:4px; }
::-webkit-scrollbar-track { background:var(--void); }
::-webkit-scrollbar-thumb { background:var(--border2); border-radius:4px; }

@media (max-width: 900px) {
  .dp-players { grid-template-columns:1fr; }
  .dp-team-col { border-right:none; border-bottom:1px solid rgba(20,55,110,.35); }
  .dp-team-col:last-child { border-bottom:none; }
  .fg { grid-template-columns:1fr; }
  .hdr-sub, .hdr-sep { display:none; }
}
@media (max-width: 600px) {
  .dp-col-hdr, .dp-player-row { grid-template-columns:42px 34px 1fr 50px 90px; }
  .pchdr, .prow { grid-template-columns:50px 50px 1fr 44px 44px 44px 1fr; }
}
</style>
</head>
<body>

<!-- ═══ INTRO VIDEO ═══ -->
<div id="intro-screen">
  <video id="intro-video" playsinline muted autoplay>
    <source src="intro.mp4" type="video/mp4">
  </video>
  <div id="intro-fallback">
    <img src="ml_logo.png" alt="ML">
    <div class="if-title">Tournament Results</div>
    <div class="if-sub">Mobile Legends · Soul Photographer</div>
    <div class="intro-bar-wrap"><div class="intro-bar"></div></div>
  </div>
  <button id="intro-skip" onclick="skipIntro()">Skip ›</button>
</div>

<!-- ═══ HEADER ═══ -->
<header id="site-header">
  <img class="hdr-logo" src="ml_logo.png" alt="ML">
  <div class="hdr-title">Tournament Results</div>
  <div class="hdr-sep"></div>
  <div class="hdr-sub">Mobile Legends · 5v5 · Soul Photographer</div>
  <div class="hdr-spacer"></div>
  <button class="hdr-btn primary" onclick="openCreate()">＋ Add Match</button>
  <button class="hdr-btn gold"    onclick="openAssetLib()">🗂 Assets</button>
</header>

<!-- ═══ NAV ═══ -->
<nav id="site-nav">
  <div class="round-filters" id="roundFilters">
    <button class="rf-pill active" data-round="" onclick="filterRound(this,'')">All</button>
  </div>
  <div class="nav-search"><input type="text" id="q" placeholder="Search team or winner…"></div>
</nav>

<!-- ═══ MAIN ═══ -->
<div class="wrap">
  <div class="stats">
    <div class="stat"><div class="stat-n" id="sTotal">—</div><div class="stat-l">Matches</div></div>
    <div class="stat"><div class="stat-n" id="sRounds">—</div><div class="stat-l">Rounds</div></div>
    <div class="stat"><div class="stat-n" id="sTeams">—</div><div class="stat-l">Teams</div></div>
  </div>
  <div class="section-hdr">
    <div class="section-hdr-line"></div>
    <div class="section-hdr-txt">⚔ Match Records</div>
    <div class="section-hdr-line" style="transform:scaleX(-1)"></div>
  </div>
  <div class="carousel-outer" id="carouselOuter">
    <button class="carousel-btn prev" id="cPrev" onclick="carouselMove(-1)">&#8249;</button>
    <div class="carousel-track-wrap">
      <div class="carousel-track" id="carouselTrack">
        <div class="carousel-empty"><span class="spin"></span></div>
      </div>
    </div>
    <button class="carousel-btn next" id="cNext" onclick="carouselMove(1)">&#8250;</button>
  </div>
  <div class="carousel-dots" id="carouselDots"></div>
</div>

<!-- ═══ DETAIL OVERLAY ═══ -->
<div id="detail-overlay" onclick="ovClickClose(event)">
  <div class="detail-panel" id="detailPanel">
    <div class="dp-hero-banner" id="dpHeroBanner">
      <div class="dp-banner-teams" id="dpBannerTeams">
        <div style="text-align:center;padding:40px;width:100%"><span class="spin"></span></div>
      </div>
      <button class="dp-close" onclick="closeDetail()">✕</button>
      <div class="dp-actions" id="dpActions"></div>
    </div>
    <div class="dp-players" id="dpPlayers">
      <div style="text-align:center;padding:60px;grid-column:1/-1"><span class="spin"></span></div>
    </div>
  </div>
</div>

<!-- ═══ ADD/EDIT MODAL ═══ -->
<div class="ov" id="ovForm" onclick="ovc(event,'ovForm')">
  <div class="modal em">
    <div class="mh"><span class="mt" id="fmTitle">Add Match</span><button class="mc" onclick="closeOv('ovForm')">✕</button></div>
    <div class="mb">
      <div class="fg">
        <div class="fgrp"><label class="lbl">Team A Name</label><input class="fi" type="text" id="fA" placeholder="e.g. Alpha Warriors" oninput="syncW()"></div>
        <div class="fgrp"><label class="lbl">Team B Name</label><input class="fi" type="text" id="fB" placeholder="e.g. Iron Wolves"    oninput="syncW()"></div>
        <div class="fgrp">
          <label class="lbl">Team A Logo</label>
          <div class="uz" id="uzA" onclick="document.getElementById('ufA').click()">
            <img class="uz-prev" id="upA" alt=""><div class="uz-lbl" id="ulA">📁 Click to upload</div>
          </div>
          <input type="file" id="ufA" accept="image/*" style="display:none">
        </div>
        <div class="fgrp">
          <label class="lbl">Team B Logo</label>
          <div class="uz" id="uzB" onclick="document.getElementById('ufB').click()">
            <img class="uz-prev" id="upB" alt=""><div class="uz-lbl" id="ulB">📁 Click to upload</div>
          </div>
          <input type="file" id="ufB" accept="image/*" style="display:none">
        </div>
        <div class="fgrp">
          <label class="lbl">Team A Country</label>
          <select class="fi" id="fFlagA"></select>
        </div>
        <div class="fgrp">
          <label class="lbl">Team B Country</label>
          <select class="fi" id="fFlagB"></select>
        </div>
        <div class="fgrp"><label class="lbl">Score (Team A)</label><input class="fi" type="number" id="fSA" min="0" value="0"></div>
        <div class="fgrp"><label class="lbl">Score (Team B)</label><input class="fi" type="number" id="fSB" min="0" value="0"></div>
        <div class="fgrp"><label class="lbl">Winner</label><select class="fi" id="fW"><option value="">— Select Winner —</option></select></div>
        <div class="fgrp"><label class="lbl">Round</label><input class="fi" type="text" id="fR" placeholder="e.g. Quarter Finals" list="roundsList"><datalist id="roundsList"></datalist></div>
      </div>
      <div class="fa" style="margin-bottom:0;border-bottom:none;padding-bottom:0">
        <button class="btn btn-cancel" onclick="closeOv('ovForm')">Cancel</button>
        <button class="btn btn-primary" id="btnSave" onclick="saveMatch()">Save Match</button>
      </div>
      <div id="pSection" style="display:none">
        <div class="divider"><div class="divider-line"></div><div class="divider-txt">⚔ Player Details (5 per team)</div><div class="divider-line"></div></div>
        <p style="font-family:'Rajdhani',sans-serif;font-size:.76rem;color:var(--muted);margin-bottom:12px;letter-spacing:.04em">Click a hero class tab to filter heroes. Select Role, enter IGN, K/D/A, and badge.</p>
        <div class="ptabs">
          <button class="ptab on-a" id="ptA" onclick="swTab('A')">Team A</button>
          <button class="ptab"      id="ptB" onclick="swTab('B')">Team B</button>
        </div>
        <div class="ppanel vis" id="ppA">
          <div class="pchdr"><span>Hero</span><span>Role</span><span style="text-align:left">IGN</span><span>K</span><span>D</span><span>A</span><span>Badge</span></div>
          <div id="pgA"></div>
        </div>
        <div class="ppanel" id="ppB">
          <div class="pchdr"><span>Hero</span><span>Role</span><span style="text-align:left">IGN</span><span>K</span><span>D</span><span>A</span><span>Badge</span></div>
          <div id="pgB"></div>
        </div>
        <div class="fa"><button class="btn btn-primary" id="btnSavePl" onclick="savePlayers()">💾 Save Player Details</button></div>
      </div>
    </div>
  </div>
</div>

<!-- ═══ DELETE MODAL ═══ -->
<div class="ov" id="ovDel" onclick="ovc(event,'ovDel')">
  <div class="modal cm">
    <div class="mh"><span class="mt">Delete Match</span><button class="mc" onclick="closeOv('ovDel')">✕</button></div>
    <div class="mb" style="text-align:center">
      <div class="del-icon">⚠️</div>
      <p class="ct">Delete <strong id="delLbl"></strong>?<br>This cannot be undone.</p>
      <div class="fa" style="justify-content:center;margin-top:16px">
        <button class="btn btn-cancel" onclick="closeOv('ovDel')">Cancel</button>
        <button class="btn btn-del"    id="btnDel">🗑 Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- ═══ ASSET LIBRARY MODAL ═══ -->
<div class="ov" id="ovAsset" onclick="ovc(event,'ovAsset')">
  <div class="modal am">
    <div class="mh"><span class="mt">🗂 Asset Library</span><button class="mc" onclick="closeOv('ovAsset')">✕</button></div>
    <div class="mb">
      <div class="asset-upload-form">
        <h4>Add New Asset</h4>
        <div class="asset-form-row">
          <div class="fgrp">
            <label class="lbl">Type</label>
            <select class="fi" id="assetType" style="width:auto" onchange="toggleHeroClassField()">
              <option value="hero">Hero</option>
              <option value="role">Role</option>
              <option value="badge">Badge</option>
            </select>
          </div>
          <div class="fgrp" id="assetClassWrap">
            <label class="lbl">Hero Class</label>
            <select class="fi" id="assetClass" style="width:auto">
              <option value="">— Unclassified —</option>
              <option value="Tank">Tank</option>
              <option value="Fighter">Fighter</option>
              <option value="Assassin">Assassin</option>
              <option value="Mage">Mage</option>
              <option value="Marksman">Marksman</option>
              <option value="Support">Support</option>
            </select>
          </div>
          <div class="fgrp" style="flex:2">
            <label class="lbl">Name</label>
            <input class="fi" type="text" id="assetName" placeholder="e.g. Ling, Gold Lane, MVP">
          </div>
          <div class="fgrp">
            <label class="lbl">Image</label>
            <input class="fi" type="file" id="assetFile" accept="image/*" style="padding:7px">
          </div>
          <div class="fgrp" style="justify-content:flex-end">
            <button class="btn btn-gold" onclick="uploadAsset()">Upload</button>
          </div>
        </div>
        <p style="font-family:'Rajdhani',sans-serif;font-size:.7rem;color:var(--muted);margin-top:9px;letter-spacing:.04em">
          Badge names must match exactly: <strong style="color:var(--gold)">MVP</strong>, <strong style="color:var(--gold)">MVP Lose</strong>, <strong style="color:var(--gold)">Gold</strong>, <strong style="color:var(--gold)">Silver</strong>, <strong style="color:var(--gold)">Bronze</strong>
        </p>
      </div>
      <div class="asset-tabs">
        <button class="asset-tab active" id="aTabHero"  onclick="switchAssetTab('hero')">Heroes</button>
        <button class="asset-tab"        id="aTabRole"  onclick="switchAssetTab('role')">Roles</button>
        <button class="asset-tab"        id="aTabBadge" onclick="switchAssetTab('badge')">Badges</button>
      </div>
      <div class="asset-grid" id="assetGrid">
        <div style="text-align:center;padding:40px;grid-column:1/-1;color:var(--muted)"><span class="spin"></span></div>
      </div>
    </div>
  </div>
</div>

<div id="toast"></div>

<script>
'use strict';

/* ─── STATE ──────────────────────────────────── */
var gEditId=null, gDelId=null, gCurrentRound='', gMatches=[], gCarouselIdx=0, gDetailId=null;
var gAssets={hero:[],role:[],badge:[]}, gAssetTab='hero';
var HERO_CLASSES=['Tank','Fighter','Assassin','Mage','Marksman','Support'];
var COUNTRY_OPTIONS=[
  {v:'',l:'— No Flag —'},
  {v:'PH',l:'🇵🇭 Philippines'},{v:'ID',l:'🇮🇩 Indonesia'},{v:'MY',l:'🇲🇾 Malaysia'},
  {v:'SG',l:'🇸🇬 Singapore'},{v:'TH',l:'🇹🇭 Thailand'},{v:'VN',l:'🇻🇳 Vietnam'},
  {v:'MM',l:'🇲🇲 Myanmar'},{v:'KH',l:'🇰🇭 Cambodia'},{v:'BD',l:'🇧🇩 Bangladesh'},
  {v:'PK',l:'🇵🇰 Pakistan'},{v:'IN',l:'🇮🇳 India'},{v:'CN',l:'🇨🇳 China'},
  {v:'JP',l:'🇯🇵 Japan'},{v:'KR',l:'🇰🇷 South Korea'},{v:'US',l:'🇺🇸 USA'},
  {v:'BR',l:'🇧🇷 Brazil'}
];

/* ─── INTRO VIDEO ────────────────────────────── */
(function(){
  var screen=document.getElementById('intro-screen');
  var video=document.getElementById('intro-video');
  var fb=document.getElementById('intro-fallback');
  var playable=false;

  video.addEventListener('error', function(){
    video.style.display='none'; fb.style.display='flex';
    setTimeout(skipIntro, 2700);
  });
  video.addEventListener('ended', skipIntro);
  video.addEventListener('canplay', function(){ playable=true; });
  setTimeout(function(){
    if(!playable && video.readyState===0){
      video.style.display='none'; fb.style.display='flex';
      setTimeout(skipIntro, 2700);
    }
  }, 900);
})();
function skipIntro(){
  var s=document.getElementById('intro-screen');
  s.classList.add('fade-out');
  setTimeout(function(){ s.classList.add('hidden'); }, 950);
}

/* ─── FLAG helpers ───────────────────────────── */
function flagUrl(c){ return c?'https://flagcdn.com/w40/'+c.toLowerCase()+'.png':''; }
function flagHtml(c,cls){
  if(!c) return '';
  return '<img class="'+(cls||'card-flag')+'" src="'+flagUrl(c)+'" alt="'+xe(c)+'" onerror="this.style.display=\'none\'">';
}

/* ─── VS SVG ──────────────────────────────────── */
function vsSvg(){
  return '<svg viewBox="0 0 70 70" xmlns="http://www.w3.org/2000/svg">'
    +'<defs>'
    +'<linearGradient id="vsG" x1="0%" y1="0%" x2="100%" y2="100%">'
    +'<stop offset="0%" stop-color="#42a5f5" stop-opacity=".85"/>'
    +'<stop offset="50%" stop-color="#d4a82a" stop-opacity=".95"/>'
    +'<stop offset="100%" stop-color="#42a5f5" stop-opacity=".85"/>'
    +'</linearGradient>'
    +'<linearGradient id="vsBg" x1="0%" y1="0%" x2="100%" y2="100%">'
    +'<stop offset="0%" stop-color="#030e1f" stop-opacity=".96"/>'
    +'<stop offset="100%" stop-color="#061628" stop-opacity=".96"/>'
    +'</linearGradient>'
    +'</defs>'
    +'<polygon points="35,2 68,35 35,68 2,35" fill="none" stroke="url(#vsG)" stroke-width="1.5" opacity=".8"/>'
    +'<polygon points="35,11 59,35 35,59 11,35" fill="url(#vsBg)"/>'
    +'<circle cx="35" cy="2"  r="2.5" fill="#d4a82a" opacity=".9"/>'
    +'<circle cx="35" cy="68" r="2.5" fill="#d4a82a" opacity=".9"/>'
    +'<circle cx="2"  cy="35" r="2.5" fill="#42a5f5" opacity=".9"/>'
    +'<circle cx="68" cy="35" r="2.5" fill="#42a5f5" opacity=".9"/>'
    +'<text x="35" y="39" font-family="Orbitron,sans-serif" font-size="11" font-weight="900" fill="#d4a82a" letter-spacing="1" text-anchor="middle" dominant-baseline="middle">VS</text>'
    +'</svg>';
}

/* ─── Mythical Glory Trophy SVG ─────────────── */
function trophySvg(size){
  size=size||56;
  return '<svg width="'+size+'" height="'+size+'" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">'
    +'<defs>'
    +'<radialGradient id="tG" cx="50%" cy="35%" r="55%">'
    +'<stop offset="0%" stop-color="#fff8c0"/>'
    +'<stop offset="40%" stop-color="#f0d060"/>'
    +'<stop offset="100%" stop-color="#a06010"/>'
    +'</radialGradient>'
    +'<linearGradient id="tG2" x1="0%" y1="0%" x2="100%" y2="100%">'
    +'<stop offset="0%" stop-color="#e8c96a"/>'
    +'<stop offset="100%" stop-color="#8b5e0a"/>'
    +'</linearGradient>'
    +'</defs>'
    /* Shield body */
    +'<path d="M40 6 L70 18 L70 44 Q70 64 40 74 Q10 64 10 44 L10 18 Z" fill="url(#tG)" stroke="#a06010" stroke-width="1.5"/>'
    /* Inner shield */
    +'<path d="M40 14 L62 23 L62 43 Q62 58 40 66 Q18 58 18 43 L18 23 Z" fill="url(#tG2)" opacity=".7"/>'
    /* Gem diamond */
    +'<polygon points="40,24 50,32 40,42 30,32" fill="#fff8c0" stroke="#d4a82a" stroke-width="1"/>'
    /* Triangle accent */
    +'<polygon points="40,20 56,36 24,36" fill="none" stroke="#f0d888" stroke-width="1" opacity=".6"/>'
    /* Crown tips */
    +'<polyline points="16,22 12,12 22,18" fill="none" stroke="#e8c96a" stroke-width="1.8" stroke-linecap="round"/>'
    +'<polyline points="64,22 68,12 58,18" fill="none" stroke="#e8c96a" stroke-width="1.8" stroke-linecap="round"/>'
    +'<line x1="28" y1="70" x2="52" y2="70" stroke="#d4a82a" stroke-width="2" stroke-linecap="round"/>'
    +'<line x1="34" y1="70" x2="34" y2="76" stroke="#d4a82a" stroke-width="2" stroke-linecap="round"/>'
    +'<line x1="46" y1="70" x2="46" y2="76" stroke="#d4a82a" stroke-width="2" stroke-linecap="round"/>'
    +'<line x1="26" y1="76" x2="54" y2="76" stroke="#d4a82a" stroke-width="2.5" stroke-linecap="round"/>'
    +'</svg>';
}

/* ─── BOOT ────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  buildCountrySelects();
  loadAssets();
  loadRounds();
  loadMatches();
  document.getElementById('q').addEventListener('input', debounce(loadMatches,300));
  document.getElementById('btnDel').addEventListener('click', doDelete);
  document.getElementById('ufA').addEventListener('change', function(){ previewLogo(this,'upA','uzA','ulA'); });
  document.getElementById('ufB').addEventListener('change', function(){ previewLogo(this,'upB','uzB','ulB'); });
  document.getElementById('fA').addEventListener('input', syncW);
  document.getElementById('fB').addEventListener('input', syncW);
  window.addEventListener('resize', updateCarouselPos);
});

function buildCountrySelects(){
  var html=COUNTRY_OPTIONS.map(function(o){ return '<option value="'+xe(o.v)+'">'+xe(o.l)+'</option>'; }).join('');
  document.getElementById('fFlagA').innerHTML=html;
  document.getElementById('fFlagB').innerHTML=html;
}

/* ─── API ──────────────────────────────────────── */
async function api(url,opts){
  try{ var r=await fetch(url,opts||{}); return JSON.parse(await r.text()); }
  catch(e){ return {error:'Network error'}; }
}

/* ─── ROUNDS ───────────────────────────────────── */
async function loadRounds(){
  var d=await api('api.php?action=rounds');
  var bar=document.getElementById('roundFilters'), dl=document.getElementById('roundsList');
  bar.innerHTML='<button class="rf-pill active" data-round="" onclick="filterRound(this,\'\')">All</button>';
  dl.innerHTML='';
  var _order=['Finals','Semi Finals','Quarter Finals'];
  var _rounds=(d.data||[]).slice().sort(function(a,b){
    var ai=_order.indexOf(a),bi=_order.indexOf(b);
    if(ai===-1&&bi===-1) return a.localeCompare(b);
    if(ai===-1) return 1; if(bi===-1) return -1;
    return ai-bi;
  });
  _rounds.forEach(function(r){
    bar.innerHTML+='<button class="rf-pill" data-round="'+xe(r)+'" onclick="filterRound(this,\''+xe(r).replace(/'/g,'&#39;')+'\')">'+xe(r)+'</button>';
    var o=document.createElement('option'); o.value=r; dl.appendChild(o);
  });
}
function filterRound(btn,round){
  gCurrentRound=round;
  document.querySelectorAll('.rf-pill').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active'); loadMatches();
}

/* ─── MATCHES ─────────────────────────────────── */
async function loadMatches(){
  var search=document.getElementById('q').value.trim();
  var d=await api('api.php?action=list&'+new URLSearchParams({search:search,round:gCurrentRound}));
  gMatches=Array.isArray(d.data)?d.data:[];
  renderStats(gMatches); gCarouselIdx=0; renderCarousel();
}
function renderStats(rows){
  document.getElementById('sTotal').textContent=rows.length;
  var rds={},tms={};
  rows.forEach(function(r){ rds[r.round]=1; tms[r.team_a]=1; tms[r.team_b]=1; });
  document.getElementById('sRounds').textContent=Object.keys(rds).length;
  document.getElementById('sTeams').textContent=Object.keys(tms).length;
}

/* ─── CAROUSEL ────────────────────────────────── */
function cardW(){
  var w=document.getElementById('carouselOuter').clientWidth||700;
  return Math.min(760,Math.max(340,w*.62));
}

function renderCarousel(){
  var track=document.getElementById('carouselTrack'), dots=document.getElementById('carouselDots');
  if(!gMatches.length){
    track.innerHTML='<div class="carousel-empty"><span class="ei">🏆</span>No matches found.</div>';
    dots.innerHTML='';
    document.getElementById('cPrev').disabled=true;
    document.getElementById('cNext').disabled=true;
    return;
  }
  var cw=cardW(), outer=document.getElementById('carouselOuter');
  var sideW=Math.max(0,Math.floor((outer.clientWidth-cw)/2));

  track.innerHTML=gMatches.map(function(m,i){
    var winA=m.winner===m.team_a, winB=m.winner===m.team_b;

    var ghostA=m.team_a_img
      ?'<img class="ghost-logo a" src="uploads/'+xe(m.team_a_img)+'" alt="">'
      :'<div class="ghost-ph a">'+ini(m.team_a)+'</div>';
    var ghostB=m.team_b_img
      ?'<img class="ghost-logo b" src="uploads/'+xe(m.team_b_img)+'" alt="">'
      :'<div class="ghost-ph b">'+ini(m.team_b)+'</div>';

    var trophyA=winA?'<div class="card-trophy">'+trophySvg(54)+'</div>':'';
    var trophyB=winB?'<div class="card-trophy">'+trophySvg(54)+'</div>':'';
    var auraA=winA?'<div class="card-logo-aura"></div>':'';
    var auraB=winB?'<div class="card-logo-aura"></div>':'';

    var logoA=m.team_a_img
      ?'<img class="card-logo-img'+(winA?' is-winner':'')+'" src="uploads/'+xe(m.team_a_img)+'" alt="">'
      :'<div class="card-logo-ph'+(winA?' is-winner':'')+'">'+ini(m.team_a)+'</div>';
    var logoB=m.team_b_img
      ?'<img class="card-logo-img'+(winB?' is-winner':'')+'" src="uploads/'+xe(m.team_b_img)+'" alt="">'
      :'<div class="card-logo-ph'+(winB?' is-winner':'')+'">'+ini(m.team_b)+'</div>';

    var flagA=m.flag_a?'<div class="card-flag-wrap">'+flagHtml(m.flag_a)+'<span class="card-flag-code">'+xe(m.flag_a)+'</span></div>':'';
    var flagB=m.flag_b?'<div class="card-flag-wrap">'+flagHtml(m.flag_b)+'<span class="card-flag-code">'+xe(m.flag_b)+'</span></div>':'';
    var safe=(xe(m.team_a)+' vs '+xe(m.team_b)).replace(/'/g,'&#39;');

    return '<div class="match-card side" id="card'+m.id+'" style="flex:0 0 '+cw+'px" onclick="cardClick('+m.id+','+i+')">'
      +'<div class="card-ghost-wrap">'+ghostA+ghostB+'</div>'
      +'<div class="card-inner">'
        +'<div class="card-split"></div>'
        +'<div class="card-header-txt">'+xe(m.team_a)+' vs '+xe(m.team_b)+'</div>'
        +'<div class="card-teams-row">'
          +'<div class="card-team-block">'
            +trophyA
            +'<div style="position:relative">'+auraA+logoA+'</div>'
            +'<div class="card-team-name">'+xe(m.team_a)+'</div>'
            +flagA
          +'</div>'
          +'<div class="card-vs-block">'
            +'<div class="vs-badge">'+vsSvg()+'</div>'
            +'<div class="card-score-line"><span>'+m.score_a+'</span><span class="card-score-sep">:</span><span>'+m.score_b+'</span></div>'
          +'</div>'
          +'<div class="card-team-block">'
            +trophyB
            +'<div style="position:relative">'+auraB+logoB+'</div>'
            +'<div class="card-team-name">'+xe(m.team_b)+'</div>'
            +flagB
          +'</div>'
        +'</div>'
        +'<div class="card-footer-row">'
          +'<span class="card-round-pill">'+xe(m.round)+'</span>'
          +'<span class="card-winner-line">🏆 '+xe(m.winner)+'</span>'
          +'<div class="card-actions-row" onclick="event.stopPropagation()">'
            +'<button class="btn btn-sm btn-edit" onclick="openEdit('+m.id+')">✎ Edit</button>'
            +'<button class="btn btn-sm btn-del"  onclick="openDelete('+m.id+',\''+safe+'\')">🗑</button>'
          +'</div>'
        +'</div>'
      +'</div>'
    +'</div>';
  }).join('');

  track.style.paddingLeft=sideW+'px';
  track.style.paddingRight=sideW+'px';
  updateCarouselPos(); updateCarouselDots();
}

function cardClick(id,idx){
  if(idx!==gCarouselIdx){ gCarouselIdx=idx; updateCarouselPos(); updateCarouselDots(); setTimeout(function(){ openDetail(id); },220); }
  else openDetail(id);
}
function carouselMove(dir){
  gCarouselIdx=Math.max(0,Math.min(gMatches.length-1,gCarouselIdx+dir));
  updateCarouselPos(); updateCarouselDots();
}
function updateCarouselPos(){
  var track=document.getElementById('carouselTrack'), cw=cardW();
  track.style.transform='translateX(-'+(gCarouselIdx*cw)+'px)';
  track.querySelectorAll('.match-card').forEach(function(c,i){
    var d=Math.abs(i-gCarouselIdx);
    c.classList.remove('center','adj','side');
    c.classList.add(d===0?'center':d===1?'adj':'side');
  });
  document.getElementById('cPrev').disabled=(gCarouselIdx<=0);
  document.getElementById('cNext').disabled=(gCarouselIdx>=gMatches.length-1);
}
function updateCarouselDots(){
  var dots=document.getElementById('carouselDots'); dots.innerHTML='';
  gMatches.forEach(function(m,i){
    var d=document.createElement('div');
    d.className='carousel-dot'+(i===gCarouselIdx?' active':'');
    d.onclick=function(){ gCarouselIdx=i; updateCarouselPos(); updateCarouselDots(); };
    dots.appendChild(d);
  });
}

/* ─── DETAIL OVERLAY ─────────────────────────── */
async function openDetail(id){
  gDetailId=id;
  document.getElementById('detail-overlay').classList.add('open');
  document.getElementById('dpBannerTeams').innerHTML='<div style="text-align:center;padding:40px;width:100%"><span class="spin"></span></div>';
  document.getElementById('dpPlayers').innerHTML='<div style="text-align:center;padding:60px;grid-column:1/-1"><span class="spin"></span></div>';
  document.getElementById('dpActions').innerHTML='';

  var results=await Promise.all([api('api.php?action=get&id='+id),api('api.php?action=get_players&id='+id)]);
  var md=results[0], pd=results[1];
  if(md.error){ toast(md.error,'err'); closeDetail(); return; }
  var m=md.data, players=Array.isArray(pd.data)?pd.data:[];
  var winA=m.winner===m.team_a, winB=m.winner===m.team_b;

  /* Banner ghost logos */
  var banner=document.getElementById('dpHeroBanner');
  banner.querySelectorAll('.dp-banner-ghost').forEach(function(el){ el.remove(); });
  if(m.team_a_img){ var ga=document.createElement('img'); ga.className='dp-banner-ghost a'; ga.src='uploads/'+m.team_a_img; banner.insertBefore(ga,banner.firstChild); }
  if(m.team_b_img){ var gb=document.createElement('img'); gb.className='dp-banner-ghost b'; gb.src='uploads/'+m.team_b_img; banner.insertBefore(gb,banner.firstChild); }

  var logoAH=m.team_a_img
    ?'<img class="dp-banner-logo'+(winA?' is-winner':'')+'" src="uploads/'+xe(m.team_a_img)+'" alt="">'
    :'<div class="dp-banner-logo-ph">'+ini(m.team_a)+'</div>';
  var logoBH=m.team_b_img
    ?'<img class="dp-banner-logo'+(winB?' is-winner':'')+'" src="uploads/'+xe(m.team_b_img)+'" alt="">'
    :'<div class="dp-banner-logo-ph">'+ini(m.team_b)+'</div>';

  var teamAName='<div style="font-family:\'Cinzel\',serif;font-size:.82rem;font-weight:700;letter-spacing:.1em;color:var(--plat);margin-top:6px">'+xe(m.team_a)+'</div>';
  var teamBName='<div style="font-family:\'Cinzel\',serif;font-size:.82rem;font-weight:700;letter-spacing:.1em;color:var(--plat);margin-top:6px">'+xe(m.team_b)+'</div>';

  document.getElementById('dpBannerTeams').innerHTML=
    '<div class="dp-banner-col">'
      +'<div class="dp-banner-logo-wrap">'+(winA?'<div class="dp-banner-trophy">'+trophySvg(48)+'</div>':'')+logoAH+'</div>'
      +teamAName
      +(m.flag_a?flagHtml(m.flag_a,'dp-banner-flag'):'')
      +'<div style="display:flex;align-items:center;gap:6px;margin-top:4px"><span class="dp-banner-score-num '+(winA?'win':'lose')+'">'+m.score_a+'</span></div>'
    +'</div>'
    +'<div class="dp-banner-vs">'
      +'<div class="dp-banner-vs-badge">'+vsSvg()+'</div>'
      +'<div class="dp-banner-round">'+xe(m.round)+'</div>'
    +'</div>'
    +'<div class="dp-banner-col">'
      +'<div class="dp-banner-logo-wrap">'+(winB?'<div class="dp-banner-trophy">'+trophySvg(48)+'</div>':'')+logoBH+'</div>'
      +teamBName
      +(m.flag_b?flagHtml(m.flag_b,'dp-banner-flag'):'')
      +'<div style="display:flex;align-items:center;gap:6px;margin-top:4px"><span class="dp-banner-score-num '+(winB?'win':'lose')+'">'+m.score_b+'</span></div>'
    +'</div>';

  /* Action buttons inside overlay */
  document.getElementById('dpActions').innerHTML=
    '<button class="btn btn-sm btn-edit" onclick="closeDetail();openEdit('+m.id+')">✎ Edit</button>'
    +'<button class="btn btn-sm btn-del" onclick="closeDetail();openDelete('+m.id+',\''+xe(m.team_a+' vs '+m.team_b).replace(/'/g,'&#39;')+'\')">🗑</button>';

  var pA=players.filter(function(p){ return p.team_side==='A'; });
  var pB=players.filter(function(p){ return p.team_side==='B'; });
  document.getElementById('dpPlayers').innerHTML=
    buildTeamCol(m.team_a,m.team_a_img,m.flag_a||'','a',pA,winA)
    +buildTeamCol(m.team_b,m.team_b_img,m.flag_b||'','b',pB,winB);
}

function buildTeamCol(name,img,flag,side,players,isWinner){
  var logoH=img
    ?'<img style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:1px solid rgba(255,255,255,.14)'+(isWinner?';border-color:rgba(212,168,42,.55);filter:drop-shadow(0 0 7px rgba(212,168,42,.55))':'')+'" src="uploads/'+xe(img)+'" alt="">'
    :'<div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--mid),var(--deep));border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-family:Cinzel,serif;font-size:.5rem;color:var(--muted)">'+ini(name)+'</div>';
  var winStyle=isWinner?'box-shadow:inset 0 0 0 1px rgba(212,168,42,.18),0 3px 20px rgba(180,130,0,.13);':'';
  var colStyle=side==='a'
    ?'background:linear-gradient(90deg,rgba(21,101,192,.2),rgba(21,101,192,.04),transparent);border-top:1px solid rgba(66,165,245,.15);border-left:3px solid rgba(33,150,243,.55);color:var(--accent);'
    :'background:linear-gradient(90deg,rgba(120,20,20,.2),rgba(120,20,20,.04),transparent);border-top:1px solid rgba(239,154,154,.12);border-left:3px solid rgba(183,28,28,.65);color:#ef9a9a;';
  var hdr='<div style="display:flex;align-items:center;gap:9px;padding:13px 22px;font-family:\'Cinzel\',serif;font-size:.66rem;font-weight:700;letter-spacing:.12em;'+colStyle+winStyle+'">'
    +logoH
    +(flag?'<img src="'+flagUrl(flag)+'" style="width:20px;height:14px;border-radius:2px;object-fit:cover;margin-left:4px" alt="" onerror="this.style.display=\'none\'">':'')
    +(isWinner?'<span style="margin-left:auto;font-size:1rem" title="Winner">🏆</span>':'')
    +'</div>';
  var cols='<div class="dp-col-hdr"><span>Hero</span><span>Role</span><span>Player</span><span>Badge</span><span style="text-align:center">K / D / A</span></div>';
  var filled=players.filter(function(p){ return p.ign||p.hero_img; });
  var rows='';
  if(!filled.length){
    rows='<div style="text-align:center;padding:40px;color:var(--muted);font-style:italic;font-size:.82rem;font-family:\'Rajdhani\',sans-serif">No player data — edit to add.</div>';
  } else {
    filled.forEach(function(p){
      var hero=p.hero_img
        ?'<img class="dp-hero" src="uploads/'+xe(p.hero_img)+'" alt="" title="'+xe(p.hero_name||'')+'">'
        :'<div class="dp-hero-ph">⚔</div>';
      var role=p.role_img
        ?'<img class="dp-role-icon" src="uploads/'+xe(p.role_img)+'" alt="" title="'+xe(p.role_name||'')+'">'
        :(p.role_name?'<div class="dp-role-ph">'+roleEmoji(p.role_name)+'</div>':'<div class="dp-role-ph">—</div>');
      rows+='<div class="dp-player-row">'
        +hero+role
        +'<div><div class="dp-ign">'+xe(p.ign||'—')+'</div>'+(p.role_name?'<div class="dp-ign-role">'+xe(p.role_name)+'</div>':'')+'</div>'
        +'<div class="dp-badge">'+badgeHtml(p.badge)+'</div>'
        +'<div><div class="dp-kda">'+(+p.kills)+'/'+(+p.deaths)+'/'+(+p.assists)+'</div><div class="dp-kda-lbl">K / D / A</div></div>'
        +'</div>';
    });
  }
  return '<div class="dp-team-col">'+hdr+cols+rows+'</div>';
}
function roleEmoji(n){ if(!n) return '—'; var l=n.toLowerCase(); if(l.includes('exp')) return '🗡'; if(l.includes('gold')) return '💰'; if(l.includes('jung')) return '🌿'; if(l.includes('mid')) return '🔮'; if(l.includes('roam')) return '🛡'; return '⚔'; }
function closeDetail(){ gDetailId=null; document.getElementById('detail-overlay').classList.remove('open'); }
function ovClickClose(e){ if(e.target===document.getElementById('detail-overlay')) closeDetail(); }

/* ─── BADGE DISPLAY ──────────────────────────── */
function badgeHtml(badge){
  if(!badge||badge==='none') return '';
  var search=badge.toLowerCase().replace(/_/g,' ');
  var asset=gAssets.badge.find(function(a){ return a.name.toLowerCase()===search; });
  if(asset) return '<img class="dp-badge-img" src="uploads/'+xe(asset.filename)+'" alt="'+xe(badge)+'" title="'+xe(badge)+'">';
  var map={mvp:'★',gold:'★',silver:'★',bronze:'★','mvp lose':'⭐'};
  var colors={mvp:'var(--mvp-c)',gold:'var(--gold-c)',silver:'var(--silver-c)',bronze:'var(--bronze-c)','mvp lose':'var(--muted2)'};
  return '<span style="font-size:1.3rem;filter:drop-shadow(0 0 6px '+( colors[search]||'rgba(255,255,255,.5)')+');color:'+(colors[search]||'#fff')+'">'+(map[search]||'')+'</span>';
}

/* ─── ASSETS ─────────────────────────────────── */
async function loadAssets(){
  var d=await api('api.php?action=list_assets');
  if(d.data){
    gAssets.hero  =(d.data||[]).filter(function(a){ return a.type==='hero';  });
    gAssets.role  =(d.data||[]).filter(function(a){ return a.type==='role';  });
    gAssets.badge =(d.data||[]).filter(function(a){ return a.type==='badge'; });
  }
  renderAssetGrid();
}
function switchAssetTab(tab){
  gAssetTab=tab;
  ['hero','role','badge'].forEach(function(t){
    document.getElementById('aTab'+t.charAt(0).toUpperCase()+t.slice(1)).classList.toggle('active',t===tab);
  });
  renderAssetGrid();
}
function renderAssetGrid(){
  var grid=document.getElementById('assetGrid'), list=gAssets[gAssetTab]||[];
  if(!list.length){ grid.innerHTML='<div style="text-align:center;padding:40px;grid-column:1/-1;color:var(--muted);font-family:\'Rajdhani\',sans-serif;font-size:.85rem">No '+gAssetTab+' assets yet.</div>'; return; }
  grid.innerHTML=list.map(function(a){
    var classBadge=a.hero_class?'<div class="asset-class-badge">'+xe(a.hero_class)+'</div>':'';
    var classSelHtml=gAssetTab==='hero'
      ?'<select class="asset-class-sel" onchange="updateAssetClass('+a.id+',this.value)" title="Set hero class">'
        +['','Tank','Fighter','Assassin','Mage','Marksman','Support'].map(function(c){ return '<option value="'+xe(c)+'"'+(a.hero_class===c?' selected':'')+'>'+( c||'— Class —')+'</option>'; }).join('')
        +'</select>'
      :'';
    return '<div class="asset-item'+(gAssetTab==='badge'?' badge-asset':'')+'" title="'+xe(a.name)+'">'
      +'<img src="uploads/'+xe(a.filename)+'" alt="'+xe(a.name)+'">'
      +'<div class="asset-item-name">'+xe(a.name)+'</div>'
      +classBadge+classSelHtml
      +'<button class="asset-del-btn" onclick="event.stopPropagation();deleteAsset('+a.id+',\''+xe(a.name).replace(/'/g,'&#39;')+'\')">✕</button>'
    +'</div>';
  }).join('');
}
async function updateAssetClass(id,cls){
  var fd=new FormData(); fd.append('id',id); fd.append('hero_class',cls);
  var d=await api('api.php?action=update_asset_class',{method:'POST',body:fd});
  if(d.success){ var a=gAssets.hero.find(function(x){ return x.id==id; }); if(a) a.hero_class=cls; renderAssetGrid(); }
  else toast(d.error||'Failed','err');
}
async function uploadAsset(){
  var type=document.getElementById('assetType').value;
  var name=document.getElementById('assetName').value.trim();
  var hclass=type==='hero'?(document.getElementById('assetClass').value||''):'';
  var file=document.getElementById('assetFile').files[0];
  if(!name||!file){ toast('Name and image required','err'); return; }
  var fd=new FormData(); fd.append('type',type); fd.append('name',name); fd.append('hero_class',hclass); fd.append('file',file);
  var d=await api('api.php?action=upload_asset',{method:'POST',body:fd});
  if(d.error){ toast(d.error,'err'); return; }
  toast(name+' uploaded!','ok');
  document.getElementById('assetName').value=''; document.getElementById('assetFile').value='';
  await loadAssets(); switchAssetTab(type);
}
async function deleteAsset(id,name){
  if(!confirm('Delete asset: '+name+'?')) return;
  var fd=new FormData(); fd.append('id',id);
  var d=await api('api.php?action=delete_asset',{method:'POST',body:fd});
  if(d.error){ toast(d.error,'err'); return; }
  toast('Asset deleted.','ok'); await loadAssets();
}
function toggleHeroClassField(){
  var type=document.getElementById('assetType').value;
  document.getElementById('assetClassWrap').style.display=type==='hero'?'flex':'none';
}
function openAssetLib(){ openOv('ovAsset'); renderAssetGrid(); }

/* ─── CREATE / EDIT ──────────────────────────── */
function openCreate(){
  gEditId=null;
  document.getElementById('fmTitle').textContent='Add Match';
  document.getElementById('fA').value=''; document.getElementById('fB').value='';
  document.getElementById('fSA').value='0'; document.getElementById('fSB').value='0';
  document.getElementById('fR').value=''; document.getElementById('fW').innerHTML='<option value="">— Select Winner —</option>';
  document.getElementById('fFlagA').value=''; document.getElementById('fFlagB').value='';
  resetLogo('ufA','upA','uzA','ulA'); resetLogo('ufB','upB','uzB','ulB');
  document.getElementById('pSection').style.display='none';
  openOv('ovForm');
}
async function openEdit(id){
  gEditId=id;
  document.getElementById('fmTitle').textContent='Edit Match';
  openOv('ovForm');
  var d=await api('api.php?action=get&id='+id);
  if(d.error){ toast(d.error,'err'); return; }
  var m=d.data;
  document.getElementById('fA').value=m.team_a; document.getElementById('fB').value=m.team_b;
  document.getElementById('fSA').value=m.score_a; document.getElementById('fSB').value=m.score_b;
  document.getElementById('fR').value=m.round;
  document.getElementById('fFlagA').value=m.flag_a||''; document.getElementById('fFlagB').value=m.flag_b||'';
  syncW(m.winner);
  if(m.team_a_img) setLogoPreview('upA','uzA','ulA','uploads/'+m.team_a_img);
  else resetLogo('ufA','upA','uzA','ulA');
  if(m.team_b_img) setLogoPreview('upB','uzB','ulB','uploads/'+m.team_b_img);
  else resetLogo('ufB','upB','uzB','ulB');
  /* Load players */
  document.getElementById('pSection').style.display='block';
  var pd=await api('api.php?action=get_players&id='+id);
  renderPlayerEditor(pd.data||[],m.team_a,m.team_b);
}

async function saveMatch(){
  var btn=document.getElementById('btnSave');
  btn.innerHTML='<span class="spin"></span> Saving…'; btn.disabled=true;
  var fd=new FormData();
  if(gEditId) fd.append('id',gEditId);
  fd.append('team_a',document.getElementById('fA').value.trim());
  fd.append('team_b',document.getElementById('fB').value.trim());
  fd.append('score_a',document.getElementById('fSA').value);
  fd.append('score_b',document.getElementById('fSB').value);
  fd.append('winner',document.getElementById('fW').value);
  fd.append('round',document.getElementById('fR').value.trim());
  fd.append('flag_a',document.getElementById('fFlagA').value);
  fd.append('flag_b',document.getElementById('fFlagB').value);
  var fA=document.getElementById('ufA'), fB=document.getElementById('ufB');
  if(fA.files[0]) fd.append('team_a_img',fA.files[0]);
  if(fB.files[0]) fd.append('team_b_img',fB.files[0]);
  var action=gEditId?'update':'create';
  var d=await api('api.php?action='+action,{method:'POST',body:fd});
  btn.innerHTML='Save Match'; btn.disabled=false;
  if(d.error){ toast(d.error,'err'); return; }
  if(!gEditId&&d.id){
    gEditId=+d.id;
    document.getElementById('pSection').style.display='block';
    var pd=await api('api.php?action=get_players&id='+gEditId);
    renderPlayerEditor(pd.data||[],document.getElementById('fA').value,document.getElementById('fB').value);
    toast('Match saved! Add players below.','ok');
    /* Immediately refresh the match list & rounds so the new match is visible
       even if the user accidentally closes the modal before saving players */
    loadMatches(); loadRounds();
  } else {
    toast('Match updated!','ok'); loadMatches(); loadRounds();
  }
}

/* ─── PLAYER EDITOR — Hero Class Tabs ───────── */
function renderPlayerEditor(players,nameA,nameB){
  document.getElementById('ptA').textContent=nameA||'Team A';
  document.getElementById('ptB').textContent=nameB||'Team B';
  var map={};
  players.forEach(function(p){ map[p.team_side+'_'+p.slot]=p; });

  var badgeOpts=['none','bronze','silver','gold','mvp','mvp_lose'].map(function(b){
    var label=b==='mvp_lose'?'MVP Lose':b==='mvp'?'MVP':b.charAt(0).toUpperCase()+b.slice(1);
    return {v:b,l:label};
  });

  ['A','B'].forEach(function(side){
    var box=document.getElementById('pg'+side), html='';
    for(var slot=1;slot<=5;slot++){
      var k=side+'_'+slot;
      var p=map[k]||{ign:'',kills:0,deaths:0,assists:0,hero_img:null,role_img:null,badge:'none',hero_name:'',role_name:''};
      var hSrc=p.hero_img?'uploads/'+xe(p.hero_img):'';
      var rSrc=p.role_img?'uploads/'+xe(p.role_img):'';

      /* Role dropdown */
      var roleOpts='<option value="">— Role —</option>'+gAssets.role.map(function(a){
        return '<option value="'+xe(a.filename)+'|'+xe(a.name)+'"'+(p.role_img===a.filename?' selected':'')+'>'+xe(a.name)+'</option>';
      }).join('');

      /* Badge dropdown */
      var bdgHtml=badgeOpts.map(function(b){ return '<option value="'+b.v+'"'+(p.badge===b.v?' selected':'')+'>'+b.l+'</option>'; }).join('');

      /* Hero class tabs + grid picker */
      var heroPickerHtml=buildHeroPicker(k, p.hero_img, p.hero_name);

      html+='<div class="prow">'
        /* Hero cell — categorized picker */
        +'<div class="asset-dd" style="align-items:flex-start;grid-column:1;min-width:56px">'
          +(hSrc?'<img class="asset-dd-img" id="hpv_'+k+'" src="'+hSrc+'" alt="">'
                :'<div style="width:50px;height:50px;border-radius:9px;background:var(--mid);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:var(--muted)" id="hph_'+k+'">⚔</div>')
          +'<button class="hpick-tab" style="font-size:.55rem;padding:2px 6px;margin-top:3px;width:52px" onclick="toggleHeroPicker(\''+k+'\')">Pick</button>'
        +'</div>'
        /* Hero picker popup */
        +'<div id="hpick_'+k+'" style="display:none;position:absolute;z-index:50;background:rgba(4,12,30,.97);border:1px solid var(--border2);border-radius:10px;padding:10px;min-width:280px;backdrop-filter:blur(18px);box-shadow:0 12px 50px rgba(0,0,0,.8);margin-top:56px;margin-left:-2px">'
          +heroPickerHtml
        +'</div>'
        /* Role */
        +'<div class="asset-dd">'
          +(rSrc?'<img class="asset-dd-img" id="rpv_'+k+'" src="'+rSrc+'" alt="">'
                :'<div style="width:50px;height:50px;border-radius:9px;background:var(--mid);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:var(--muted)" id="rph_'+k+'">🛡</div>')
          +'<select class="asset-dd-sel" id="rdd_'+k+'" onchange="onRoleDd(\''+k+'\')">'+roleOpts+'</select>'
        +'</div>'
        /* IGN */
        +'<input class="fi" type="text" id="pi_'+k+'" placeholder="IGN" value="'+xe(p.ign||'')+'">'
        /* KDA */
        +'<input class="fi kda-in" type="number" id="pk_'+k+'" min="0" value="'+(+p.kills||0)+'">'
        +'<input class="fi kda-in" type="number" id="pd_'+k+'" min="0" value="'+(+p.deaths||0)+'">'
        +'<input class="fi kda-in" type="number" id="pa_'+k+'" min="0" value="'+(+p.assists||0)+'">'
        /* Badge */
        +'<select class="fi badge-sel" id="pb_'+k+'">'+bdgHtml+'</select>'
        /* Hidden fields for hero filename/name */
        +'<input type="hidden" id="hfn_'+k+'" value="'+xe(p.hero_img||'')+'">'
        +'<input type="hidden" id="hnn_'+k+'" value="'+xe(p.hero_name||'')+'">'
      +'</div>';
    }
    box.innerHTML=html;
  });
  swTab('A');
}

/* Build categorized hero picker HTML for one player slot */
function buildHeroPicker(k, currentFilename, currentHeroName){
  var tabs='<div class="hpick-tabs">'
    +'<button class="hpick-tab active" id="hptAll_'+k+'" onclick="filterHeroPicker(\''+k+'\',\'all\')">All</button>'
    +HERO_CLASSES.map(function(c){
      var id='hpt'+c+'_'+k;
      return '<button class="hpick-tab" id="'+id+'" onclick="filterHeroPicker(\''+k+'\',\''+c+'\')">'+c+'</button>';
    }).join('')
    +'</div>';
  var grid='<div class="hpick-grid" id="hpgrid_'+k+'">';
  var heroes=gAssets.hero;
  if(!heroes.length){
    grid+='<div class="hpick-empty">No heroes — upload in Assets.</div>';
  } else {
    heroes.forEach(function(a){
      var sel=(a.filename===currentFilename);
      grid+='<div class="hpick-item'+(sel?' selected':'')+'" id="hi_'+k+'_'+a.id+'" data-fn="'+xe(a.filename)+'" data-name="'+xe(a.name)+'" data-class="'+xe(a.hero_class||'')+'" onclick="selectHero(\''+k+'\',\''+xe(a.filename).replace(/'/g,'&#39;')+'\',\''+xe(a.name).replace(/'/g,'&#39;')+'\',this)">'
        +'<img src="uploads/'+xe(a.filename)+'" alt="'+xe(a.name)+'">'
        +'<span>'+xe(a.name)+'</span>'
        +'</div>';
    });
  }
  grid+='</div>';
  var closeBtn='<div style="text-align:right;margin-top:7px"><button class="btn btn-sm btn-cancel" onclick="closeHeroPicker(\''+k+'\')">✕ Close</button></div>';
  return tabs+grid+closeBtn;
}

function toggleHeroPicker(k){
  var el=document.getElementById('hpick_'+k);
  /* Close all others first */
  document.querySelectorAll('[id^="hpick_"]').forEach(function(p){ if(p.id!=='hpick_'+k) p.style.display='none'; });
  el.style.display=(el.style.display==='none'?'block':'none');
}
function closeHeroPicker(k){ document.getElementById('hpick_'+k).style.display='none'; }

function filterHeroPicker(k, cls){
  /* Tab active state */
  document.querySelectorAll('[id^="hpt"][id$="_'+k+'"]').forEach(function(t){ t.classList.remove('active'); });
  var tabId=cls==='all'?'hptAll_'+k:'hpt'+cls+'_'+k;
  var t=document.getElementById(tabId); if(t) t.classList.add('active');
  /* Filter items */
  var grid=document.getElementById('hpgrid_'+k);
  if(!grid) return;
  grid.querySelectorAll('.hpick-item').forEach(function(item){
    var ic=item.getAttribute('data-class')||'';
    item.style.display=(cls==='all'||ic===cls)?'':'none';
  });
}

function selectHero(k, filename, heroName, el){
  /* Update hidden fields */
  document.getElementById('hfn_'+k).value=filename;
  document.getElementById('hnn_'+k).value=heroName;
  /* Update preview */
  var img=document.getElementById('hpv_'+k), ph=document.getElementById('hph_'+k);
  var src='uploads/'+filename;
  if(img){ img.src=src; img.style.display='block'; }
  else if(ph){
    var ni=document.createElement('img'); ni.className='asset-dd-img'; ni.id='hpv_'+k; ni.alt=''; ni.src=src;
    ph.parentNode.replaceChild(ni,ph);
  }
  if(ph) ph.style.display='none';
  /* Selection highlight */
  var grid=document.getElementById('hpgrid_'+k);
  if(grid) grid.querySelectorAll('.hpick-item').forEach(function(i){ i.classList.remove('selected'); });
  if(el) el.classList.add('selected');
  /* Close picker */
  closeHeroPicker(k);
}

function onRoleDd(k){
  var sel=document.getElementById('rdd_'+k), val=sel.value;
  var img=document.getElementById('rpv_'+k), ph=document.getElementById('rph_'+k);
  if(!val){ if(img){ img.src=''; img.style.display='none'; } if(ph) ph.style.display='flex'; return; }
  var src='uploads/'+val.split('|')[0];
  if(!img&&ph){ var ni=document.createElement('img'); ni.className='asset-dd-img'; ni.id='rpv_'+k; ni.alt=''; ph.parentNode.replaceChild(ni,ph); img=ni; ph=null; }
  if(img){ img.src=src; img.style.display='block'; } if(ph) ph.style.display='none';
}

function swTab(side){
  document.getElementById('ptA').className='ptab'+(side==='A'?' on-a':'');
  document.getElementById('ptB').className='ptab'+(side==='B'?' on-b':'');
  document.getElementById('ppA').className='ppanel'+(side==='A'?' vis':'');
  document.getElementById('ppB').className='ppanel'+(side==='B'?' vis':'');
}

async function savePlayers(){
  if(!gEditId){ toast('Save the match first.','err'); return; }
  var btn=document.getElementById('btnSavePl');
  btn.innerHTML='<span class="spin"></span> Saving…'; btn.disabled=true;
  var fd=new FormData(); fd.append('match_id',gEditId);
  ['A','B'].forEach(function(side){
    for(var slot=1;slot<=5;slot++){
      var k=side+'_'+slot;
      var ign=document.getElementById('pi_'+k);
      if(!ign) continue;
      fd.append('ign['+k+']',ign.value.trim());
      fd.append('kills['+k+']',(document.getElementById('pk_'+k)||{value:'0'}).value||'0');
      fd.append('deaths['+k+']',(document.getElementById('pd_'+k)||{value:'0'}).value||'0');
      fd.append('assists['+k+']',(document.getElementById('pa_'+k)||{value:'0'}).value||'0');
      fd.append('badge['+k+']',(document.getElementById('pb_'+k)||{value:'none'}).value);
      var hfn=document.getElementById('hfn_'+k), hnn=document.getElementById('hnn_'+k);
      if(hfn&&hfn.value){ fd.append('hero_filename['+k+']',hfn.value); fd.append('hero_name['+k+']',hnn?hnn.value:''); }
      var rdd=document.getElementById('rdd_'+k);
      if(rdd&&rdd.value){ var rp=rdd.value.split('|'); fd.append('role_filename['+k+']',rp[0]||''); fd.append('role_name['+k+']',rp[1]||''); }
    }
  });
  var d=await api('api.php?action=save_players',{method:'POST',body:fd});
  btn.innerHTML='💾 Save Player Details'; btn.disabled=false;
  if(d.error){ toast(d.error,'err'); return; }
  toast('Player details saved!','ok');
  if(gDetailId===gEditId) openDetail(gDetailId);
  loadMatches();
}

/* ─── DELETE ─────────────────────────────────── */
function openDelete(id,label){ gDelId=+id; document.getElementById('delLbl').textContent=label; openOv('ovDel'); }
async function doDelete(){
  if(!gDelId) return;
  var fd=new FormData(); fd.append('id',gDelId);
  var d=await api('api.php?action=delete',{method:'POST',body:fd});
  closeOv('ovDel');
  if(d.error){ toast(d.error,'err'); return; }
  toast('Match deleted.','ok');
  if(gDetailId===gDelId) closeDetail();
  gDelId=null; loadMatches(); loadRounds();
}

/* ─── WINNER SYNC ────────────────────────────── */
function syncW(sel){
  var a=document.getElementById('fA').value.trim()||'Team A';
  var b=document.getElementById('fB').value.trim()||'Team B';
  var el=document.getElementById('fW');
  var cur=typeof sel==='string'?sel:el.value;
  el.innerHTML='<option value="">— Select Winner —</option>'
    +'<option value="'+xe(a)+'"'+(cur===a?' selected':'')+'>'+xe(a)+'</option>'
    +'<option value="'+xe(b)+'"'+(cur===b?' selected':'')+'>'+xe(b)+'</option>';
}

/* ─── LOGO HELPERS ───────────────────────────── */
function previewLogo(input,prevId,zoneId,lblId){
  var file=input.files[0]; if(!file) return;
  var rd=new FileReader();
  rd.onload=function(e){ document.getElementById(prevId).src=e.target.result; document.getElementById(zoneId).classList.add('got'); document.getElementById(lblId).textContent=file.name; };
  rd.readAsDataURL(file);
}
function setLogoPreview(prevId,zoneId,lblId,src){ document.getElementById(prevId).src=src; document.getElementById(zoneId).classList.add('got'); document.getElementById(lblId).textContent='Current logo'; }
function resetLogo(fileId,prevId,zoneId,lblId){
  var old=document.getElementById(fileId);
  var neo=old.cloneNode(false);
  /* Re-capture prevId/zoneId/lblId in closure so the listener always points to
     the correct element IDs regardless of when it fires */
  (function(pid,zid,lid){ neo.addEventListener('change',function(){ previewLogo(this,pid,zid,lid); }); })(prevId,zoneId,lblId);
  old.parentNode.replaceChild(neo,old);
  document.getElementById(prevId).src=''; document.getElementById(zoneId).classList.remove('got'); document.getElementById(lblId).textContent='📁 Click to upload';
}

/* ─── MODAL HELPERS ──────────────────────────── */
function openOv(id) { document.getElementById(id).classList.add('open'); }
function closeOv(id){
  document.getElementById(id).classList.remove('open');
  if(id==='ovForm'){
    /* Always reload the list when the form closes so any match that was
       persisted (even if the user accidentally dismissed before finishing
       players) shows up immediately — no manual page refresh needed. */
    var hadEdit=gEditId;
    gEditId=null;
    if(hadEdit){ loadMatches(); loadRounds(); }
  }
}
function ovc(e,id){ if(e.target===document.getElementById(id)) closeOv(id); }

/* ─── TOAST ──────────────────────────────────── */
function toast(msg,type){
  var t=document.getElementById('toast'); t.textContent=msg; t.className='show '+(type||'ok');
  clearTimeout(t._t); t._t=setTimeout(function(){ t.className=''; },3400);
}

/* ─── UTILS ──────────────────────────────────── */
function xe(s){ if(s==null) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); }
function ini(n){ return ((n||'?')+'').split(' ').map(function(w){ return w[0]||''; }).join('').toUpperCase().slice(0,2)||'?'; }
function debounce(fn,ms){ var t; return function(){ var a=arguments; clearTimeout(t); t=setTimeout(function(){ fn.apply(null,a); },ms); }; }
</script>
</body>
</html>