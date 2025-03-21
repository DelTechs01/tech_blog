<?php 
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $query)) {
        $success = "Message sent successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Tech Blog</title>
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
            <h1>Contact Us</h1>
            
            <form method="post" class="contact-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit" name="submit">Send Message</button>
            </form>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

            <section class="messages">
                <h2>Recent Messages</h2>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY submitted_at DESC LIMIT 5");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='message'>";
                    echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> (" . htmlspecialchars($row['email']) . ")</p>";
                    echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                    echo "<small>" . $row['submitted_at'] . "</small>";
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