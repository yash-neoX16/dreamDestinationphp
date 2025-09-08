<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DreamDestination Admin</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body{margin:0;font-family:'Inter',sans-serif;background:#f8fafc;color:#0f172a}
    .layout{display:flex;min-height:100vh}
    .sidebar{
      width:240px;
      background:linear-gradient(180deg,#4f46e5,#06b6d4);
      color:#fff;
      padding:20px;
    }
    .sidebar h2{margin:0 0 24px;font-size:20px;text-align:center}
    .nav a{
      display:block;
      padding:10px 14px;
      margin-bottom:8px;
      border-radius:8px;
      color:#fff;
      text-decoration:none;
      font-weight:500;
      transition:0.2s;
    }
    .nav a:hover, .nav a.active{background:rgba(255,255,255,0.2)}
    .content{flex:1;padding:24px}
    .topbar{
      display:flex;justify-content:space-between;align-items:center;
      margin-bottom:20px;
    }
    .topbar h1{margin:0;font-size:22px}
    .profile{font-size:14px;color:#475569}
  </style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <h2>DreamDestination</h2>
    <nav class="nav">
      <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':'' ?>">Dashboard</a>
      <a href="countries.php" class="<?= basename($_SERVER['PHP_SELF'])=='countries.php'?'active':'' ?>">Countries</a>
      <a href="places.php" class="<?= basename($_SERVER['PHP_SELF'])=='places.php'?'active':'' ?>">Places</a>
      <a href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="content">
    <div class="topbar">
      <h1>Admin Panel</h1>
      <div class="profile">
        <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>
      </div>
    </div>