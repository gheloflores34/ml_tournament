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
/* ═══════════════ MAIN TABLE ═══════════════ */
.tbl-wrap{
  background:var(--panel);
  border:1px solid var(--border);
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 8px 40px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.03);
}
table{width:100%;border-collapse:collapse}

thead tr{
  background:linear-gradient(90deg,#071830,#091e38,#071830);
  border-bottom:1px solid var(--border2);
}
thead th{
  padding:12px 14px;
  text-align:left;
  font-family:'Orbitron',sans-serif;
  font-size:.6rem;font-weight:700;
  letter-spacing:.18em;text-transform:uppercase;
  color:var(--accent);
}

tbody tr{
  border-bottom:1px solid rgba(13,48,96,.4);
  transition:background .15s;
  position:relative;
}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(21,101,192,.08)}

td{padding:11px 14px;font-size:.86rem;vertical-align:middle}

/* Team cell */
.tc{display:flex;align-items:center;gap:9px}
.av{
  width:34px;height:34px;border-radius:50%;
  object-fit:cover;
  border:2px solid var(--border2);
  flex-shrink:0;
  box-shadow:0 0 8px rgba(21,101,192,.3);
}
.av-ph{
  width:34px;height:34px;border-radius:50%;
  background:linear-gradient(135deg,var(--panel2),var(--mid));
  border:2px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  font-family:'Orbitron',sans-serif;
  font-size:.55rem;color:var(--muted);font-weight:700;flex-shrink:0;
}

/* Score display */
.sc{
  font-family:'Orbitron',sans-serif;font-size:1rem;font-weight:700;
  display:flex;align-items:center;gap:6px;
}
.sc-n{color:var(--bright)}
.sc-s{color:var(--border2)}

/* Winner badge */
.wb{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(0,230,118,.07);
  border:1px solid rgba(0,230,118,.28);
  color:var(--win);
  padding:5px 10px;border-radius:6px;
  font-family:'Rajdhani',sans-serif;font-size:.8rem;font-weight:700;
  cursor:pointer;
  transition:all .18s;
  letter-spacing:.05em;
}
.wb:hover{background:rgba(0,230,118,.15);box-shadow:0 0 12px rgba(0,230,118,.2)}
.wb img{width:20px;height:20px;border-radius:50%;object-fit:cover;border:1px solid rgba(0,230,118,.4)}

/* Round badge */
.rb{
  background:rgba(21,101,192,.16);
  border:1px solid rgba(66,165,245,.2);
  color:var(--bright);
  padding:4px 9px;border-radius:5px;
  font-family:'Rajdhani',sans-serif;font-size:.77rem;font-weight:600;
  white-space:nowrap;letter-spacing:.04em;
}

