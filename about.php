<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Tech Blog</title>
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
            <h1>About Us</h1>
            <section class="about-content">
                <div class="about-text">
                    <p>We are a passionate team dedicated to exploring and sharing the latest in technology. Our mission is to inform and inspire through quality content.</p>
                    <div class="stats">
                        <?php
                        $articleCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM articles"))[0];
                        $galleryCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM gallery"))[0];
                        echo "<p><strong>$articleCount</strong> Articles Published</p>";
                        echo "<p><strong>$galleryCount</strong> Gallery Items</p>";
                        ?>
                    </div>
                </div>
                <img src="images/team.jpg" alt="Our Team" class="about-image">
            </section>

            <!-- New Team Showcase Section -->
            <section class="team">
                <h2>Meet Our Team</h2>
                <div class="team-member">
                    <img src="images/Christiano.jpg" alt="John Doe">
                    <h3>Christiano</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <img src="images/thomassheby.jpg" alt="Jane Smith">
                    <h3>Thomas Sheby</h3>
                    <p>Lead Developer</p>
                </div>
                <div class="team-member">
                    <img src="images/roro.jpg" alt="Emily Davis">
                    <h3>Roro</h3>
                    <p>Content Manager</p>
                </div>
            </section>

            <!-- New Testimonials Section -->
            <section class="testimonials">
                <h2>What Our Readers Say</h2>
                <blockquote>
                    <p>"Tech Blog keeps me up-to-date with cutting-edge technology. Love the content!"</p>
                    <footer>- Jane D.</footer>
                </blockquote>
                <blockquote>
                    <p>"Excellent insights and thorough articles on trending topics!"</p>
                    <footer>- Alex P.</footer>
                </blockquote>
            </section>

            <!-- Newsletter Subscription -->
            <section class="subscribe">
                <h2>Subscribe to Our Newsletter</h2>
                <form method="post" action="subscribe.php">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </section>

            <!-- FAQ Section -->
            <section class="faq">
                <h2>Frequently Asked Questions</h2>
                <div class="question">
                    <h3>How can I submit an article?</h3>
                    <p>You can submit your article via our contact form or email us directly at contact@techblog.com.</p>
                </div>
                <div class="question">
                    <h3>Do you accept guest posts?</h3>
                    <p>Yes, we welcome guest contributions. Please reach out to us for guidelines.</p>
                </div>
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
            <div>
                <h3>Contact Us</h3>
                <p>Email: contact@techblog.com</p>
                <p>Phone: +1 234 567 890</p>
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
