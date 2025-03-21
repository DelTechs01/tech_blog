<?php 
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload'])) {
        $image = uploadFile($_FILES['image']);
        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $query = "INSERT INTO gallery (image_path, caption) VALUES ('$image', '$caption')";
        mysqli_query($conn, $query);
    }
    elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $query = "DELETE FROM gallery WHERE id=$id";
        mysqli_query($conn, $query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Tech Blog</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Tech Blog</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="articles.php">Articles</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <form method="get" action="articles.php" class="search-form">
                <input type="text" name="search" placeholder="Search articles...">
                <button type="submit">Search</button>
            </form>
        </div>
    </header>

    <div class="container">
        <main>
            <h1>Gallery</h1>
            
            <form method="post" enctype="multipart/form-data" class="gallery-form">
                <input type="file" name="image" accept="image/*" required>
                <input type="text" name="caption" placeholder="Image Caption">
                <button type="submit" name="upload">Upload Image</button>
            </form>

            <section class="gallery">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY upload_date DESC");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='gallery-item'>";
                    echo "<img src='" . htmlspecialchars($row['image_path']) . "'>";
                    echo "<p>" . htmlspecialchars($row['caption']) . "</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<button type='submit' name='delete'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                }
                mysqli_free_result($result);
                ?>
            </section>
        </main>

        <aside>
            <h3>Recent Posts</h3>
            <ul>
                <?php
                $result = mysqli_query($conn, "SELECT id, title FROM articles ORDER BY created_at DESC LIMIT 5");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a href='articles.php?id={$row['id']}'>" . htmlspecialchars($row['title']) . "</a></li>";
                }
                mysqli_free_result($result);
                ?>
            </ul>
        </aside>
    </div>

    <footer>
        <div class="footer-content">
            <div>
                <h3>Tech Blog</h3>
                <p>© 2025 All Rights Reserved</p>
            </div>
            <div>
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="articles.php">Articles</a></li>
                </ul>
            </div>
            <div class="social-links">
                <h3>Follow Us</h3>
                <a href="#">&#x1F426;</a>
                <a href="#">&#x1F458;</a>
                <a href="#">&#x1F4F8;</a>
            </div>
        </div>
    </footer>
</body>
</html>