/* Empty state */
.empty-row{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-row .ei{font-size:2.8rem;margin-bottom:12px;opacity:.5}
.empty-row p{font-family:'Rajdhani',sans-serif;letter-spacing:.1em;font-size:.9rem}

/* ═══════════════ MODAL BASE ═══════════════ */
.ov{
  display:none;position:fixed;inset:0;
  background:rgba(1,9,19,.88);
  backdrop-filter:blur(8px);
  z-index:200;align-items:center;justify-content:center;padding:14px;
}
.ov.open{display:flex}

.modal{
  background:linear-gradient(180deg,#091e38,#040f1f);
  border:1px solid var(--border2);
  border-radius:14px;
  width:100%;max-height:94vh;overflow-y:auto;
  animation:mIn .22s cubic-bezier(.16,1,.3,1);
  box-shadow:0 24px 80px rgba(0,0,0,.6), 0 0 0 1px rgba(66,165,245,.05) inset;
  position:relative;
}
.modal::before{
  content:'';
  position:absolute;top:0;left:20px;right:20px;height:1px;
  background:linear-gradient(90deg,transparent,var(--border2),var(--accent),var(--border2),transparent);
  border-radius:4px;
}
@keyframes mIn{
  from{opacity:0;transform:translateY(-20px) scale(.96)}
  to{opacity:1;transform:none}
}

.mh{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 22px;
  border-bottom:1px solid var(--border);
  position:sticky;top:0;
  background:linear-gradient(180deg,#091e38,rgba(9,30,56,.95));
  z-index:3;backdrop-filter:blur(4px);
}
.mt{
  font-family:'Orbitron',sans-serif;font-size:1rem;font-weight:700;
  letter-spacing:.12em;text-transform:uppercase;color:var(--accent);
}
.mc{
  background:rgba(255,255,255,.04);border:1px solid var(--border);
  color:var(--muted2);font-size:1rem;cursor:pointer;
  line-height:1;transition:all .2s;flex-shrink:0;
  width:30px;height:30px;border-radius:6px;
  display:flex;align-items:center;justify-content:center;
}
.mc:hover{color:var(--text);background:rgba(255,255,255,.08);border-color:var(--border2)}
.mb{padding:22px}

/* ═══════════════ DETAIL MODAL ═══════════════ */
.dm{max-width:880px}

/* Match banner */
.d-banner{
  display:grid;grid-template-columns:1fr auto 1fr;
  align-items:center;gap:0;
  padding:22px 26px 18px;
  background:linear-gradient(135deg,rgba(21,101,192,.2) 0%,rgba(9,30,56,.4) 50%,rgba(183,28,28,.1) 100%);
  border-bottom:1px solid var(--border);
  position:relative;
  overflow:hidden;
}
.d-banner::before{
  content:'';position:absolute;
  top:50%;left:50%;transform:translate(-50%,-50%);
  width:200px;height:200px;
  background:radial-gradient(circle,rgba(21,101,192,.12),transparent 70%);
  pointer-events:none;
}

.d-side{display:flex;align-items:center;gap:12px}
.d-side.right{flex-direction:row-reverse;text-align:right}

.d-logo{
  width:56px;height:56px;border-radius:50%;
  object-fit:cover;
  border:2px solid var(--border2);
  flex-shrink:0;background:var(--mid);
  box-shadow:0 0 16px rgba(21,101,192,.4);
}
.d-name{
  font-family:'Rajdhani',sans-serif;
  font-size:1.1rem;font-weight:700;
  letter-spacing:.05em;color:var(--text);line-height:1.2;
}

.d-vs{
  display:flex;flex-direction:column;align-items:center;
  padding:0 20px;gap:2px;
}
.d-vs-hex{
  width:48px;height:48px;
  background:linear-gradient(135deg,var(--panel2),var(--mid));
  border:1px solid var(--border2);
  clip-path:polygon(50% 0%,100% 25%,100% 75%,50% 100%,0% 75%,0% 25%);
  display:flex;align-items:center;justify-content:center;
}
.d-vs-txt{
  font-family:'Orbitron',sans-serif;
  font-size:.62rem;font-weight:700;color:var(--accent);letter-spacing:.16em;
}

/* Score strip */
.d-score{
  display:flex;align-items:center;justify-content:center;gap:16px;
  padding:14px 26px;
  background:linear-gradient(180deg,rgba(7,24,48,.8),rgba(4,15,31,.9));
  border-bottom:1px solid var(--border);
}
.d-sv{
  font-family:'Orbitron',sans-serif;font-size:2.4rem;font-weight:900;
  min-width:42px;text-align:center;line-height:1;
}
.d-sv.win{color:var(--win);text-shadow:0 0 20px rgba(0,230,118,.5)}
.d-sv.lose{color:var(--loss)}
.d-colon{
  font-family:'Orbitron',sans-serif;font-size:1.8rem;
  color:var(--border2);line-height:1;
}
.d-wlbl{
  font-family:'Orbitron',sans-serif;
  font-size:.55rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;
}
.d-wname{
  font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;
  color:var(--win);letter-spacing:.06em;margin-top:2px;
}

/* Scoreboard */
.sb-sec{padding-bottom:8px}
.sb-th{
  display:flex;align-items:center;gap:8px;
  padding:10px 20px;
  font-family:'Orbitron',sans-serif;font-size:.65rem;
  font-weight:700;letter-spacing:.14em;text-transform:uppercase;
}
.sb-th.ta{
  background:linear-gradient(90deg,rgba(21,101,192,.3),rgba(21,101,192,.05),transparent);
  color:var(--accent);
  border-top:1px solid rgba(66,165,245,.2);
  border-left:3px solid var(--blue2);
}
.sb-th.tb{
  background:linear-gradient(90deg,rgba(183,28,28,.25),rgba(183,28,28,.05),transparent);
  color:#ef9a9a;
  border-top:1px solid rgba(239,154,154,.2);
  border-left:3px solid #c62828;
}
.sb-cols{
  display:grid;grid-template-columns:54px 1fr 90px;gap:8px;
  padding:6px 20px 4px;
  font-family:'Orbitron',sans-serif;font-size:.55rem;
  letter-spacing:.14em;text-transform:uppercase;color:var(--muted);
  border-bottom:1px solid rgba(255,255,255,.04);
}
.sb-row{
  display:grid;grid-template-columns:54px 1fr 90px;gap:8px;
  align-items:center;padding:10px 20px;
  border-bottom:1px solid rgba(13,48,96,.3);
  transition:background .15s;
}
.sb-row:last-child{border-bottom:none}
.sb-row:hover{background:rgba(21,101,192,.07)}
.sb-hero{
  width:46px;height:46px;border-radius:8px;object-fit:cover;
  border:1px solid var(--border2);
  box-shadow:0 2px 10px rgba(0,0,0,.4);
}
.sb-hero-ph{
  width:46px;height:46px;border-radius:8px;
  background:linear-gradient(135deg,var(--panel2),var(--mid));
  border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  font-size:1.3rem;color:var(--muted);
}
.sb-ign{font-family:'Rajdhani',sans-serif;font-size:.95rem;font-weight:700;color:var(--text);letter-spacing:.03em}
.sb-kda{
  font-family:'Orbitron',sans-serif;font-size:.95rem;font-weight:700;
  color:var(--bright);text-align:center;
}
.sb-kl{font-size:.58rem;color:var(--muted);text-align:center;letter-spacing:.1em;margin-top:2px}
.sb-empty{text-align:center;padding:22px;font-size:.84rem;color:var(--muted);font-style:italic}
/* ═══════════════ ADD/EDIT MODAL ═══════════════ */
.em{max-width:720px}
.fg{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.fgrp{display:flex;flex-direction:column;gap:6px}

label.lbl{
  font-family:'Orbitron',sans-serif;
  font-size:.6rem;font-weight:700;letter-spacing:.15em;
  text-transform:uppercase;color:var(--muted2);
}

.fi{
  background:rgba(4,15,31,.6);
  border:1px solid var(--border);
  color:var(--text);
  padding:10px 12px;border-radius:7px;
  font-family:'Exo 2',sans-serif;font-size:.88rem;
  outline:none;width:100%;
  transition:border-color .2s, box-shadow .2s;
}
.fi:focus{border-color:var(--accent);box-shadow:0 0 0 2px rgba(66,165,245,.1)}
.fi::placeholder{color:var(--muted)}

/* Logo upload zones */
.uz{
  background:rgba(4,15,31,.4);
  border:2px dashed var(--border);
  border-radius:9px;padding:14px 8px;
  text-align:center;cursor:pointer;
  transition:border-color .2s, background .2s;
  min-height:90px;
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;
}
.uz:hover{border-color:var(--accent);background:rgba(66,165,245,.04)}
.uz.got{border-style:solid;border-color:rgba(66,165,245,.5)}
.uz-prev{width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--accent);display:none;box-shadow:0 0 10px rgba(66,165,245,.3)}
.uz.got .uz-prev{display:block}
.uz-lbl{font-family:'Rajdhani',sans-serif;font-size:.74rem;color:var(--muted);pointer-events:none;letter-spacing:.06em}
.uz.got .uz-lbl{color:var(--accent);font-size:.68rem}

/* Divider */
.divider{
  display:flex;align-items:center;gap:12px;
  margin:24px 0 16px;
}
.divider-line{flex:1;height:1px;background:linear-gradient(90deg,var(--border),transparent)}
.divider-txt{
  font-family:'Orbitron',sans-serif;font-size:.6rem;font-weight:700;
  letter-spacing:.18em;text-transform:uppercase;color:var(--muted);white-space:nowrap;
}

/* Player tabs */
.ptabs{
  display:flex;border-radius:7px 7px 0 0;
  overflow:hidden;border:1px solid var(--border);
}
.ptab{
  flex:1;padding:10px;text-align:center;cursor:pointer;
  font-family:'Rajdhani',sans-serif;font-size:.82rem;font-weight:700;
  letter-spacing:.1em;text-transform:uppercase;
  background:var(--mid);color:var(--muted);
  border:none;transition:all .2s;
}
.ptab.on-a{background:rgba(21,101,192,.28);color:var(--accent);box-shadow:inset 0 -2px 0 var(--blue2)}
.ptab.on-b{background:rgba(183,28,28,.22);color:#ef9a9a;box-shadow:inset 0 -2px 0 #c62828}

.ppanel{
  border:1px solid var(--border);border-top:none;
  border-radius:0 0 9px 9px;
  background:rgba(0,0,0,.15);
  display:none;padding:12px;
}
.ppanel.vis{display:block}

/* Player edit column header */
.pchdr{
  display:grid;grid-template-columns:52px 1fr 58px 58px 58px;gap:8px;
  padding:4px 4px 8px;
  font-family:'Orbitron',sans-serif;font-size:.56rem;
  letter-spacing:.12em;text-transform:uppercase;color:var(--muted);
  border-bottom:1px solid rgba(255,255,255,.05);margin-bottom:4px;
}
.pchdr span{text-align:center}
.pchdr span:nth-child(2){text-align:left}

/* Player edit rows */
.prow{
  display:grid;grid-template-columns:52px 1fr 58px 58px 58px;gap:8px;
  align-items:center;padding:7px 4px;
  border-bottom:1px solid rgba(13,48,96,.3);
}
.prow:last-child{border-bottom:none}

/* Hero image zone (small square) */
.hz{
  width:48px;height:48px;border-radius:8px;
  background:var(--panel);border:2px dashed var(--border);
  cursor:pointer;display:flex;align-items:center;justify-content:center;
  overflow:hidden;flex-shrink:0;transition:border-color .2s;position:relative;
}
.hz:hover{border-color:var(--accent)}
.hz.got{border-style:solid;border-color:rgba(66,165,245,.5)}
.hz img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0;display:none}
.hz.got img{display:block}
.hz-lbl{font-size:.5rem;color:var(--muted);text-align:center;line-height:1.3;pointer-events:none;padding:2px}
.hz.got .hz-lbl{display:none}

/* K / D / A inputs */
.kda-in{text-align:center;padding:8px 4px}

/* Form actions */
.fa{
  display:flex;gap:10px;justify-content:flex-end;
  margin-top:20px;padding-top:16px;
  border-top:1px solid var(--border);
}

/* ═══════════════ CONFIRM ═══════════════ */
.cm{max-width:360px}
.ct{color:var(--muted2);font-size:.88rem;line-height:1.7;text-align:center;padding:4px 0}
.ct strong{color:var(--text)}

/* Delete warning icon area */
.del-icon{
  width:60px;height:60px;border-radius:50%;
  background:rgba(183,28,28,.12);
  border:2px solid rgba(239,154,154,.25);
  display:flex;align-items:center;justify-content:center;
  font-size:1.6rem;margin:0 auto 14px;
}
    }
