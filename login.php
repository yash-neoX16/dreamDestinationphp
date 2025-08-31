<?php
session_start();
require 'DBconfig.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fetch admin by email
    $stmt = $pdo->prepare("SELECT id, name, email, password_hash FROM admins WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Plain text password check
    if ($admin && $password === $admin['password_hash']) {
        $_SESSION['admin'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: dashboard.php");
        exit;
    } else {
        $err = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DreamDestination Admin Login</title>
<style>
body{
  display:flex;
  align-items:center;
  justify-content:center;
  height:100vh;
  background:linear-gradient(135deg,#4f46e5,#06b6d4);
  font-family: 'Inter', sans-serif;
}
.login-box{
  width:380px;
  background:#fff;
  padding:30px;
  border-radius:16px;
  box-shadow:0 8px 30px rgba(0,0,0,0.2);
}
.login-box h2{
  margin:0 0 12px;
  color:#1e293b;
  text-align:center;
}
.login-box p{color:#64748b;text-align:center;margin-bottom:20px}
.input{width:100%;padding:12px;border:1px solid #cbd5e1;border-radius:10px;margin-bottom:14px}
.btn{width:100%;padding:12px;border:none;border-radius:10px;cursor:pointer;font-weight:600}
.btn-primary{background:linear-gradient(90deg,#4f46e5,#06b6d4);color:#fff}
.error{background:#fee2e2;color:#b91c1c;padding:10px;border-radius:8px;margin-bottom:14px;text-align:center}
</style>
</head>
<body>
<div class="login-box">
  <h2>Admin Login</h2>
  <p>Sign in to manage DreamDestination</p>

  <?php if($err): ?>
    <div class="error"><?= htmlspecialchars($err) ?></div>
  <?php endif; ?>

  <form method="post">
    <input type="email" class="input" name="email" placeholder="Email" required>
    <input type="password" class="input" name="password" placeholder="Password" required>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>
</body>
</html>
