<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 100px;
        }
        .content {
            text-align: center;
            padding: 20px 0;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #555555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ff007b;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            color: #999999;
            font-size: 12px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="blob:https://web.telegram.org/8d9d2f34-24fd-4e8c-b335-2b5feee726ac" alt="Logo">
        </div>
        <div class="content">
            <h1>Pos Bantuan Hukum!</h1>
            <p>Halo,{{ $namalengkap }}</p>
            <p>Laporan kamu sudah kami terima,Kami akan segera menghubungi kamu untuk lebih lanjut</p>
            <p>Have a question? <a href="mailto:support@yourdomain.com">Reach out to our team</a></p>
        </div>
        <div class="footer">
            <p>Contact</p>
            <p>Surabaya, Jawa Timur Indonesia</p>
            <p>&copy; {{ date('Y-m-d') }} Retention</p>
        </div>
    </div>
</body>
</html>
