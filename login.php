<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h1>Bengkel Bowo Motor</h1>
            <p>Kami menyediakan layanan terbaik bagi Anda dengan kepuasan 1000%</p>
        </div>
        <div class="right-side">
            <div class="login">
                <h1>Hello!</h1>
                <p>Welcome back</p>
                <form action="home.php" method="POST">
                       <input type="text" placeholder="Email">
                       <input type="password" placeholder="Password">
                       <button action="home.php" class="btn">Login</button>
                </form>
                <a href="index.php" class="forgot-password">Lupa kata sandi</a>
            </div>
        </div>
    </div>
</body>
</html>
