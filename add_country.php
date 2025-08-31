<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require 'DBconfig.php';
include 'includes/header.php';

// Insert logic
if (isset($_POST['submit'])) {
    $name = $_POST['country'];       // form input
    $desc = $_POST['description'];   // form input
    $photoName = null;

    // handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        $target = "uploads/" . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }

    // Insert into database using correct variables
    $stmt = $pdo->prepare("INSERT INTO countries (name, description, photo) VALUES (?, ?, ?)");
    $stmt->execute([$name, $desc, $photoName]);

    header("Location: countries.php");
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
  input,textarea{
    width:100%;padding:10px 12px;border:1px solid #cbd5e1;
    border-radius:8px;font-size:14px
  }
  textarea{resize:vertical;min-height:80px}
  .btn{padding:10px 14px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px}
  .btn-primary{background:linear-gradient(90deg,#4f46e5,#06b6d4);color:#fff;border:none;cursor:pointer}
</style>

<div class="card">
  <h3>Add Country</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label>Country Name</label>
      <input type="text" name="country" required>
    </div>
    <div class="form-group">
      <label>Description</label>
      <textarea name="description" required></textarea>
    </div>
    <div class="form-group">
      <label>Photo</label>
      <input type="file" name="photo" accept="image/*">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
