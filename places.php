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
    $pdo->prepare("DELETE FROM places WHERE id = ?")->execute([$id]);
    header("Location: places.php");
    exit;
}

// Fetch places with country names
$sql = "SELECT p.id, p.name AS place_name, p.description, p.photo, c.name AS country_name
        FROM places p
        LEFT JOIN countries c ON p.country_id = c.id
        ORDER BY p.id DESC";
$places = $pdo->query($sql)->fetchAll();
?>
<style>
.card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:20px;
}
.card h3{margin:0 0 14px;font-size:18px;color:#1e293b}
.btn{padding:8px 12px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px}
.btn-primary{background:linear-gradient(90deg,#4f46e5,#06b6d4);color:#fff}
.btn-ghost{background:#f1f5f9;color:#334155}
table{width:100%;border-collapse:collapse}
th,td{padding:12px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px}
th{background:#f8fafc;color:#475569}
tr:hover{background:#f9fafb}
img.thumb{width:60px;height:40px;object-fit:cover;border-radius:6px}
</style>

<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <h3>Places</h3>
    <a href="add_place.php" class="btn btn-primary">+ Add Place</a>
  </div>
  <table style="margin-top:14px">
    <thead>
      <tr>
        <th>ID</th>
        <th>Place</th>
        <th>Description</th>
        <th>Country</th>
        <th>Photo</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($places as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['place_name']) ?></td>
          <td style="max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            <?= htmlspecialchars($p['description']) ?>
          </td>
          <td><?= htmlspecialchars($p['country_name']) ?></td>
          <td>
            <?php if ($p['photo'] && file_exists("uploads/".$p['photo'])): ?>
              <img src="uploads/<?= htmlspecialchars($p['photo']) ?>" class="thumb">
            <?php else: ?>
              <span>No Image</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="edit_place.php?id=<?= $p['id'] ?>" class="btn btn-ghost">Edit</a>
            <a href="places.php?delete=<?= $p['id'] ?>" class="btn btn-ghost" onclick="return confirm('Delete this place?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
