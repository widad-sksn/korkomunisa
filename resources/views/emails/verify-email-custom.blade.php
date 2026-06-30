<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - IMM KORKOM UNISA</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #8A1538;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #1a1a1a;
            font-size: 20px;
            margin-top: 0;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .verify-button {
            background-color: #8A1538;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .verify-button:hover {
            background-color: #6d102c;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .trouble-link {
            font-size: 12px;
            color: #6b7280;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>IMM KORKOM UNISA</h1>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $user->name }}! 👋</h2>
            <p>Terima kasih telah mendaftar di portal IMM Korkom Universitas 'Aisyiyah Yogyakarta.</p>
            <p>Untuk menjaga keamanan akun Anda dan memastikan bahwa email ini benar milik Anda, silakan verifikasi alamat email Anda dengan mengeklik tombol di bawah ini:</p>
            
            <div class="button-container">
                <a href="{{ $url }}" class="verify-button">Verifikasi Email Saya</a>
            </div>
            
            <p>Jika Anda tidak pernah merasa mendaftar di sistem kami, Anda dapat mengabaikan dan menghapus email ini dengan aman.</p>
            
            <p style="margin-top: 30px; margin-bottom: 0;">
                Salam hangat,<br>
                <strong>Tim IT IMM Korkom UNISA</strong>
            </p>

            <div class="trouble-link">
                <p>Jika Anda mengalami masalah saat mengeklik tombol "Verifikasi Email Saya", salin dan tempel URL di bawah ini ke peramban (browser) Anda:</p>
                <a href="{{ $url }}" style="color: #8A1538;">{{ $url }}</a>
            </div>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} IMM KORKOM UNISA. | developed by widad-sksn
        </div>
    </div>
</body>
</html>
