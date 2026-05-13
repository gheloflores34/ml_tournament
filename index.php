<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ML Tournament Results</title>
  <link rel="icon" type="image/png" href="ml_logo.png">
  <link
    href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@400;600;700&family=Exo+2:wght@300;400;600;700&display=swap"
    rel="stylesheet">
  <style>
    /* ═══════════════ ROOT ═══════════════ */
    :root {
      --navy: #010913;
      --dark: #040f1f;
      --mid: #071830;
      --panel: #091e38;
      --panel2: #0c2444;
      --border: #0f3870;
      --border2: #1a4a8a;
      --blue: #1565c0;
      --blue2: #1976d2;
      --blue3: #2196f3;
      --accent: #42a5f5;
      --bright: #90caf9;
      --glow: #64b5f6;
      --text: #e3f2fd;
      --muted: #5c7a9e;
      --muted2: #78909c;
      --win: #00e676;
      --loss: #ef5350;
      --gold: #ffd54f;
      --silver: #b0bec5;
      --bronze: #ff8a65;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }
    body{
  background:var(--navy);
  color:var(--text);
  font-family:'Exo 2',sans-serif;
  min-height:100vh;
  overflow-x:hidden;
}

/* Layered background: deep space + subtle grid */
body::before{
  content:'';
  position:fixed;inset:0;
  background:
    radial-gradient(ellipse 80% 50% at 50% -10%, rgba(21,101,192,.18) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 10% 80%, rgba(13,71,161,.12) 0%, transparent 50%),
    radial-gradient(ellipse 50% 30% at 90% 90%, rgba(25,118,210,.08) 0%, transparent 50%);
  pointer-events:none;z-index:0;
}
body::after{
  content:'';
  position:fixed;inset:0;
  background-image:
    linear-gradient(rgba(21,101,192,.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(21,101,192,.06) 1px, transparent 1px);
  background-size:44px 44px;
  pointer-events:none;z-index:0;
}

/* ═══════════════ HEADER ═══════════════ */
header{
  position:relative;
  text-align:center;
  padding:0;
  overflow:hidden;
  border-bottom:1px solid var(--border);
}

.hdr-inner{
  position:relative;
  padding:32px 20px 26px;
  z-index:2;
}

/* Dramatic top glow bar */
header::before{
  content:'';
  position:absolute;
  top:0;left:0;right:0;
  height:2px;
  background:linear-gradient(90deg, transparent, var(--blue3), var(--accent), var(--blue3), transparent);
  box-shadow:0 0 20px rgba(33,150,243,.8), 0 0 60px rgba(33,150,243,.3);
}

.hdr-bg{
  position:absolute;top:50%;left:50%;
  transform:translate(-50%,-50%);
  width:480px;opacity:.07;
  pointer-events:none;
  filter:brightness(2) saturate(2) blur(1px);
}

/* Corner hex decorations */
.hdr-corner{
  position:absolute;top:14px;
  width:70px;height:70px;
  opacity:.12;
  border:1px solid var(--accent);
  clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
  background:linear-gradient(135deg,var(--blue),transparent);
}
.hdr-corner.left{left:18px;animation:hexPulse 4s ease-in-out infinite}
.hdr-corner.right{right:18px;animation:hexPulse 4s ease-in-out infinite .8s}

@keyframes hexPulse{
  0%,100%{opacity:.12;transform:scale(1)}
  50%{opacity:.22;transform:scale(1.05)}
}

.hdr-logo{
  width:72px;height:72px;
  position:relative;z-index:1;
  filter:drop-shadow(0 0 18px rgba(66,165,245,1)) brightness(1.4) saturate(1.4);
  animation:logoGlow 3s ease-in-out infinite;
  display:block;margin:0 auto 10px;
}
@keyframes logoGlow{
  0%,100%{filter:drop-shadow(0 0 16px rgba(66,165,245,.9)) brightness(1.3) saturate(1.3)}
  50%{filter:drop-shadow(0 0 32px rgba(100,181,246,1)) brightness(1.6) saturate(1.5)}
}

.hdr-title{
  font-family:'Orbitron',sans-serif;
  font-size:clamp(1.3rem,4vw,2.2rem);
  font-weight:900;
  letter-spacing:.22em;
  text-transform:uppercase;
  background:linear-gradient(135deg,#90caf9,#42a5f5,#1976d2);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
  filter:drop-shadow(0 0 20px rgba(66,165,245,.5));
  position:relative;z-index:1;
  margin-bottom:6px;
}

.hdr-sub{
  font-family:'Rajdhani',sans-serif;
  font-size:.8rem;
  letter-spacing:.4em;
  color:var(--muted2);
  text-transform:uppercase;
  position:relative;z-index:1;
}

/* Animated underline bar */
.hdr-line{
  height:1px;
  background:linear-gradient(90deg,transparent,var(--border2),var(--accent),var(--border2),transparent);
  position:relative;z-index:1;
  margin-top:20px;
}

/* ═══════════════ LAYOUT ═══════════════ */
.wrap{max-width:1140px;margin:0 auto;padding:28px 20px 70px;position:relative;z-index:1}

/* ═══════════════ STATS ═══════════════ */
.stats{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:26px}

.stat{
  flex:1;min-width:120px;
  position:relative;
  background:linear-gradient(135deg,var(--panel2),var(--panel));
  border:1px solid var(--border);
  border-radius:10px;
  padding:16px 18px;
  text-align:center;
  overflow:hidden;
  transition:border-color .25s, transform .2s;
}
.stat::before{
  content:'';
  position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,var(--blue3),transparent);
  opacity:0;
  transition:opacity .25s;
}
.stat:hover{border-color:var(--border2);transform:translateY(-2px)}
.stat:hover::before{opacity:1}
.stat-n{
  font-family:'Orbitron',sans-serif;
  font-size:2rem;font-weight:700;
  color:var(--accent);line-height:1;
  text-shadow:0 0 20px rgba(66,165,245,.4);
}
.stat-l{
  font-family:'Rajdhani',sans-serif;
  font-size:.72rem;letter-spacing:.2em;
  color:var(--muted);text-transform:uppercase;margin-top:5px;font-weight:600;
}

/* ═══════════════ SECTION HEADER ═══════════════ */
.section-hdr{
  display:flex;align-items:center;gap:12px;
  margin-bottom:14px;
}
.section-hdr-line{
  height:1px;flex:1;
  background:linear-gradient(90deg,var(--border),transparent);
}
.section-hdr-txt{
  font-family:'Orbitron',sans-serif;
  font-size:.65rem;font-weight:700;
  letter-spacing:.22em;text-transform:uppercase;
  color:var(--muted);white-space:nowrap;
}

/* ═══════════════ TOOLBAR ═══════════════ */
.toolbar{
  display:flex;flex-wrap:wrap;gap:10px;
  align-items:center;margin-bottom:18px;
}
.sw{flex:1;min-width:180px;position:relative}
.sw input{
  width:100%;
  background:var(--panel);
  border:1px solid var(--border);
  color:var(--text);
  padding:10px 12px 10px 36px;
  border-radius:7px;
  font-family:'Exo 2',sans-serif;font-size:.87rem;
  outline:none;
  transition:border-color .2s, box-shadow .2s;
}
.sw input:focus{border-color:var(--accent);box-shadow:0 0 0 2px rgba(66,165,245,.12)}
.sw input::placeholder{color:var(--muted)}
.sw::before{
  content:'⌕';
  position:absolute;left:11px;top:50%;transform:translateY(-50%);
  font-size:1rem;color:var(--muted);pointer-events:none;
}
select.rf{
  background:var(--panel);
  border:1px solid var(--border);
  color:var(--text);
  padding:10px 14px;border-radius:7px;
  font-family:'Exo 2',sans-serif;font-size:.87rem;
  outline:none;cursor:pointer;
  transition:border-color .2s, box-shadow .2s;
  appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%235c7a9e'/%3E%3C/svg%3E");
  background-repeat:no-repeat;
  background-position:right 12px center;
  padding-right:32px;
}
select.rf:focus{border-color:var(--accent);box-shadow:0 0 0 2px rgba(66,165,245,.12)}

/* ═══════════════ BUTTONS ═══════════════ */
.btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:10px 20px;border:none;border-radius:7px;
  font-family:'Rajdhani',sans-serif;font-size:.92rem;font-weight:700;
  letter-spacing:.08em;text-transform:uppercase;
  cursor:pointer;transition:all .2s;white-space:nowrap;
}
.btn-primary{
  background:linear-gradient(135deg,#1565c0,#1976d2,#1e88e5);
  color:#fff;
  box-shadow:0 4px 16px rgba(21,101,192,.4), inset 0 1px 0 rgba(255,255,255,.08);
  position:relative;overflow:hidden;
}
.btn-primary::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,transparent 40%,rgba(255,255,255,.08));
  pointer-events:none;
}
.btn-primary:hover{
  box-shadow:0 4px 24px rgba(66,165,245,.6), inset 0 1px 0 rgba(255,255,255,.15);
  transform:translateY(-1px);
}
.btn-sm{padding:6px 11px;font-size:.75rem}
.btn-edit{
  background:rgba(21,101,192,.15);
  color:var(--accent);
  border:1px solid rgba(66,165,245,.25);
}
.btn-edit:hover{background:rgba(21,101,192,.28);border-color:var(--accent)}
.btn-del{
  background:rgba(183,28,28,.15);
  color:#ef9a9a;
  border:1px solid rgba(239,154,154,.25);
}
.btn-del:hover{background:rgba(183,28,28,.28);border-color:#ef9a9a}
.btn-view{
  background:rgba(0,230,118,.08);
  color:var(--win);
  border:1px solid rgba(0,230,118,.25);
}
.btn-view:hover{background:rgba(0,230,118,.18);border-color:var(--win)}