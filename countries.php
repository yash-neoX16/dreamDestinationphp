<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require 'DBconfig.php';
include 'includes/header.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM countries WHERE id = ?")->execute([$id]);
    header("Location: countries.php");
    exit;
}

// Fetch countries
$countries = $pdo->query("SELECT * FROM countries ORDER BY id DESC")->fetchAll();
?>
<style>
  .card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:20px;
  }
  .card h3{
    margin:0 0 14px;
    font-size:18px;
    color:#1e293b
  }
  .btn{
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    font-size:14px
  }
  .btn-primary{
    background:linear-gradient(90deg,#4f46e5,#06b6d4);
    color:#fff
  }
  .btn-ghost{
    background:#f1f5f9;
    color:#334155
  }
  table{
    width:100%;
    border-collapse:collapse
  }
  th,td{
    padding:12px 14px;
    text-align:left;
    border-bottom:1px solid #e2e8f0;
    font-size:14px
  }
  th{
    background:#f8fafc;
    color:#475569
  }
  tr:hover{
    background:#f9fafb
  }
  img.thumb{
    width:60px;
    height:40px;
    object-fit:cover;
    border-radius:6px
    }
</style>

<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <h3>Countries</h3>
    <a href="add_country.php" class="btn btn-primary">+ Add Country</a>
  </div>
  <table style="margin-top:14px">
    <thead>
      <tr>
        <th>ID</th>
        <th>Country</th>
        <th>Description</th>
        <th>Photo</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($countries as $c): ?>
        <tr>
          <td><?= $c['id'] ?></td>
         <td><?= htmlspecialchars($c['name']) ?></td>
          <td style="max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            <?= htmlspecialchars($c['description']) ?>
          </td>
         <td>
  <?php if ($c['photo'] && file_exists("uploads/".$c['photo'])): ?>
    <img src="uploads/<?= htmlspecialchars($c['photo']) ?>" class="thumb">
  <?php else: ?>
    <span>No Image</span>
  <?php endif; ?>
</td>

          <td>
            <a href="edit_country.php?id=<?= $c['id'] ?>" class="btn btn-ghost">Edit</a>
            <a href="countries.php?delete=<?= $c['id'] ?>" class="btn btn-ghost" onclick="return confirm('Delete this country?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
