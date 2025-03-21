<?php 
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $image = uploadFile($_FILES['image']) ?: null;
        $video = uploadFile($_FILES['video']) ?: null;
        $audio = uploadFile($_FILES['audio']) ?: null;
        $query = "INSERT INTO articles (title, content, image_path, video_path, audio_path) VALUES ('$title', '$content', '$image', '$video', '$audio')";
        mysqli_query($conn, $query);
    }
    elseif (isset($_POST['edit'])) {
        $id = (int)$_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $query = "UPDATE articles SET title='$title', content='$content' WHERE id=$id";
        mysqli_query($conn, $query);
    }
    elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $query = "DELETE FROM articles WHERE id=$id";
        mysqli_query($conn, $query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - Tech Blog</title>
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
            <h1>Manage Articles</h1>
            
            <form method="post" enctype="multipart/form-data" class="article-form">
                <input type="text" name="title" placeholder="Article Title" required>
                <textarea name="content" placeholder="Article Content" required></textarea>
                <input type="file" name="image" accept="image/*">
                <input type="file" name="video" accept="video/*">
                <input type="file" name="audio" accept="audio/*">
                <button type="submit" name="add">Publish Article</button>
            </form>

            <section class="article-list">
                <?php
                $query = "SELECT * FROM articles ORDER BY created_at DESC";
                if (isset($_GET['search'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                    $query = "SELECT * FROM articles WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC";
                }
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<article>";
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    if ($row['image_path']) echo "<img src='" . htmlspecialchars($row['image_path']) . "'>";
                    if ($row['video_path']) echo "<video controls><source src='" . htmlspecialchars($row['video_path']) . "'></video>";
                    if ($row['audio_path']) echo "<audio controls><source src='" . htmlspecialchars($row['audio_path']) . "'></audio>";
                    echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                    
                    echo "<form method='post' class='edit-form'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<input type='text' name='title' value='" . htmlspecialchars($row['title']) . "'>";
                    echo "<textarea name='content'>" . htmlspecialchars($row['content']) . "</textarea>";
                    echo "<div class='form-actions'>";
                    echo "<button type='submit' name='edit'>Update</button>";
                    echo "<button type='submit' name='delete'>Delete</button>";
                    echo "</div>";
                    echo "</form>";
                    echo "</article>";
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