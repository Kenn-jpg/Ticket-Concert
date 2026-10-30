<x-layouts.event :title="$registration->isPaid() ? 'Pembayaran Berhasil' : 'Pembayaran'" :status="$registration->isPaid() ? 'Payment received' : 'Awaiting payment'">
    <main class="layout">
        <section class="intro" aria-labelledby="event-title">
            @if ($registration->isPaid())
                <div class="eyebrow">Pembayaran berhasil</div>
                <h1 id="event-title">Sampai<br>jumpa!</h1>
                <p class="lead">Terima kasih, {{ $registration->name }}. Pembayaranmu sudah kami terima dan e-ticket sudah dikirim ke <strong>{{ $registration->email }}</strong>. Belum masuk? Coba cek folder Spam.</p>
            @else
                <div class="eyebrow">Menunggu pembayaran</div>
                <h1 id="event-title">Satu langkah lagi</h1>
                <p class="lead">Hai {{ $registration->name }}, selesaikan pembayaran untuk mengamankan tiketmu. Setelah lunas, e-ticket langsung dikirim ke <strong>{{ $registration->email }}</strong>.</p>
            @endif
            <div class="event-meta">
                <div><span>Kode pesanan</span><span>{{ $registration->code }}</span></div>
                <div><span>Tanggal</span><span>{{ $eventDate->translatedFormat('l, j F Y') }}</span></div>
                <div><span>Lokasi</span><span>Jiexpo Kemayoran, Jakarta</span></div>
                <div><span>Pintu dibuka</span><span>18.00 WIB</span></div>
            </div>
        </section>

        <section class="form-card" aria-labelledby="payment-title">
            <div class="form-heading">
                <h2 id="payment-title">{{ $registration->isPaid() ? 'Pembayaran diterima' : 'Selesaikan pembayaran' }}</h2>
                <span class="step">02 / 02</span>
            </div>

            <div class="order-lines">
                <div>
                    <span>Status</span>
                    <span>
                        @if ($registration->isPaid())
                            <span class="badge paid">Lunas</span>
                        @else
                            <span class="badge pending">Menunggu pembayaran</span>
                        @endif
                    </span>
                </div>
                <div><span>Nama</span><span>{{ $registration->name }}</span></div>
                <div><span>Tiket</span><span>{{ $registration->quantity }} × {{ $registration->ticket_label }}</span></div>
                <div><span>Metode pembayaran</span><span>{{ $registration->payment_label }}</span></div>
                @if ($registration->isPaid())
                    <div><span>Dibayar pada</span><span>{{ $registration->paid_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y, H.i') }} WIB</span></div>
                @endif
            </div>

            <div class="summary"><span>Total pembayaran</span><strong>{{ $registration->formatted_total_price }}</strong></div>

            @if ($registration->isPaid())
                <div class="notice" role="status">Tunjukkan e-ticket di email beserta kode <strong>{{ $registration->code }}</strong> dan identitas yang sesuai saat menukarkan tiket di pintu masuk.</div>
                <a class="button secondary" href="{{ route('home') }}">Kembali ke beranda</a>
            @else
                <div class="pay-box">
                    @if ($registration->payment_method === 'qris')
                        <p class="pay-label">Scan QRIS</p>
                        @php($qrSeed = crc32($registration->code))
                        <svg class="qr" viewBox="0 0 25 25" shape-rendering="crispEdges" role="img" aria-label="Kode QR simulasi">
                            <rect width="25" height="25" fill="#fff"/>
                            @foreach ([[0, 0], [18, 0], [0, 18]] as [$finderX, $finderY])
                                <rect x="{{ $finderX }}" y="{{ $finderY }}" width="7" height="7" fill="#17211b"/>
                                <rect x="{{ $finderX + 1 }}" y="{{ $finderY + 1 }}" width="5" height="5" fill="#fff"/>
                                <rect x="{{ $finderX + 2 }}" y="{{ $finderY + 2 }}" width="3" height="3" fill="#17211b"/>
                            @endforeach
                            @for ($row = 0; $row < 25; $row++)
                                @for ($column = 0; $column < 25; $column++)
                                    @continue(($row < 8 && $column < 8) || ($row < 8 && $column > 16) || ($row > 16 && $column < 8))
                                    @if (crc32($qrSeed.'-'.$row.'-'.$column) % 2 === 0)
                                        <rect x="{{ $column }}" y="{{ $row }}" width="1" height="1" fill="#17211b"/>
                                    @endif
                                @endfor
                            @endfor
                        </svg>
                        <p class="pay-help">Scan kode di atas dengan aplikasi m-banking atau e-wallet apa pun.</p>
                    @elseif ($registration->payment_method === 'bank')
                        <p class="pay-label">Nomor Virtual Account</p>
                        <p class="pay-code">{{ $registration->payment_code }}</p>
                        <p class="pay-help">Transfer lewat ATM, m-banking, atau internet banking ke nomor di atas sesuai total pembayaran.</p>
                    @else
                        <p class="pay-label">Kode pembayaran e-wallet</p>
                        <p class="pay-code">{{ $registration->payment_code }}</p>
                        <p class="pay-help">Buka aplikasi e-wallet, pilih menu Bayar, lalu masukkan kode di atas.</p>
                    @endif
                </div>

                <p class="simulation">Mode simulasi: tidak ada dana yang ditarik. Klik tombol di bawah untuk menandai pesanan sebagai lunas.</p>

                <form method="POST" action="{{ URL::signedRoute('registrations.payment.store', $registration) }}">
                    @csrf
                    <button type="submit">Saya sudah bayar</button>
                </form>
            @endif
        </section>
    </main>
</x-layouts.event>
