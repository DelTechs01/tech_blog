<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Blog - Home</title>
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
            <section class="article">
                <h2>Latest Articles</h2>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<article>";
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    if ($row['image_path']) echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Article image'>";
                    if ($row['video_path']) echo "<video controls><source src='" . htmlspecialchars($row['video_path']) . "' type='video/mp4'></video>";
                    if ($row['audio_path']) echo "<audio controls><source src='" . htmlspecialchars($row['audio_path']) . "' type='audio/mp3'></audio>";
                    echo "<p>" . substr(htmlspecialchars($row['content']), 0, 150) . "...</p>";
                    echo "<a href='articles.php?id={$row['id']}' class='read-more'>Read More</a>";
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
                <a href="#">&#x1F426;</a> <!-- Twitter -->
                <a href="#">&#x1F458;</a> <!-- Facebook -->
                <a href="#">&#x1F4F8;</a> <!-- Instagram -->
            </div>
        </div>
    </footer>
</body>
</html>