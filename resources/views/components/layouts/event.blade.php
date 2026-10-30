@props(['title', 'status' => 'Registration is open'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Midnight Echoes</title>
    <style>
        :root { --ink:#17211b; --muted:#66736b; --paper:#f5f2eb; --card:#fffdf8; --line:#d9ddd5; --green:#1f5b47; --lime:#d8f36b; --orange:#ed724a; }
        * { box-sizing: border-box; }
        body { margin:0; color:var(--ink); background:var(--paper); font-family:Georgia, 'Times New Roman', serif; }
        .page { min-height:100vh; padding:28px 6vw 64px; background:radial-gradient(circle at 88% 4%, #e4edc8 0, transparent 28%), var(--paper); }
        .topbar, .layout, .footer { width:min(1180px, 100%); margin:0 auto; }
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:66px; font:13px Arial, sans-serif; letter-spacing:.12em; text-transform:uppercase; }
        .brand { font-weight:bold; } .status { color:var(--green); }
        .layout { display:grid; grid-template-columns:minmax(260px,.8fr) minmax(420px,1.2fr); gap:clamp(34px,8vw,110px); align-items:start; }
        .intro { padding-top:12px; }
        .eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:22px; color:var(--orange); font:700 12px/1.2 Arial, sans-serif; letter-spacing:.16em; text-transform:uppercase; }
        .eyebrow:before { width:26px; height:2px; background:var(--orange); content:''; }
        h1 { max-width:520px; margin:0 0 22px; font-size:clamp(50px,7vw,92px); line-height:.88; letter-spacing:-.06em; font-weight:500; }
        .lead { max-width:390px; margin:0 0 38px; color:var(--muted); font:16px/1.65 Arial, sans-serif; }
        .event-meta { display:grid; gap:14px; max-width:390px; border-top:1px solid var(--line); padding-top:20px; font:13px/1.5 Arial, sans-serif; }
        .event-meta div { display:flex; justify-content:space-between; gap:20px; } .event-meta span:first-child { color:var(--muted); } .event-meta span:last-child { text-align:right; font-weight:bold; }
        .form-card { padding:clamp(24px,4vw,46px); background:var(--card); border:1px solid var(--line); box-shadow:18px 18px 0 var(--lime); }
        .form-heading { display:flex; justify-content:space-between; align-items:baseline; gap:20px; margin-bottom:30px; border-bottom:1px solid var(--line); padding-bottom:18px; }
        h2 { margin:0; font-size:27px; font-weight:500; } .step { color:var(--muted); font:12px Arial, sans-serif; letter-spacing:.08em; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px 16px; } .field { display:grid; gap:8px; } .field.full { grid-column:1 / -1; }
        label { font:700 12px Arial, sans-serif; letter-spacing:.04em; }
        input, select { width:100%; min-height:48px; border:1px solid var(--line); border-radius:0; padding:0 13px; color:var(--ink); background:#fff; font:15px Arial, sans-serif; }
        select { height:48px; padding-right:40px; cursor:pointer; -webkit-appearance:none; appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1.5l5 5 5-5' fill='none' stroke='%2317211b' stroke-width='1.6'/%3E%3C/svg%3E") no-repeat right 15px center; }
        input:focus, select:focus { outline:2px solid var(--green); outline-offset:2px; }
        .summary { display:flex; justify-content:space-between; align-items:center; margin-top:30px; border-top:1px solid var(--line); padding-top:22px; font:13px Arial, sans-serif; }
        .summary span { color:var(--muted); } .summary strong { color:var(--green); font-size:24px; }
        .terms { display:flex; align-items:flex-start; gap:10px; margin:22px 0; color:var(--muted); font:12px/1.5 Arial, sans-serif; }
        .terms input { width:16px; min-height:16px; margin-top:1px; accent-color:var(--green); }
        button { width:100%; min-height:54px; border:0; cursor:pointer; color:#fff; background:var(--green); font:700 13px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; transition:background .2s, transform .2s; }
        button:hover:not(:disabled) { background:#153f32; transform:translateY(-2px); }
        button:disabled { cursor:not-allowed; color:#8a938d; background:#d9ddd5; }
        .error { color:var(--orange); font:12px Arial, sans-serif; }
        .errors { margin-bottom:22px; border-left:3px solid var(--orange); padding:12px 14px; color:var(--orange); background:#fbeee7; font:13px/1.5 Arial, sans-serif; }
        .footer { margin-top:72px; color:var(--muted); font:11px Arial, sans-serif; letter-spacing:.08em; text-transform:uppercase; }
        a.brand { color:inherit; text-decoration:none; }
        .button { display:flex; align-items:center; justify-content:center; width:100%; min-height:54px; color:#fff; background:var(--green); font:700 13px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; text-decoration:none; transition:background .2s, transform .2s; }
        .button:hover { background:#153f32; transform:translateY(-2px); }
        .button.secondary { color:var(--green); background:transparent; border:1px solid var(--green); }
        .button.secondary:hover { background:#eef3e6; }
        .notice { margin:22px 0; border-left:3px solid var(--orange); padding:12px 14px; color:var(--green); background:#f8f2df; font:13px/1.6 Arial, sans-serif; }
        .badge { display:inline-block; padding:5px 9px; font:700 11px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; }
        .badge.pending { color:#b4522f; background:#fbeee7; } .badge.paid { color:var(--green); background:#e6f2c4; }
        .order-lines { display:grid; gap:14px; font:14px/1.5 Arial, sans-serif; }
        .order-lines div { display:flex; justify-content:space-between; align-items:center; gap:20px; } .order-lines span:first-child { color:var(--muted); } .order-lines span:last-child { text-align:right; font-weight:bold; }
        .pay-box { margin-top:30px; border:1px dashed #b9c0b6; padding:26px 22px; text-align:center; background:#fff; }
        .pay-label { margin:0 0 14px; color:var(--muted); font:700 11px Arial, sans-serif; letter-spacing:.14em; text-transform:uppercase; }
        .pay-code { margin:0; color:var(--ink); font:600 clamp(20px,3vw,26px) 'Courier New', monospace; letter-spacing:.06em; }
        .pay-help { margin:14px 0 0; color:var(--muted); font:13px/1.6 Arial, sans-serif; }
        .qr { display:block; width:176px; height:176px; margin:0 auto; }
        .simulation { margin:16px 0 22px; color:var(--muted); font:12px/1.5 Arial, sans-serif; text-align:center; }
    </style>
</head>
<body>
    <div class="page">
        <header class="topbar"><a class="brand" href="{{ route('home') }}">ME / 26</a><div class="status">{{ $status }}</div></header>
        {{ $slot }}
        <footer class="footer">Midnight Echoes / Make the night count</footer>
    </div>
    {{ $scripts ?? '' }}
</body>
</html>
