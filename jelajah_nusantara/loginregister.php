<?php
session_start();
include 'db.php';

// Fungsi untuk sanitize input
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$errors = [];
$success = '';
$response = "";

// Proses Registrasi & Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses Registrasi
    if (isset($_POST['register'])) {
        $username = cleanInput($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (!$username) $errors[] = "Username wajib diisi.";
        if (!$password) $errors[] = "Password wajib diisi.";
        if ($password !== $confirm_password) $errors[] = "Password dan konfirmasi tidak sama.";

        if (empty($errors)) {
            $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
            if (mysqli_num_rows($checkUser) > 0) {
                $errors[] = "Username sudah digunakan.";
            }
        }

        if (empty($errors)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            // FIX: Menggunakan kolom 'role_users' agar pas dengan otomatisasi db.php kalian
            $insert = mysqli_query($conn, "INSERT INTO users (username, password, role_users) VALUES ('$username', '$password_hash', 'user')");
            if ($insert) {
                // FIX: Langsung dialihkan menggunakan JS Alert agar halaman tidak stuck menggantung!
                echo "<script>
                        alert('Registrasi berhasil! Silakan masuk menggunakan akun baru Anda.');
                        window.location.href='loginregister.php';
                      </script>";
                exit();
            } else {
                $errors[] = "Gagal registrasi.";
            }
        }
    }

    // Proses Login
    if (isset($_POST['login'])) {
        $username = cleanInput($_POST['username']);
        $password = $_POST['password'];

        if (!$username || !$password) {
            $errors[] = "Username dan password wajib diisi.";
        } else {
            $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
            if (mysqli_num_rows($query) === 1) {
                $user = mysqli_fetch_assoc($query);
                if (password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role_users']; // FIX: Menyesuaikan dengan role_users
                    $_SESSION['id'] = $user['id'];

                    // FIX: Menghilangkan typo koma pada kata 'admin'
                    header("Location: " . ($user['role_users'] === 'admin' ? "admin/dashboard.php" : "index.php"));
                    exit();
                } else {
                    $errors[] = "Password salah.";
                }
            } else {
                $errors[] = "Username tidak ditemukan.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login & Registrasi - Jelajah Nusantara</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(rgba(40, 58, 54, 0.04), rgba(21, 156, 140, 0.32)),
            url('https://i.pinimg.com/736x/0c/75/f1/0c75f1fa68710fdabd119ea4e306c61a.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: white;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
        width: 360px;
        position: relative;
    }

    h2 {
        text-align: center;
        color: #159c8c;
        margin-bottom: 20px;
    }

    .toggle-btns {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .toggle-btns button {
        width: 50%;
        padding: 10px;
        border: none;
        background-color: #a0e6de;
        color: #0e5f56;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .toggle-btns .active {
        background-color: #1abc9c;
        color: white;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .input-group {
        position: relative;
    }

    input[type="text"],
    input[type="password"] {
        padding: 10px 12px;
        margin-bottom: 15px;
        border: 2px solid #b2dfdb;
        border-radius: 6px;
        font-size: 14px;
        width: 100%;
    }

    .toggle-eye {
        position: absolute;
        top: 0;
        bottom: 17px;
        right: 0px;
        display: flex;
        align-items: center;
        cursor: pointer;
        color: #159c8c;
    }

    .toggle-eye i {
        width: 20px;
        height: 20px;
    }

    button[type="submit"] {
        background-color: #1abc9c;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        transition: 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #159c8c;
    }

    .error,
    .success {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 6px;
        font-size: 14px;
    }

    .error {
        background: #ffe5e5;
        color: #a10000;
    }

    .success {
        background: #e0f7f5;
        color: #00796b;
    }

    small {
        text-align: center;
        display: block;
        margin-top: 12px;
        color: #00675b;
    }
    </style>
</head>
<body>

<div class="container">
    <h2 id="form-title">Login</h2>

    <?php if ($errors): ?>
        <div class="error" id="message-box">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success): ?>
        <div class="success" id="message-box"><?= $success ?></div>
    <?php endif; ?>

    <div class="toggle-btns">
        <button id="login-btn" class="active">Login</button>
        <button id="register-btn">Registrasi</button>
    </div>

    <form method="POST" id="login-form">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required autocomplete="off" />
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required autocomplete="off" />
            <span class="toggle-eye" onclick="togglePassword(this)">
                <i data-lucide="eye"></i>
            </span>
        </div>
        <button type="submit" name="login">Masuk</button>
    </form>

    <form method="POST" id="register-form" style="display:none;">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required autocomplete="off" />
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required autocomplete="off" />
            <span class="toggle-eye" onclick="togglePassword(this)">
                <i data-lucide="eye"></i>
            </span>
        </div>
        <div class="input-group">
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required autocomplete="off" />
            <span class="toggle-eye" onclick="togglePassword(this)">
                <i data-lucide="eye"></i>
            </span>
        </div>
        <button type="submit" name="register">Daftar</button>
    </form>

    <small>Jelajah Nusantara &copy; 2025</small>
</div>

<script>
    // lucide icons
    lucide.createIcons();

    // toggle password
    function togglePassword(el) {
        const input = el.previousElementSibling;
        const icon = el.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute("data-lucide", "eye-off");
        } else {
            input.type = "password";
            icon.setAttribute("data-lucide", "eye");
        }

        lucide.createIcons();
    }

    // switch form
    const loginBtn = document.getElementById('login-btn');
    const registerBtn = document.getElementById('register-btn');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formTitle = document.getElementById('form-title');

    loginBtn.onclick = () => {
        loginBtn.classList.add('active');
        registerBtn.classList.remove('active');
        loginForm.style.display = 'flex';
        registerForm.style.display = 'none';
        formTitle.textContent = 'Login';
    };

    registerBtn.onclick = () => {
        registerBtn.classList.add('active');
        loginBtn.classList.remove('active');
        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';
        formTitle.textContent = 'Registrasi';
    };

    // hide alert after 2 seconds
    const messageBox = document.getElementById('message-box');
    if (messageBox) {
        setTimeout(() => messageBox.style.display = 'none', 2000);
    }
</script>

</body>
</html>

<header style="position: absolute; top: 80px; left: 0; width: 100%; text-align: center;">
    <h1 style="color:rgb(255, 255, 255); font-size: 30px; font-weight: bold; margin: 0;">
        Welcome to 🗺️ Jelajah Nusantara!
    </h1>
</header>