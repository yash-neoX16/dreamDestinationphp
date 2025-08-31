<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require 'DBconfig.php';
include 'includes/header.php';

// Fetch stats
$totalCountries = $pdo->query("SELECT COUNT(*) FROM countries")->fetchColumn();
$totalPlaces = $pdo->query("SELECT COUNT(*) FROM places")->fetchColumn();

// Fetch all countries and places
$countries = $pdo->query("SELECT * FROM countries ORDER BY id DESC")->fetchAll();
$places = $pdo->query("SELECT * FROM places ORDER BY id DESC")->fetchAll();
?>

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f0f2f5;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}
.card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}
.card h3 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #1e293b;
}
.stat {
    font-size: 28px;
    font-weight: 700;
    color: #4f46e5;
}
.muted {
    color: #64748b;
    font-size: 14px;
}
.btn {
    display: inline-block;
    margin-top: 12px;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
}
.btn-primary {
    background: linear-gradient(90deg,#4f46e5,#06b6d4);
    color: #fff;
}
.btn-danger {
    background: #dc2626;
    color: #fff;
}
.gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 20px;
}
.gallery-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
}
.gallery-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}
.gallery-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    transition: transform 0.3s;
}
.gallery-card:hover img {
    transform: scale(1.05);
}
.card-body {
    padding: 10px;
    text-align: center;
}
.card-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px;
}
.card-text {
    font-size: 0.85rem;
    color: #555;
}

/* Hover overlay for actions */
.action-buttons {
    position: absolute;
    top: 8px;
    right: 8px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s;
}
.gallery-card:hover .action-buttons {
    opacity: 1;
}
.action-buttons a {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    text-align: center;
}
.action-buttons .edit-btn {
    background: #4f46e5;
}
.action-buttons .delete-btn {
    background: #dc2626;
}
</style>

<div class="grid">
    <div class="card">
        <h3>Total Countries</h3>
        <div class="stat"><?= $totalCountries ?></div>
        <div class="muted">In your database</div>
        <a href="countries.php" class="btn btn-primary">Manage Countries</a>
    </div>

    <div class="card">
        <h3>Total Places</h3>
        <div class="stat"><?= $totalPlaces ?></div>
        <div class="muted">Added destinations</div>
        <a href="places.php" class="btn btn-primary">Manage Places</a>
    </div>

    <div class="card">
        <h3>Quick Action</h3>
        <p class="muted">Add a new country or place directly.</p>
        <a href="add_country.php" class="btn btn-primary">+ Add Country</a>
        <a href="add_place.php" class="btn btn-primary" style="margin-left:5px;">+ Add Place</a>
    </div>
</div>

<h4>Countries</h4>
<div class="gallery">
    <?php foreach($countries as $country): ?>
        <div class="gallery-card">
            <div class="action-buttons">
                <a href="edit_country.php?id=<?= $country['id'] ?>" class="edit-btn">Edit</a>
                <a href="delete_country.php?id=<?= $country['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure to delete this country?');">Delete</a>
            </div>
            <?php if($country['photo'] && file_exists("uploads/".$country['photo'])): ?>
                <img src="uploads/<?= htmlspecialchars($country['photo']) ?>" alt="<?= htmlspecialchars($country['name']) ?>">
            <?php else: ?>
                <img src="uploads/no-image.png" alt="No Image">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($country['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars(substr($country['description'],0,50)) ?>...</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h4 class="mt-5">Places</h4>
<div class="gallery">
    <?php foreach($places as $place): ?>
        <div class="gallery-card">
            <div class="action-buttons">
                <a href="edit_place.php?id=<?= $place['id'] ?>" class="edit-btn">Edit</a>
                <a href="delete_place.php?id=<?= $place['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure to delete this place?');">Delete</a>
            </div>
            <?php if($place['photo'] && file_exists("uploads/".$place['photo'])): ?>
                <img src="uploads/<?= htmlspecialchars($place['photo']) ?>" alt="<?= htmlspecialchars($place['name']) ?>">
            <?php else: ?>
                <img src="uploads/no-image.png" alt="No Image">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($place['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars(substr($place['description'],0,50)) ?>...</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
