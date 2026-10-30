<x-layouts.event title="Daftar Tiket">
    <main class="layout">
        <section class="intro" aria-labelledby="event-title">
            <div class="eyebrow">Live music experience</div>
            <h1 id="event-title">Midnight<br>Echoes</h1>
            <p class="lead">Satu malam, tiga panggung, dan suara yang akan tinggal lebih lama dari konsernya.</p>
            <div class="event-meta">
                <div><span>Tanggal</span><span>{{ $eventDate->locale('id')->translatedFormat('l, j F Y') }}</span></div>
                <div><span>Lokasi</span><span>Jiexpo Kemayoran, Jakarta</span></div>
                <div><span>Pintu dibuka</span><span>18.00 WIB</span></div>
            </div>
        </section>
        <section class="form-card" aria-labelledby="form-title">
            <div class="form-heading"><h2 id="form-title">Amankan tiketmu</h2><span class="step">01 / 02</span></div>
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
                <button type="submit" id="submit-button" @disabled(! old('agreement'))>Lanjut ke pembayaran</button>
            </form>
        </section>
    </main>

    <x-slot:scripts>
        <script>
            const ticket = document.getElementById('ticket');
            const quantity = document.getElementById('quantity');
            const total = document.getElementById('total');
            const agreement = document.getElementById('agreement');
            const submitButton = document.getElementById('submit-button');
            const formatRupiah = (value) => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(value);
            const updateTotal = () => {
                const price = Number(ticket.selectedOptions[0].dataset.price);
                const amount = Math.min(Math.max(Number(quantity.value) || 1, 1), 6);
                quantity.value = amount;
                total.textContent = formatRupiah(price * amount);
            };
            ticket.addEventListener('change', updateTotal);
            quantity.addEventListener('input', updateTotal);
            agreement.addEventListener('change', () => { submitButton.disabled = ! agreement.checked; });
            updateTotal();
        </script>
    </x-slot:scripts>
</x-layouts.event>
