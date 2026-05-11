<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ML Tournament Results</title>
<link rel="icon" type="image/png" href="ml_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
/* ═══════════════ ROOT ═══════════════ */
:root{
  --navy:#020b18; --dark:#040f1f; --mid:#071830; --panel:#0a2040;
  --border:#0d3060; --blue:#1565c0; --blue2:#1976d2; --accent:#42a5f5;
  --bright:#90caf9; --text:#e3f2fd; --muted:#78909c;
  --win:#00e676; --loss:#ef5350;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:var(--navy);color:var(--text);font-family:'Exo 2',sans-serif;min-height:100vh;overflow-x:hidden}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(21,101,192,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(21,101,192,.07) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;z-index:0}

/* ═══════════════ HEADER ═══════════════ */
header{position:relative;text-align:center;padding:24px 20px 18px;background:linear-gradient(180deg,#030d1f,transparent);border-bottom:1px solid var(--border);overflow:hidden}
.hdr-bg{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:420px;opacity:.12;pointer-events:none;filter:brightness(1.6) saturate(1.4)}
.hdr-logo{width:80px;position:relative;z-index:1;filter:drop-shadow(0 0 14px rgba(66,165,245,.9)) brightness(1.3) saturate(1.3);animation:glow 3s ease-in-out infinite}
@keyframes glow{0%,100%{filter:drop-shadow(0 0 14px rgba(66,165,245,.9)) brightness(1.3) saturate(1.3)}50%{filter:drop-shadow(0 0 28px rgba(66,165,245,1)) brightness(1.5) saturate(1.5)}}
.hdr-title{font-family:'Rajdhani',sans-serif;font-size:clamp(1.5rem,4vw,2.4rem);font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--accent);text-shadow:0 0 28px rgba(66,165,245,.6);position:relative;z-index:1;margin-top:6px}
.hdr-sub{font-size:.75rem;letter-spacing:.35em;color:var(--muted);text-transform:uppercase;margin-top:3px;position:relative;z-index:1}

/* ═══════════════ LAYOUT ═══════════════ */
.wrap{max-width:1100px;margin:0 auto;padding:26px 20px 60px;position:relative;z-index:1}

/* ═══════════════ STATS ═══════════════ */
.stats{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:22px}
.stat{flex:1;min-width:110px;background:var(--panel);border:1px solid var(--border);border-radius:8px;padding:12px 14px;text-align:center}
.stat-n{font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;color:var(--accent);line-height:1}
.stat-l{font-size:.68rem;letter-spacing:.15em;color:var(--muted);text-transform:uppercase;margin-top:3px}

/* ═══════════════ TOOLBAR ═══════════════ */
.toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:20px}
.sw{flex:1;min-width:170px;position:relative}
.sw input{width:100%;background:var(--panel);border:1px solid var(--border);color:var(--text);padding:10px 12px 10px 34px;border-radius:6px;font-family:inherit;font-size:.86rem;outline:none;transition:border-color .2s}
.sw input:focus{border-color:var(--accent)}
.sw::before{content:'🔍';position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:.78rem;pointer-events:none}
select.rf{background:var(--panel);border:1px solid var(--border);color:var(--text);padding:10px 12px;border-radius:6px;font-family:inherit;font-size:.86rem;outline:none;cursor:pointer;transition:border-color .2s}
select.rf:focus{border-color:var(--accent)}

/* ═══════════════ BUTTONS ═══════════════ */
.btn{display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border:none;border-radius:6px;font-family:'Rajdhani',sans-serif;font-size:.9rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;cursor:pointer;transition:all .2s;white-space:nowrap}
.btn-primary{background:linear-gradient(135deg,var(--blue),var(--blue2));color:#fff;box-shadow:0 0 14px rgba(21,101,192,.4)}
.btn-primary:hover{box-shadow:0 0 22px rgba(66,165,245,.6)}
.btn-sm{padding:6px 10px;font-size:.76rem}
.btn-edit{background:rgba(21,101,192,.2);color:var(--accent);border:1px solid rgba(66,165,245,.3)}
.btn-edit:hover{border-color:var(--accent)}
.btn-del{background:rgba(183,28,28,.2);color:#ef9a9a;border:1px solid rgba(239,154,154,.3)}
.btn-del:hover{border-color:#ef9a9a}
.btn-view{background:rgba(0,230,118,.08);color:var(--win);border:1px solid rgba(0,230,118,.3)}
.btn-view:hover{border-color:var(--win)}

/* ═══════════════ MAIN TABLE ═══════════════ */
.tbl-wrap{background:var(--panel);border:1px solid var(--border);border-radius:10px;overflow:hidden}
table{width:100%;border-collapse:collapse}
thead th{background:var(--mid);padding:11px 12px;text-align:left;font-family:'Rajdhani',sans-serif;font-size:.76rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--accent);border-bottom:1px solid var(--border)}
tbody tr{border-bottom:1px solid rgba(13,48,96,.5);transition:background .15s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(21,101,192,.09)}
td{padding:10px 12px;font-size:.85rem;vertical-align:middle}
.tc{display:flex;align-items:center;gap:8px}
.av{width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid var(--border);flex-shrink:0}
.av-ph{width:32px;height:32px;border-radius:50%;background:var(--mid);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.68rem;color:var(--muted);font-weight:700;flex-shrink:0}
.sc{font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:700;display:flex;align-items:center;gap:6px}
.sc-n{color:var(--bright)}
.sc-s{color:var(--muted)}
.wb{display:inline-flex;align-items:center;gap:5px;background:rgba(0,230,118,.08);border:1px solid rgba(0,230,118,.3);color:var(--win);padding:4px 8px;border-radius:4px;font-size:.76rem;font-weight:600;cursor:pointer;transition:background .15s}
.wb:hover{background:rgba(0,230,118,.16)}
.wb img{width:18px;height:18px;border-radius:50%;object-fit:cover}
.rb{background:rgba(21,101,192,.18);border:1px solid rgba(66,165,245,.22);color:var(--bright);padding:3px 7px;border-radius:4px;font-size:.74rem;white-space:nowrap}
.empty-row{text-align:center;padding:50px 20px;color:var(--muted)}
.empty-row .ei{font-size:2.6rem;margin-bottom:8px}

/* ═══════════════ MODAL BASE ═══════════════ */
.ov{display:none;position:fixed;inset:0;background:rgba(2,11,24,.9);backdrop-filter:blur(5px);z-index:200;align-items:center;justify-content:center;padding:14px}
.ov.open{display:flex}
.modal{background:var(--dark);border:1px solid var(--border);border-radius:12px;width:100%;max-height:94vh;overflow-y:auto;animation:mi .2s ease}
@keyframes mi{from{opacity:0;transform:translateY(-16px) scale(.97)}to{opacity:1;transform:none}}
.mh{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--dark);z-index:3}
.mt{font-family:'Rajdhani',sans-serif;font-size:1.15rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--accent)}
.mc{background:none;border:none;color:var(--muted);font-size:1.25rem;cursor:pointer;line-height:1;transition:color .2s;flex-shrink:0}
.mc:hover{color:var(--text)}
.mb{padding:20px}

/* ═══════════════ DETAIL MODAL ═══════════════ */
.dm{max-width:860px}

/* Banner: (logo) TeamA  vs  TeamB (logo) */
.d-banner{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:0;padding:18px 24px 14px;background:linear-gradient(135deg,rgba(21,101,192,.18),rgba(183,28,28,.12));border-bottom:1px solid var(--border);position:relative}
.d-side{display:flex;align-items:center;gap:10px}
.d-side.right{flex-direction:row-reverse;text-align:right}
.d-logo{width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--border);flex-shrink:0;background:var(--mid)}
.d-name{font-family:'Rajdhani',sans-serif;font-size:1.05rem;font-weight:700;letter-spacing:.05em;color:var(--text);line-height:1.2}
.d-vs{display:flex;flex-direction:column;align-items:center;padding:0 16px}
.d-vs-txt{font-family:'Rajdhani',sans-serif;font-size:.72rem;color:var(--muted);letter-spacing:.2em}

