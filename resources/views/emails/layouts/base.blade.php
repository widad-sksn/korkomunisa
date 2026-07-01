<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IMM KORKOM UNISA')</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background-color: #F8FAFC; margin: 0; padding: 0; color: #1F2937; }
        .wrapper { width: 100%; background-color: #F8FAFC; padding-top: 40px; padding-bottom: 60px; }
        .main { background-color: #FFFFFF; margin: 0 auto; width: 100%; max-width: 600px; border: 1px solid #E5E7EB; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        .header { background-color: #A31245; padding: 30px 20px; text-align: center; }
        .header h1 { color: #FFFFFF; margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 0.5px; }
        .header p { color: #FCA5A5; margin: 5px 0 0 0; font-size: 13px; font-weight: normal; }
        .content { padding: 40px 30px; line-height: 1.6; font-size: 15px; }
        .content h2 { color: #111827; font-size: 20px; margin-top: 0; margin-bottom: 20px; }
        .content p { margin-top: 0; margin-bottom: 20px; }
        .footer { background-color: #F8FAFC; padding: 30px; text-align: center; font-size: 13px; color: #6B7280; border-top: 1px solid #E5E7EB; line-height: 1.5; }
        .footer a { color: #A31245; text-decoration: none; }
        @media only screen and (max-width: 600px) {
            .wrapper { padding-top: 0; padding-bottom: 0; }
            .main { border-radius: 0; border: none; }
            .content { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Header -->
            <tr>
                <td class="header">
                    <h1>IMM KORKOM UNISA</h1>
                    <p>Universitas 'Aisyiyah Yogyakarta</p>
                </td>
            </tr>
            
            <!-- Content -->
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            
            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p style="margin: 0 0 10px 0; font-weight: bold; color: #1F2937;">Portal IMM Korkom UNISA</p>
                    <p style="margin: 0 0 15px 0;"><a href="https://immkorkom.unisayogya.ac.id">https://immkorkom.unisayogya.ac.id</a></p>
                    <p style="margin: 0 0 5px 0; font-size: 12px;">Email ini dikirim secara otomatis oleh sistem.<br>Mohon tidak membalas email ini.</p>
                    <p style="margin: 15px 0 0 0; font-size: 12px;">&copy; {{ date('Y') }} IMM KORKOM UNISA</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
