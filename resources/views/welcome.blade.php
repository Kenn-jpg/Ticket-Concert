<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tiket | Midnight Echoes</title>
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
        input:focus, select:focus { outline:2px solid var(--green); outline-offset:2px; }
        .summary { display:flex; justify-content:space-between; align-items:center; margin-top:30px; border-top:1px solid var(--line); padding-top:22px; font:13px Arial, sans-serif; }
        .summary span { color:var(--muted); } .summary strong { color:var(--green); font-size:24px; }
        .terms { display:flex; align-items:flex-start; gap:10px; margin:22px 0; color:var(--muted); font:12px/1.5 Arial, sans-serif; }
        .terms input { width:16px; min-height:16px; margin-top:1px; accent-color:var(--green); }
        button { width:100%; min-height:54px; border:0; cursor:pointer; color:#fff; background:var(--green); font:700 13px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; transition:background .2s, transform .2s; }
        button:hover { background:#153f32; transform:translateY(-2px); }
        .success { display:none; margin-top:18px; border-left:3px solid var(--orange); padding:12px 14px; color:var(--green); background:#f8f2df; font:13px/1.5 Arial, sans-serif; }
        .success.show { display:block; }
        .error { color:var(--orange); font:12px Arial, sans-serif; }
        .errors { margin-bottom:22px; border-left:3px solid var(--orange); padding:12px 14px; color:var(--orange); background:#fbeee7; font:13px/1.5 Arial, sans-serif; } .footer { margin-top:72px; color:var(--muted); font:11px Arial, sans-serif; letter-spacing:.08em; text-transform:uppercase; }
        @media (max-width:760px) { .page { padding:22px 22px 48px; } .topbar { margin-bottom:48px; } .layout { display:block; } .intro { margin-bottom:50px; } h1 { font-size:clamp(54px,17vw,80px); } .form-card { box-shadow:10px 10px 0 var(--lime); } }
        @media (max-width:480px) { .form-grid { grid-template-columns:1fr; } .field.full { grid-column:auto; } .topbar { font-size:11px; } .status { display:none; } }
    </style>
</head>
<body>
    <div class="page">
        <header class="topbar"><div class="brand">ME / 26</div><div class="status">Registration is open</div></header>
        <main class="layout">
            <section class="intro" aria-labelledby="event-title">
                <div class="eyebrow">Live music experience</div>
                <h1 id="event-title">Midnight<br>Echoes</h1>
                <p class="lead">Satu malam, tiga panggung, dan suara yang akan tinggal lebih lama dari konsernya.</p>
                <div class="event-meta">
                    <div><span>Tanggal</span><span>Sabtu, 24 Oktober 2026</span></div>
                    <div><span>Lokasi</span><span>Jiexpo Kemayoran, Jakarta</span></div>
                    <div><span>Pintu dibuka</span><span>18.00 WIB</span></div>
                </div>
            </section>
            <section class="form-card" aria-labelledby="form-title">
                <div class="form-heading"><h2 id="form-title">Amankan tiketmu</h2><span class="step">01 / 01</span></div>
                <form id="ticket-form" method="POST" action="{{ route('registrations.store') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="errors" role="alert">Periksa kembali data yang kamu isi.</div>
                    @endif
                    <div class="form-grid">
                        <div class="field full"><label for="name">Nama lengkap</label><input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama sesuai identitas" required>@error('name')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label for="email">Alamat email</label><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="kamu@email.com" required>@error('email')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label for="phone">Nomor WhatsApp</label><input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>@error('phone')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label for="ticket">Jenis tiket</label><select id="ticket" name="ticket" required><option value="regular" data-price="350000" @selected(old('ticket') === 'regular')>Regular - Rp350.000</option><option value="premium" data-price="750000" @selected(old('ticket') === 'premium')>Premium - Rp750.000</option><option value="vip" data-price="1500000" @selected(old('ticket') === 'vip')>VIP - Rp1.500.000</option></select>@error('ticket')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label for="quantity">Jumlah tiket</label><input id="quantity" name="quantity" type="number" min="1" max="6" value="{{ old('quantity', 1) }}" required>@error('quantity')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field full"><label for="payment">Metode pembayaran</label><select id="payment" name="payment" required><option value="qris" @selected(old('payment') === 'qris')>QRIS</option><option value="bank" @selected(old('payment') === 'bank')>Transfer bank</option><option value="ewallet" @selected(old('payment') === 'ewallet')>E-wallet</option></select>@error('payment')<span class="error">{{ $message }}</span>@enderror</div>
                    </div>
                    <div class="summary"><span>Total pembayaran</span><strong id="total">Rp350.000</strong></div>
                    <label class="terms"><input type="checkbox" id="agreement" name="agreement" value="1" @checked(old('agreement')) required><span>Saya menyetujui syarat pembelian dan memastikan data yang diisi sudah benar.</span></label>
                    @error('agreement')<p class="error">{{ $message }}</p>@enderror
                    <button type="submit">Daftar dan lanjutkan pembayaran</button>
                    <div @class(['success', 'show' => session('success')]) id="success" role="status">{{ session('success') }}</div>
                </form>
            </section>
        </main>
        <footer class="footer">Midnight Echoes / Make the night count</footer>
    </div>
    <script>
        const ticket = document.getElementById('ticket');
        const quantity = document.getElementById('quantity');
        const total = document.getElementById('total');
        const formatRupiah = (value) => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(value);
        const updateTotal = () => {
            const price = Number(ticket.selectedOptions[0].dataset.price);
            const amount = Math.min(Math.max(Number(quantity.value) || 1, 1), 6);
            quantity.value = amount;
            total.textContent = formatRupiah(price * amount);
        };
        ticket.addEventListener('change', updateTotal);
        quantity.addEventListener('input', updateTotal);
        updateTotal();
    </script>
</body>
</html>
