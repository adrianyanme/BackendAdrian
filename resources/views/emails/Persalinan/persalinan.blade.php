<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            background-color: #000000;
            color: #ffffff;
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px 0;
        }
        .content h1 {
            color: #333;
        }
        .content p {
            color: #666;
        }
        .content a {
            color: #0066cc;
            text-decoration: none;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background-color: #333;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Retention</h1>
        </div>
        <div class="content">
            <h1>Permintaanmu Telah Kami Terima!</h1>
            <p>Hi {{$namapemohon}},</p>
            <p>Permintaan dokumen <strong>Salinan Jaksa</strong></p>
            <p><strong>Dokumen {{$noperkara}}</strong> akan di kirim dalam waktu 3 hari kerja sesuai email kamu, pastikan mengecek email secara berkala.</p>
            <p>Terima kasih telah menghubungi kami, jika ada pertanyaan lebih lanjut atau dokumen yang di minta tidak di kirim dalam 3 hari kerja, kamu bisa kontak kami di email <a href="mailto:contact@adrianyan.me">contact@adrianyan.me</a>.</p>
            <p>Adrian Arifin,<br>Team Retention</p>
          </div>
        <div class="footer">
            &copy; 2024 Retention, All Rights Reserved.
        </div>
    </div>
</body>
</html>
