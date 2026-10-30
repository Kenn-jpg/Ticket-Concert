<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>E-ticket | Midnight Echoes</title>
    <style>
        @media (max-width: 620px) {
            .container { width: 100% !important; }
            .gutter { padding-left: 22px !important; padding-right: 22px !important; }
            .card { padding: 24px 20px !important; }
            .hero-title { font-size: 52px !important; }
            .total-amount { font-size: 22px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f5f2eb; color:#17211b; -webkit-text-size-adjust:100%;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:#f5f2eb;">
        Pembayaran diterima · Kode {{ $registration->code }} · {{ $registration->quantity }} tiket {{ $registration->ticket_label }} · {{ $registration->formatted_total_price }}
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f5f2eb;">
        <tr>
            <td align="center" style="padding:32px 12px 48px;">
                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px;">

                    {{-- Top bar --}}
                    <tr>
                        <td class="gutter" style="padding:0 32px 44px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font:bold 12px Arial, sans-serif; letter-spacing:.12em; text-transform:uppercase; color:#17211b;">ME / 26</td>
                                    <td align="right" style="font:12px Arial, sans-serif; letter-spacing:.12em; text-transform:uppercase; color:#1f5b47;">E-ticket</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Hero --}}
                    <tr>
                        <td class="gutter" style="padding:0 32px 36px;">
                            <p style="margin:0 0 18px; font:bold 12px/1.2 Arial, sans-serif; letter-spacing:.16em; text-transform:uppercase; color:#ed724a;">
                                <span style="display:inline-block; width:26px; height:2px; margin-right:8px; vertical-align:middle; background-color:#ed724a;"></span>Pembayaran berhasil
                            </p>
                            <h1 class="hero-title" style="margin:0 0 20px; font-family:Georgia, 'Times New Roman', serif; font-size:64px; font-weight:normal; line-height:.9; letter-spacing:-.05em; color:#17211b;">Midnight<br>Echoes</h1>
                            <p style="margin:0; font:16px/1.65 Arial, sans-serif; color:#66736b;">
                                Hai <strong style="color:#17211b;">{{ $registration->name }}</strong>, pembayaranmu sudah kami terima. Ini e-ticket kamu. Simpan baik-baik dan tunjukkan saat masuk ke venue.
                            </p>
                        </td>
                    </tr>

                    {{-- Registration card --}}
                    <tr>
                        <td class="gutter" style="padding:0 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fffdf8; border:1px solid #d9ddd5; box-shadow:12px 12px 0 #d8f36b;">
                                <tr>
                                    <td class="card" style="padding:32px 32px 28px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding-bottom:16px; border-bottom:1px solid #d9ddd5; font-family:Georgia, 'Times New Roman', serif; font-size:24px; color:#17211b;">E-ticket</td>
                                                <td align="right" style="padding-bottom:16px; border-bottom:1px solid #d9ddd5; font:12px Arial, sans-serif; letter-spacing:.08em; color:#66736b; white-space:nowrap;">{{ $registration->code }}</td>
                                            </tr>
                                        </table>

                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:8px; font:14px/1.5 Arial, sans-serif;">
                                            @foreach ([
                                                'Nama' => $registration->name,
                                                'Email' => $registration->email,
                                                'WhatsApp' => $registration->phone,
                                                'Jenis tiket' => $registration->ticket_label,
                                                'Jumlah tiket' => $registration->quantity.' tiket',
                                                'Metode pembayaran' => $registration->payment_label,
                                                'Dibayar pada' => $paidAt?->translatedFormat('j F Y, H.i').' WIB',
                                            ] as $label => $value)
                                                <tr>
                                                    <td style="padding:12px 16px 12px 0; border-bottom:1px solid #eceee8; color:#66736b; white-space:nowrap;">{{ $label }}</td>
                                                    <td align="right" style="padding:12px 0; border-bottom:1px solid #eceee8; font-weight:bold; color:#17211b; word-break:break-word;">{{ $value }}</td>
                                                </tr>
                                            @endforeach
                                        </table>

                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px; border-top:1px solid #d9ddd5;">
                                            <tr>
                                                <td style="padding-top:20px; font:13px Arial, sans-serif; color:#66736b;">Total dibayar <span style="display:inline-block; margin-left:6px; padding:3px 7px; font:bold 10px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; color:#1f5b47; background-color:#e6f2c4;">Lunas</span></td>
                                                <td class="total-amount" align="right" style="padding-top:20px; font:bold 26px Arial, sans-serif; color:#1f5b47; white-space:nowrap;">{{ $registration->formatted_total_price }}</td>
                                            </tr>
                                        </table>

                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:28px; border-top:2px dashed #d9ddd5;">
                                            <tr>
                                                <td align="center" style="padding-top:26px;">
                                                    <p style="margin:0 0 8px; font:bold 11px Arial, sans-serif; letter-spacing:.16em; text-transform:uppercase; color:#66736b;">Kode tiket</p>
                                                    <p style="margin:0; font:bold 30px 'Courier New', monospace; letter-spacing:.08em; color:#17211b;">{{ $registration->code }}</p>
                                                    <p style="margin:8px 0 0; font:12px Arial, sans-serif; color:#66736b;">Berlaku untuk {{ $registration->quantity }} orang · {{ $registration->ticket_label }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Event info --}}
                    <tr>
                        <td class="gutter" style="padding:48px 32px 0;">
                            <p style="margin:0 0 14px; font:bold 12px Arial, sans-serif; letter-spacing:.16em; text-transform:uppercase; color:#17211b;">Info acara</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:1px solid #d9ddd5; font:13px/1.5 Arial, sans-serif;">
                                @foreach ([
                                    'Tanggal' => $eventDate->translatedFormat('l, j F Y'),
                                    'Lokasi' => 'Jiexpo Kemayoran, Jakarta',
                                    'Pintu dibuka' => '18.00 WIB',
                                ] as $label => $value)
                                    <tr>
                                        <td style="padding:12px 16px 0 0; color:#66736b;">{{ $label }}</td>
                                        <td align="right" style="padding:12px 0 0; font-weight:bold; color:#17211b;">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    {{-- Note --}}
                    <tr>
                        <td class="gutter" style="padding:32px 32px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding:14px 16px; border-left:3px solid #ed724a; background-color:#f8f2df; font:13px/1.6 Arial, sans-serif; color:#1f5b47;">
                                        Tunjukkan email ini beserta kode <strong>{{ $registration->code }}</strong> dan identitas yang sesuai saat menukarkan tiket di pintu masuk. Datang lebih awal karena pintu dibuka pukul 18.00 WIB.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Call to action --}}
                    <tr>
                        <td class="gutter" style="padding:32px 32px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="background-color:#1f5b47;">
                                        <a href="{{ route('home') }}" style="display:block; padding:18px 24px; font:bold 13px Arial, sans-serif; letter-spacing:.1em; text-transform:uppercase; color:#ffffff; text-decoration:none;">Lihat halaman acara</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td class="gutter" style="padding:56px 32px 0;">
                            <p style="margin:0 0 10px; font:11px Arial, sans-serif; letter-spacing:.08em; text-transform:uppercase; color:#66736b;">Midnight Echoes / Make the night count</p>
                            <p style="margin:0; font:12px/1.6 Arial, sans-serif; color:#8a938d;">Email ini adalah bukti pembayaran untuk pesanan {{ $registration->code }}. Kamu menerima email ini karena alamat {{ $registration->email }} dipakai untuk membeli tiket Midnight Echoes.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
