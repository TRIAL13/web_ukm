<?php session_start(); ?> 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0057ff, #f9d400);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.20);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #0057ff;
        }

        label {
            float: left;
            margin: 8px 0 4px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #0057ff;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #f9d400;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0057ff;
            border: none;
            color: white;
            margin-top: 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #003db3;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login Admin</h2>

    <form action="login_proses.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>

    <div class="footer">© 2025 Sistem Pendaftaran</div>
</div>

</body>
</html>
