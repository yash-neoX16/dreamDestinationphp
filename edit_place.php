<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require 'DBconfig.php';
include 'includes/header.php';

// Get place ID from URL
if (!isset($_GET['id'])) {
    header("Location: places.php");
    exit;
}
$id = (int)$_GET['id'];

// Fetch place data
$stmt = $pdo->prepare("SELECT * FROM places WHERE id = ?");
$stmt->execute([$id]);
$place = $stmt->fetch();
if (!$place) {
    header("Location: places.php");
    exit;
}

// Fetch countries for dropdown
$countries = $pdo->query("SELECT id, name FROM countries ORDER BY name")->fetchAll();

// Handle update
if (isset($_POST['update'])) {
    $name = $_POST['place_name'];
    $desc = $_POST['description'];
    $countryId = $_POST['country_id'];

    $photoName = $place['photo']; // Keep existing photo by default

    // Handle new photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photoName);
    }

    $stmt = $pdo->prepare("UPDATE places SET name = ?, description = ?, country_id = ?, photo = ? WHERE id = ?");
    $stmt->execute([$name, $desc, $countryId, $photoName, $id]);

    header("Location: places.php");
    exit;
}
?>
<style>
.card{
  background:#fff;
  border-radius:14px;
  padding:20px;
  box-shadow:0 6px 20px rgba(0,0,0,0.08);
  max-width:600px;margin:auto;
}
.card h3{margin:0 0 14px;font-size:18px;color:#1e293b}
.form-group{margin-bottom:16px}
label{display:block;margin-bottom:6px;font-weight:500;color:#334155}
input,textarea,select{
  width:100%;padding:10px 12px;border:1px solid #cbd5e1;
  border-radius:8px;font-size:14px
}
textarea{resize:vertical;min-height:80px}
.btn{padding:10px 14px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px}
.btn-primary{background:linear-gradient(90deg,#4f46e5,#06b6d4);color:#fff;border:none;cursor:pointer}
img.thumb{width:80px;height:50px;object-fit:cover;border-radius:6px;margin-top:8px}
</style>

<div class="card">
  <h3>Edit Place</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label>Place Name</label>
      <input type="text" name="place_name" value="<?= htmlspecialchars($place['name']) ?>" required>
    </div>
    <div class="form-group">
      <label>Description</label>
      <textarea name="description" required><?= htmlspecialchars($place['description']) ?></textarea>
    </div>
    <div class="form-group">
      <label>Country</label>
      <select name="country_id" required>
        <?php foreach ($countries as $c): ?>
          <option value="<?= $c['id'] ?>" <?= ($c['id'] == $place['country_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Photo</label>
      <input type="file" name="photo" accept="image/*">
      <?php if ($place['photo'] && file_exists("uploads/".$place['photo'])): ?>
        <img src="uploads/<?= htmlspecialchars($place['photo']) ?>" class="thumb">
      <?php endif; ?>
    </div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
