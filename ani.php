<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awesome Entry Animation</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #007bff; /* Warna latar belakang biru saat hover */
        }

        .container {
            position: relative;
            width: 300px;
            height: 300px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); /* tambahkan bayangan untuk efek mendalam */
            animation: scaleIn 3s ease forwards;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.5);
                opacity: 1;
            }
            100% {
                transform: scale(1);
            }
        }

        .logo {
            width: 200px; /* ukuran logo yang lebih besar */
            height: 200px; /* ukuran logo yang lebih besar */
            background: url('./img/logobbm.png') no-repeat center;
            background-size: contain;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content {
            font-size: 24px;
            text-align: center;
            line-height: 300px; /* sesuaikan dengan tinggi kontainer */
            animation: fadeIn 3s ease 3s forwards;
            opacity: 0;
            color: #333; /* warna teks agar lebih kontras */
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        
    </div>

    <script>
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 6000);
    </script>
</body>
</html>