/* Score strip */
.d-score{display:flex;align-items:center;justify-content:center;gap:14px;padding:10px 24px;background:var(--mid);border-bottom:1px solid var(--border)}
.d-sv{font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;min-width:38px;text-align:center}
.d-sv.win{color:var(--win)}
.d-sv.lose{color:var(--loss)}
.d-colon{font-family:'Rajdhani',sans-serif;font-size:1.5rem;color:var(--muted)}
.d-wlbl{font-size:.68rem;letter-spacing:.18em;color:var(--muted);text-transform:uppercase}
.d-wname{font-family:'Rajdhani',sans-serif;font-size:.9rem;font-weight:700;color:var(--win)}

/* Scoreboard rows — 3 columns: hero | IGN | KDA */
.sb-sec{padding-bottom:6px}
.sb-th{display:flex;align-items:center;gap:8px;padding:9px 18px;font-family:'Rajdhani',sans-serif;font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
.sb-th.ta{background:linear-gradient(90deg,rgba(21,101,192,.28),transparent);color:var(--accent);border-top:1px solid rgba(66,165,245,.2)}
.sb-th.tb{background:linear-gradient(90deg,rgba(183,28,28,.22),transparent);color:#ef9a9a;border-top:1px solid rgba(239,154,154,.2)}
.sb-cols{display:grid;grid-template-columns:50px 1fr 90px;gap:8px;padding:5px 18px 3px;font-size:.66rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid rgba(255,255,255,.04)}
.sb-row{display:grid;grid-template-columns:50px 1fr 90px;gap:8px;align-items:center;padding:9px 18px;border-bottom:1px solid rgba(13,48,96,.35);transition:background .15s}
.sb-row:last-child{border-bottom:none}
.sb-row:hover{background:rgba(21,101,192,.08)}
.sb-hero{width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid var(--border)}
.sb-hero-ph{width:44px;height:44px;border-radius:8px;background:var(--mid);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--muted)}
.sb-ign{font-size:.9rem;font-weight:600;color:var(--text)}
.sb-kda{font-family:'Rajdhani',sans-serif;font-size:1.05rem;font-weight:700;color:var(--bright);text-align:center}
.sb-kl{font-size:.62rem;color:var(--muted);text-align:center;letter-spacing:.06em;margin-top:1px}
.sb-empty{text-align:center;padding:18px;font-size:.82rem;color:var(--muted)}

/* ═══════════════ ADD/EDIT MODAL ═══════════════ */
.em{max-width:700px}
.fg{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.fgrp{display:flex;flex-direction:column;gap:5px}
label.lbl{font-size:.72rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.fi{background:var(--panel);border:1px solid var(--border);color:var(--text);padding:9px 11px;border-radius:6px;font-family:inherit;font-size:.87rem;outline:none;width:100%;transition:border-color .2s}
.fi:focus{border-color:var(--accent)}

/* Logo upload zones */
.uz{background:var(--panel);border:2px dashed var(--border);border-radius:8px;padding:12px 8px;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;min-height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px}
.uz:hover{border-color:var(--accent);background:rgba(66,165,245,.04)}
.uz.got{border-style:solid;border-color:rgba(66,165,245,.5)}
.uz-prev{width:50px;height:50px;border-radius:50%;object-fit:cover;border:2px solid var(--accent);display:none}
.uz.got .uz-prev{display:block}
.uz-lbl{font-size:.72rem;color:var(--muted);pointer-events:none}
.uz.got .uz-lbl{color:var(--accent);font-size:.68rem}

/* divider */
.divider{display:flex;align-items:center;gap:12px;margin:22px 0 14px}
.divider-line{flex:1;height:1px;background:var(--border)}
.divider-txt{font-family:'Rajdhani',sans-serif;font-size:.76rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--muted);white-space:nowrap}

/* Player tabs */
.ptabs{display:flex;border-radius:6px 6px 0 0;overflow:hidden;border:1px solid var(--border)}
.ptab{flex:1;padding:9px;text-align:center;cursor:pointer;font-family:'Rajdhani',sans-serif;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:var(--mid);color:var(--muted);border:none;transition:all .2s}
.ptab.on-a{background:rgba(21,101,192,.28);color:var(--accent)}
.ptab.on-b{background:rgba(183,28,28,.22);color:#ef9a9a}
.ppanel{border:1px solid var(--border);border-top:none;border-radius:0 0 8px 8px;background:rgba(0,0,0,.12);display:none;padding:10px}
.ppanel.vis{display:block}

/* Player edit column header */
.pchdr{display:grid;grid-template-columns:52px 1fr 58px 58px 58px;gap:8px;padding:4px 4px 8px;font-size:.64rem;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid rgba(255,255,255,.05);margin-bottom:4px}
.pchdr span{text-align:center}
.pchdr span:nth-child(2){text-align:left}

/* Player edit rows */
.prow{display:grid;grid-template-columns:52px 1fr 58px 58px 58px;gap:8px;align-items:center;padding:6px 4px;border-bottom:1px solid rgba(13,48,96,.35)}
.prow:last-child{border-bottom:none}

/* Hero image upload zone (small square) */
.hz{width:48px;height:48px;border-radius:7px;background:var(--panel);border:2px dashed var(--border);cursor:pointer;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;transition:border-color .2s;position:relative}
.hz:hover{border-color:var(--accent)}
.hz.got{border-style:solid;border-color:rgba(66,165,245,.5)}
.hz img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0;display:none}
.hz.got img{display:block}
.hz-lbl{font-size:.52rem;color:var(--muted);text-align:center;line-height:1.3;pointer-events:none;padding:2px}
.hz.got .hz-lbl{display:none}

/* K / D / A inputs – centered numbers */
.kda-in{text-align:center;padding:8px 4px}

/* form actions row */
.fa{display:flex;gap:10px;justify-content:flex-end;margin-top:18px;padding-top:14px;border-top:1px solid var(--border)}

/* ═══════════════ CONFIRM ═══════════════ */
.cm{max-width:340px}
.ct{color:var(--muted);font-size:.86rem;line-height:1.65;text-align:center;padding:4px 0}
.ct strong{color:var(--text)}

/* ═══════════════ TOAST ═══════════════ */
#toast{position:fixed;bottom:22px;right:22px;background:var(--panel);border:1px solid var(--border);border-radius:8px;padding:11px 16px;font-size:.84rem;z-index:999;transform:translateY(60px);opacity:0;transition:all .26s;pointer-events:none;max-width:300px}
#toast.show{transform:none;opacity:1}
#toast.ok{border-color:var(--win);color:var(--win)}
#toast.err{border-color:#ef9a9a;color:#ef9a9a}

/* ═══════════════ SPINNER ═══════════════ */
.spin{display:inline-block;width:15px;height:15px;border:2px solid rgba(66,165,245,.3);border-top-color:var(--accent);border-radius:50%;animation:sp .6s linear infinite;vertical-align:middle}
@keyframes sp{to{transform:rotate(360deg)}}

/* ═══════════════ RESPONSIVE ═══════════════ */
@media(max-width:640px){
  .fg{grid-template-columns:1fr}
  thead th:nth-child(3),td:nth-child(3){display:none}
  .hdr-bg{width:220px}
  .prow{grid-template-columns:48px 1fr 46px 46px 46px}
  .sb-cols,.sb-row{grid-template-columns:44px 1fr 80px}
  .d-banner{padding:12px 14px 10px}
  .d-logo{width:40px;height:40px}
  .d-name{font-size:.88rem}
}
</style>
</head>
<body>

<!-- ═══════ HEADER ═══════ -->
<header>
  <img class="hdr-bg" src="ml_logo.png" alt="">
  <img class="hdr-logo" src="ml_logo.png" alt="ML">
  <div class="hdr-title">Tournament Results</div>
  <div class="hdr-sub">Mobile Legends &middot; 5v5 MOBA</div>
</header>

<!-- ═══════ MAIN ═══════ -->
<div class="wrap">
  <div class="stats">
    <div class="stat"><div class="stat-n" id="sTotal">—</div><div class="stat-l">Matches</div></div>
    <div class="stat"><div class="stat-n" id="sRounds">—</div><div class="stat-l">Rounds</div></div>
    <div class="stat"><div class="stat-n" id="sTeams">—</div><div class="stat-l">Teams</div></div>
  </div>

  <div class="toolbar">
    <div class="sw"><input type="text" id="q" placeholder="Search team or winner…"></div>
    <select class="rf" id="rf"><option value="">All Rounds</option></select>
    <button class="btn btn-primary" onclick="openCreate()">&#xFF0B; Add Match</button>
  </div>

  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th><th>Team A</th><th>vs</th><th>Team B</th>
          <th>Score</th><th>Winner</th><th>Round</th><th>Actions</th>
        </tr>
      </thead>
      <tbody id="tbl"><tr><td colspan="8"><div class="empty-row"><span class="spin"></span></div></td></tr></tbody>
    </table>
  </div>
</div>


<!-- ═══════════════════════════════════════════════════
     DETAIL MODAL — click winner badge to open
════════════════════════════════════════════════════ -->
<div class="ov" id="ovDetail" onclick="ovc(event,'ovDetail')">
  <div class="modal dm">

    <!-- Banner: logo · TeamA  vs  TeamB · logo -->
    <div class="d-banner">
      <div class="d-side" id="dSideA">
        <img class="d-logo" id="dLogoA" src="" alt="" style="display:none">
        <div class="d-logo" id="dLogoPHA" style="display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:var(--muted)">??</div>
        <div class="d-name" id="dNameA">—</div>
      </div>
      <div class="d-vs"><div class="d-vs-txt">VS</div></div>
      <div class="d-side right" id="dSideB">
        <div class="d-name" id="dNameB">—</div>
        <img class="d-logo" id="dLogoB" src="" alt="" style="display:none">
        <div class="d-logo" id="dLogoPHB" style="display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:var(--muted)">??</div>
      </div>
      <button class="mc" onclick="closeOv('ovDetail')" style="position:absolute;top:12px;right:14px">&#x2715;</button>
    </div>

    <!-- Score strip -->
    <div class="d-score">
      <div class="d-sv" id="dSA">0</div>
      <div class="d-colon">:</div>
      <div class="d-sv" id="dSB">0</div>
      <div style="margin-left:16px">
        <div class="d-wlbl">Winner</div>
        <div class="d-wname" id="dWinner">—</div>
      </div>
    </div>

    <!-- Scoreboard -->
    <div id="dBody"><div class="empty-row" style="padding:36px"><span class="spin"></span></div></div>

  </div>
</div>


<!-- ═══════════════════════════════════════════════════
     ADD / EDIT MODAL
════════════════════════════════════════════════════ -->
<div class="ov" id="ovForm" onclick="ovc(event,'ovForm')">
  <div class="modal em">
    <div class="mh">
      <span class="mt" id="fmTitle">Add Match</span>
      <button class="mc" onclick="closeOv('ovForm')">&#x2715;</button>
    </div>
    <div class="mb">

      <!-- ── Main match fields ── -->
      <div class="fg">
        <div class="fgrp">
          <label class="lbl">Team A Name</label>
          <input class="fi" type="text" id="fA" placeholder="e.g. Alpha Warriors">
        </div>
        <div class="fgrp">
          <label class="lbl">Team B Name</label>
          <input class="fi" type="text" id="fB" placeholder="e.g. Iron Wolves">
        </div>
        <div class="fgrp">
          <label class="lbl">Team A Logo</label>
          <div class="uz" id="uzA" onclick="document.getElementById('ufA').click()">
            <img class="uz-prev" id="upA" alt="">
            <span class="uz-lbl" id="ulA">&#128193; Click to upload</span>
          </div>
          <input type="file" id="ufA" accept="image/*" style="display:none">
        </div>
        <div class="fgrp">
          <label class="lbl">Team B Logo</label>
          <div class="uz" id="uzB" onclick="document.getElementById('ufB').click()">
            <img class="uz-prev" id="upB" alt="">
            <span class="uz-lbl" id="ulB">&#128193; Click to upload</span>
          </div>
          <input type="file" id="ufB" accept="image/*" style="display:none">
        </div>
        <div class="fgrp">
          <label class="lbl">Score (Team A)</label>
          <input class="fi" type="number" id="fSA" min="0" value="0">
        </div>
        <div class="fgrp">
          <label class="lbl">Score (Team B)</label>
          <input class="fi" type="number" id="fSB" min="0" value="0">
        </div>
        <div class="fgrp">
          <label class="lbl">Winner</label>
          <select class="fi" id="fW"><option value="">— Select —</option></select>
        </div>
        <div class="fgrp">
          <label class="lbl">Round</label>
          <input class="fi" type="text" id="fR" placeholder="e.g. Quarter Finals">
        </div>
      </div>

      <!-- Main save button -->
      <div class="fa" style="margin-bottom:0;padding-bottom:0;border-bottom:none">
        <button class="btn" style="background:var(--mid);color:var(--muted)" onclick="closeOv('ovForm')">Cancel</button>
        <button class="btn btn-primary" id="btnSave" onclick="saveMatch()">Save Match</button>
      </div>

      <!-- ── Player Details sub-section (visible only on edit or after first save) ── -->
      <div id="pSection" style="display:none">
        <div class="divider">
          <div class="divider-line"></div>
          <div class="divider-txt">&#9876; Player Details (5 per team)</div>
          <div class="divider-line"></div>
        </div>
        <p style="font-size:.76rem;color:var(--muted);margin-bottom:12px">
          Upload each player's hero image, enter their IGN and K&nbsp;/&nbsp;D&nbsp;/&nbsp;A.
        </p>

        <!-- Tabs -->
        <div class="ptabs">
          <button class="ptab on-a" id="ptA" onclick="swTab('A')">Team A</button>
          <button class="ptab"       id="ptB" onclick="swTab('B')">Team B</button>
        </div>

        <!-- Team A panel -->
        <div class="ppanel vis" id="ppA">
          <div class="pchdr">
            <span>Hero</span><span style="text-align:left">IGN</span>
            <span>K</span><span>D</span><span>A</span>
          </div>
          <div id="pgA"></div>
        </div>

        <!-- Team B panel -->
        <div class="ppanel" id="ppB">
          <div class="pchdr">
            <span>Hero</span><span style="text-align:left">IGN</span>
            <span>K</span><span>D</span><span>A</span>
          </div>
          <div id="pgB"></div>
        </div>

        <div class="fa">
          <button class="btn btn-primary" id="btnSavePl" onclick="savePlayers()">&#128190; Save Player Details</button>
        </div>
      </div>

    </div><!-- /.mb -->
  </div>
</div>


<!-- ═══════════════════════════════════════════════════
     DELETE CONFIRM MODAL
════════════════════════════════════════════════════ -->
<div class="ov" id="ovDel" onclick="ovc(event,'ovDel')">
  <div class="modal cm">
    <div class="mh">
      <span class="mt">Delete Match</span>
      <button class="mc" onclick="closeOv('ovDel')">&#x2715;</button>
    </div>
    <div class="mb" style="text-align:center">
      <div style="font-size:2.2rem;margin-bottom:8px">&#9888;&#65039;</div>
      <p class="ct">Delete <strong id="delLbl"></strong>?<br>This cannot be undone.</p>
      <div class="fa" style="justify-content:center;margin-top:16px">
        <button class="btn" style="background:var(--mid);color:var(--muted)" onclick="closeOv('ovDel')">Cancel</button>
        <button class="btn btn-del" id="btnDel">Delete</button>
      </div>
    </div>
  </div>
</div>

<div id="toast"></div>


<!-- ═══════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════ -->
<script>
'use strict';

/* ── State ── */
var gEditId   = null;
var gDelId    = null;

/* ── Boot ── */
document.addEventListener('DOMContentLoaded', function () {
  loadRounds();
  loadMatches();

  document.getElementById('q').addEventListener('input', debounce(loadMatches, 300));
  document.getElementById('rf').addEventListener('change', loadMatches);
  document.getElementById('fA').addEventListener('input', syncW);
  document.getElementById('fB').addEventListener('input', syncW);
  document.getElementById('btnDel').addEventListener('click', doDelete);

  /* Logo file inputs */
  document.getElementById('ufA').addEventListener('change', function () { previewLogo(this, 'upA', 'uzA', 'ulA'); });
  document.getElementById('ufB').addEventListener('change', function () { previewLogo(this, 'upB', 'uzB', 'ulB'); });
});

/* ════════════════════════════════════════════
   API
════════════════════════════════════════════ */
async function api(url, opts) {
  try {
    var r   = await fetch(url, opts || {});
    var txt = await r.text();
    return JSON.parse(txt);
  } catch (e) {
    return { error: 'Network/parse error' };
  }
}

/* ════════════════════════════════════════════
   LOAD ROUNDS (filter dropdown)
════════════════════════════════════════════ */
async function loadRounds() {
  var d   = await api('api.php?action=rounds');
  var sel = document.getElementById('rf');
  sel.innerHTML = '<option value="">All Rounds</option>';
  (d.data || []).forEach(function (r) {
    var o = document.createElement('option');
    o.value = o.textContent = r;
    sel.appendChild(o);
  });
}

/* ════════════════════════════════════════════
   LOAD & RENDER MATCH TABLE
════════════════════════════════════════════ */
async function loadMatches() {
  var search = document.getElementById('q').value.trim();
  var round  = document.getElementById('rf').value;
  var d = await api('api.php?action=list&' + new URLSearchParams({ search: search, round: round }));
  var rows = Array.isArray(d.data) ? d.data : [];
  renderStats(rows);
  renderTable(rows);
}

function renderStats(rows) {
  document.getElementById('sTotal').textContent  = rows.length;
  var rds = {}, tms = {};
  rows.forEach(function (r) { rds[r.round] = 1; tms[r.team_a] = 1; tms[r.team_b] = 1; });
  document.getElementById('sRounds').textContent = Object.keys(rds).length;
  document.getElementById('sTeams').textContent  = Object.keys(tms).length;
}

function renderTable(rows) {
  var tb = document.getElementById('tbl');
  if (!rows.length) {
    tb.innerHTML = '<tr><td colspan="8"><div class="empty-row"><div class="ei">&#127942;</div>No matches found.</div></td></tr>';
    return;
  }
  tb.innerHTML = rows.map(function (m, i) {
    var avA  = m.team_a_img ? '<img class="av" src="uploads/' + xe(m.team_a_img) + '" alt="">' : '<div class="av-ph">' + ini(m.team_a) + '</div>';
    var avB  = m.team_b_img ? '<img class="av" src="uploads/' + xe(m.team_b_img) + '" alt="">' : '<div class="av-ph">' + ini(m.team_b) + '</div>';
    var wico = (m.winner === m.team_a && m.team_a_img) ? '<img src="uploads/' + xe(m.team_a_img) + '" alt="">'
             : (m.winner === m.team_b && m.team_b_img) ? '<img src="uploads/' + xe(m.team_b_img) + '" alt="">'
             : '&#127942;';
    /* safe label for onclick string attribute */
    var safeLabel = (xe(m.team_a) + ' vs ' + xe(m.team_b)).replace(/'/g, '&#39;');
    return '<tr>'
      + '<td style="color:var(--muted);font-size:.76rem">#' + (i + 1) + '</td>'
      + '<td><div class="tc">' + avA + '<span>' + xe(m.team_a) + '</span></div></td>'
      + '<td><span style="color:var(--muted);font-size:.74rem">VS</span></td>'
      + '<td><div class="tc">' + avB + '<span>' + xe(m.team_b) + '</span></div></td>'
      + '<td><div class="sc"><span class="sc-n">' + m.score_a + '</span><span class="sc-s">:</span><span class="sc-n">' + m.score_b + '</span></div></td>'
      + '<td><span class="wb" onclick="openDetail(' + m.id + ')" title="View scoreboard">' + wico + ' ' + xe(m.winner) + '</span></td>'
      + '<td><span class="rb">' + xe(m.round) + '</span></td>'
      + '<td style="white-space:nowrap">'
          + '<button class="btn btn-sm btn-view" onclick="openDetail(' + m.id + ')">&#128269;</button>'
          + '<button class="btn btn-sm btn-edit" onclick="openEdit(' + m.id + ')" style="margin-left:4px">&#9998; Edit</button>'
          + '<button class="btn btn-sm btn-del"  onclick="openDelete(' + m.id + ',\'' + safeLabel + '\')" style="margin-left:4px">&#128465;</button>'
      + '</td>'
      + '</tr>';
  }).join('');
}

/* ════════════════════════════════════════════
   DETAIL MODAL — scoreboard view
════════════════════════════════════════════ */
async function openDetail(id) {
  /* Show modal immediately with spinner */
  setDetailHeader(null);
  document.getElementById('dBody').innerHTML = '<div class="empty-row" style="padding:32px"><span class="spin"></span></div>';
  openOv('ovDetail');

  /* Fetch match + players in parallel */
  var results = await Promise.all([
    api('api.php?action=get&id=' + id),
    api('api.php?action=get_players&id=' + id)
  ]);
  var md = results[0];
  var pd = results[1];

  if (md.error) { toast(md.error, 'err'); closeOv('ovDetail'); return; }

  var m       = md.data;
  var players = Array.isArray(pd.data) ? pd.data : [];

  /* Populate banner */
  setDetailHeader(m);

  /* Score */
  var elSA = document.getElementById('dSA');
  var elSB = document.getElementById('dSB');
  elSA.textContent = m.score_a;
  elSB.textContent = m.score_b;
  elSA.className   = 'd-sv ' + (m.winner === m.team_a ? 'win' : 'lose');
  elSB.className   = 'd-sv ' + (m.winner === m.team_b ? 'win' : 'lose');
  document.getElementById('dWinner').textContent = m.winner;

  /* Build scoreboard */
  var pA   = players.filter(function (p) { return p.team_side === 'A'; });
  var pB   = players.filter(function (p) { return p.team_side === 'B'; });
  var html = buildSbSection(m.team_a, 'ta', pA)
           + buildSbSection(m.team_b, 'tb', pB);
  document.getElementById('dBody').innerHTML = html;
}

function setDetailHeader(m) {
  /* Team A logo */
  var imgA = document.getElementById('dLogoA');
  var phA  = document.getElementById('dLogoPHA');
  /* Team B logo */
  var imgB = document.getElementById('dLogoB');
  var phB  = document.getElementById('dLogoPHB');

  if (!m) {
    /* Reset to placeholder while loading */
    imgA.style.display = 'none'; phA.style.display = 'flex'; phA.textContent = '?';
    imgB.style.display = 'none'; phB.style.display = 'flex'; phB.textContent = '?';
    document.getElementById('dNameA').textContent = '—';
    document.getElementById('dNameB').textContent = '—';
    return;
  }

  document.getElementById('dNameA').textContent = m.team_a;
  document.getElementById('dNameB').textContent = m.team_b;

  if (m.team_a_img) {
    imgA.src = 'uploads/' + m.team_a_img;
    imgA.style.display = 'block'; phA.style.display = 'none';
  } else {
    imgA.style.display = 'none';
    phA.style.display  = 'flex';
    phA.textContent    = ini(m.team_a);
  }
  if (m.team_b_img) {
    imgB.src = 'uploads/' + m.team_b_img;
    imgB.style.display = 'block'; phB.style.display = 'none';
  } else {
    imgB.style.display = 'none';
    phB.style.display  = 'flex';
    phB.textContent    = ini(m.team_b);
  }
}

/* Build one team's scoreboard section — 3 cols: hero | IGN | KDA  (NO badges) */
function buildSbSection(teamName, cls, players) {
  /* Filter out completely empty slots */
  var filled = players.filter(function (p) { return p.ign || p.hero_img; });

  var rows = '';
  if (!filled.length) {
    rows = '<div class="sb-empty">No player data yet — use Edit to add details.</div>';
  } else {
    filled.forEach(function (p) {
      var hero = p.hero_img
        ? '<img class="sb-hero" src="uploads/' + xe(p.hero_img) + '" alt="">'
        : '<div class="sb-hero-ph">&#129535;</div>';
      rows += '<div class="sb-row">'
        + hero
        + '<div><div class="sb-ign">' + xe(p.ign || '—') + '</div></div>'
        + '<div><div class="sb-kda">' + (+p.kills) + '/' + (+p.deaths) + '/' + (+p.assists) + '</div>'
             + '<div class="sb-kl">K / D / A</div></div>'
        + '</div>';
    });
  }

  return '<div class="sb-sec">'
    + '<div class="sb-th ' + cls + '">' + xe(teamName) + '</div>'
    + '<div class="sb-cols"><span>Hero</span><span>Player IGN</span><span style="text-align:center">K / D / A</span></div>'
    + rows
    + '</div>';
}

/* ════════════════════════════════════════════
   ADD / EDIT MODAL
════════════════════════════════════════════ */
function openCreate() {
  gEditId = null;
  document.getElementById('fmTitle').textContent = 'Add Match';
  document.getElementById('fA').value  = '';
  document.getElementById('fB').value  = '';
  document.getElementById('fSA').value = '0';
  document.getElementById('fSB').value = '0';
  document.getElementById('fR').value  = '';
  resetLogo('ufA', 'upA', 'uzA', 'ulA');
  resetLogo('ufB', 'upB', 'uzB', 'ulB');
  syncW();
  document.getElementById('pSection').style.display = 'none';
  openOv('ovForm');
}

async function openEdit(id) {
  var d = await api('api.php?action=get&id=' + id);
  if (d.error) { toast(d.error, 'err'); return; }
  var m = d.data;
  gEditId = +m.id;

  document.getElementById('fmTitle').textContent = 'Edit Match';
  document.getElementById('fA').value  = m.team_a;
  document.getElementById('fB').value  = m.team_b;
  document.getElementById('fSA').value = m.score_a;
  document.getElementById('fSB').value = m.score_b;
  document.getElementById('fR').value  = m.round;

  resetLogo('ufA', 'upA', 'uzA', 'ulA');
  resetLogo('ufB', 'upB', 'uzB', 'ulB');
  if (m.team_a_img) setLogoPreview('upA', 'uzA', 'ulA', 'uploads/' + m.team_a_img);
  if (m.team_b_img) setLogoPreview('upB', 'uzB', 'ulB', 'uploads/' + m.team_b_img);

  syncW(m.winner);

  /* Show player section */
  document.getElementById('pSection').style.display = 'block';
  openOv('ovForm');

  /* Load player data */
  var pd = await api('api.php?action=get_players&id=' + gEditId);
  renderPlayerEditor(pd.data || [], m.team_a, m.team_b);
}

/* ── Save match (create or update) ── */
async function saveMatch() {
  var tA = document.getElementById('fA').value.trim();
  var tB = document.getElementById('fB').value.trim();
  var sA = document.getElementById('fSA').value;
  var sB = document.getElementById('fSB').value;
  var w  = document.getElementById('fW').value;
  var r  = document.getElementById('fR').value.trim();

  if (!tA || !tB || !w || !r) { toast('Please fill in all required fields.', 'err'); return; }

  var btn = document.getElementById('btnSave');
  btn.innerHTML = '<span class="spin"></span> Saving…'; btn.disabled = true;

  var fd = new FormData();
  if (gEditId) fd.append('id', gEditId);
  fd.append('team_a', tA); fd.append('team_b', tB);
  fd.append('score_a', sA); fd.append('score_b', sB);
  fd.append('winner', w); fd.append('round', r);

  var ufA = document.getElementById('ufA'), ufB = document.getElementById('ufB');
  if (ufA.files && ufA.files.length) fd.append('team_a_img', ufA.files[0]);
  if (ufB.files && ufB.files.length) fd.append('team_b_img', ufB.files[0]);

  var action = gEditId ? 'update' : 'create';
  var d = await api('api.php?action=' + action, { method: 'POST', body: fd });

  btn.innerHTML = 'Save Match'; btn.disabled = false;
  if (d.error) { toast(d.error, 'err'); return; }

  if (!gEditId && d.id) {
    /* New match just created — show player section for immediate editing */
    gEditId = +d.id;
    document.getElementById('pSection').style.display = 'block';
    var pd = await api('api.php?action=get_players&id=' + gEditId);
    renderPlayerEditor(pd.data || [], tA, tB);
    toast('Match saved! Scroll down to add player details.', 'ok');
  } else {
    toast('Match updated!', 'ok');
    loadMatches(); loadRounds();
  }
}

/* ════════════════════════════════════════════
   PLAYER EDITOR
════════════════════════════════════════════ */
function renderPlayerEditor(players, nameA, nameB) {
  document.getElementById('ptA').textContent = (nameA || 'Team A');
  document.getElementById('ptB').textContent = (nameB || 'Team B');

  /* Build lookup by side_slot */
  var map = {};
  players.forEach(function (p) { map[p.team_side + '_' + p.slot] = p; });

  ['A', 'B'].forEach(function (side) {
    var box  = document.getElementById('pg' + side);
    var html = '';
    for (var slot = 1; slot <= 5; slot++) {
      var k = side + '_' + slot;
      var p = map[k] || { ign: '', kills: 0, deaths: 0, assists: 0, hero_img: null };

      var hasImg  = p.hero_img ? ' got' : '';
      var imgHtml = p.hero_img
        ? '<img src="uploads/' + xe(p.hero_img) + '" alt="" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">'
        : '';
      var lblHtml = p.hero_img ? '' : '<span class="hz-lbl">Hero<br>Photo</span>';

      html += '<div class="prow">'
        /* Hero photo zone */
        + '<div class="hz' + hasImg + '" id="hz_' + k + '" onclick="document.getElementById(\'hf_' + k + '\').click()">'
            + imgHtml + lblHtml
          + '</div>'
        + '<input type="file" id="hf_' + k + '" accept="image/*" style="display:none">'
        /* IGN */
        + '<input class="fi" type="text" id="pi_' + k + '" placeholder="Player IGN" value="' + xe(p.ign || '') + '">'
        /* K / D / A */
        + '<input class="fi kda-in" type="number" id="pk_' + k + '" min="0" value="' + (parseInt(p.kills)  || 0) + '" title="Kills">'
        + '<input class="fi kda-in" type="number" id="pd_' + k + '" min="0" value="' + (parseInt(p.deaths) || 0) + '" title="Deaths">'
        + '<input class="fi kda-in" type="number" id="pa_' + k + '" min="0" value="' + (parseInt(p.assists)|| 0) + '" title="Assists">'
        + '</div>';
    }
    box.innerHTML = html;

    /* Attach file listeners after injecting HTML */
    for (var s = 1; s <= 5; s++) {
      (function (kk) {
        var fi = document.getElementById('hf_' + kk);
        if (fi) fi.addEventListener('change', function () { heroPreview(this, kk); });
      })(side + '_' + s);
    }
  });

  swTab('A');
}

function heroPreview(input, k) {
  var file = input.files[0];
  if (!file) return;
  var reader = new FileReader();
  reader.onload = function (e) {
    var zone = document.getElementById('hz_' + k);
    zone.classList.add('got');
    zone.innerHTML = '<img src="' + e.target.result + '" alt="" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">';
  };
  reader.readAsDataURL(file);
}

function swTab(side) {
  document.getElementById('ptA').className = 'ptab' + (side === 'A' ? ' on-a' : '');
  document.getElementById('ptB').className = 'ptab' + (side === 'B' ? ' on-b' : '');
  document.getElementById('ppA').className = 'ppanel' + (side === 'A' ? ' vis' : '');
  document.getElementById('ppB').className = 'ppanel' + (side === 'B' ? ' vis' : '');
}

/* ── Save Players ── */
async function savePlayers() {
  if (!gEditId) { toast('Save the match first.', 'err'); return; }

  var btn = document.getElementById('btnSavePl');
  btn.innerHTML = '<span class="spin"></span> Saving…'; btn.disabled = true;

  var fd = new FormData();
  fd.append('match_id', gEditId);

  ['A', 'B'].forEach(function (side) {
    for (var slot = 1; slot <= 5; slot++) {
      var k = side + '_' + slot;
      var ign = document.getElementById('pi_' + k);
      var kl  = document.getElementById('pk_' + k);
      var dl  = document.getElementById('pd_' + k);
      var al  = document.getElementById('pa_' + k);
      var fi  = document.getElementById('hf_' + k);

      if (!ign) continue; /* safety check if player section not rendered */

      fd.append('ign['     + k + ']', ign.value.trim());
      fd.append('kills['   + k + ']', kl.value  || '0');
      fd.append('deaths['  + k + ']', dl.value  || '0');
      fd.append('assists[' + k + ']', al.value  || '0');
      fd.append('badge['   + k + ']', 'none'); /* badge removed from UI — always send none */
      if (fi && fi.files && fi.files.length) fd.append('hero_' + k, fi.files[0]);
    }
  });

  var d = await api('api.php?action=save_players', { method: 'POST', body: fd });
  btn.innerHTML = '&#128190; Save Player Details'; btn.disabled = false;

  if (d.error) { toast(d.error, 'err'); return; }
  toast('Player details saved!', 'ok');
}

/* ════════════════════════════════════════════
   DELETE
════════════════════════════════════════════ */
function openDelete(id, label) {
  gDelId = +id;
  document.getElementById('delLbl').textContent = label;
  openOv('ovDel');
}

async function doDelete() {
  if (!gDelId) return;
  var fd = new FormData(); fd.append('id', gDelId);
  var d = await api('api.php?action=delete', { method: 'POST', body: fd });
  closeOv('ovDel');
  if (d.error) { toast(d.error, 'err'); return; }
  toast('Match deleted.', 'ok');
  gDelId = null;
  loadMatches(); loadRounds();
}

/* ════════════════════════════════════════════
   WINNER DROPDOWN SYNC
════════════════════════════════════════════ */
function syncW(sel) {
  var a   = document.getElementById('fA').value.trim() || 'Team A';
  var b   = document.getElementById('fB').value.trim() || 'Team B';
  var el  = document.getElementById('fW');
  var cur = (sel !== undefined) ? sel : el.value;
  el.innerHTML = '<option value="">— Select Winner —</option>'
    + '<option value="' + xe(a) + '"' + (cur === a ? ' selected' : '') + '>' + xe(a) + '</option>'
    + '<option value="' + xe(b) + '"' + (cur === b ? ' selected' : '') + '>' + xe(b) + '</option>';
}

/* ════════════════════════════════════════════
   LOGO UPLOAD HELPERS
════════════════════════════════════════════ */
function previewLogo(input, prevId, zoneId, lblId) {
  var file = input.files[0];
  if (!file) return;
  var rd = new FileReader();
  rd.onload = function (e) {
    var img = document.getElementById(prevId);
    img.src = e.target.result;
    document.getElementById(zoneId).classList.add('got');
    document.getElementById(lblId).textContent = file.name;
  };
  rd.readAsDataURL(file);
}

function setLogoPreview(prevId, zoneId, lblId, src) {
  var img = document.getElementById(prevId);
  img.src = src;
  document.getElementById(zoneId).classList.add('got');
  document.getElementById(lblId).textContent = 'Current logo (click to change)';
}

/* Clone trick — most reliable way to reset a file input cross-browser */
function resetLogo(fileId, prevId, zoneId, lblId) {
  var old = document.getElementById(fileId);
  var neo = old.cloneNode(false);
  neo.addEventListener('change', function () { previewLogo(this, prevId, zoneId, lblId); });
  old.parentNode.replaceChild(neo, old);
  var img = document.getElementById(prevId);
  img.src = '';
  document.getElementById(zoneId).classList.remove('got');
  document.getElementById(lblId).textContent = '\uD83D\uDCC1 Click to upload';
}

/* ════════════════════════════════════════════
   MODAL HELPERS
════════════════════════════════════════════ */
function openOv(id)   { document.getElementById(id).classList.add('open'); }
function closeOv(id)  { document.getElementById(id).classList.remove('open'); }
function ovc(e, id)   { if (e.target === document.getElementById(id)) closeOv(id); }

/* ════════════════════════════════════════════
   TOAST
════════════════════════════════════════════ */
function toast(msg, type) {
  var t = document.getElementById('toast');
  t.textContent = msg;
  t.className   = 'show ' + (type || 'ok');
  clearTimeout(t._t);
  t._t = setTimeout(function () { t.className = ''; }, 3200);
}

/* ════════════════════════════════════════════
   UTILS
════════════════════════════════════════════ */
function xe(s) {
  if (s == null) return '';
  return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}
function ini(n) {
  return ((n || '?') + '').split(' ').map(function (w) { return w[0] || ''; }).join('').toUpperCase().slice(0, 2) || '?';
}
function debounce(fn, ms) {
  var t;
  return function () {
    var a = arguments;
    clearTimeout(t);
    t = setTimeout(function () { fn.apply(null, a); }, ms);
  };
}
</script>
</body>
</html>
