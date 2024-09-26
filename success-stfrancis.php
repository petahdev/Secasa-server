<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SECASA - Group Details</title>
    <link rel="stylesheet" href="stfrancis.css">
</head>
<body>
    <header>
        <button class="toggle-button" onclick="toggleSidebar()">☰</button>
        <h1>Welcome to SECASA Groups</h1>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="logo">
            <img src="path-to-logo" alt="SECASA Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Group Details</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </aside>

    <main onclick="closeSidebar()">
    <section class="landing">
        <h2>SECASA Groups and Activities</h2>
        <p>Learn more about our jumuiyas, contacts, and what they do.</p>
    </section>

    <section class="group-form">
        <h3>Register for SECASA Groups</h3>

        <?php
        include 'connect.php'; // Include your database connection

        $errorMessage = '';  // Error message initialization

        // Check if form is submitted
        if (isset($_POST['subscribe'])) {
            $email = $_POST['email'];
            $phoneNumber = $_POST['phone_number'];
            $password = $_POST['password'];

            // Prepare SQL statement to check if the user exists
            $stmt = $conn->prepare("SELECT * FROM stfrancis WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User exists, allow subscription
                echo "
                <div class='success-message'>
                    <img src='stpauls-images/stp.jpeg' alt='Success' style='width:100%;'>
                    <p>Subscription successful! You will start receiving weekly emails.</p>
                </div>";
            } else {
                // User doesn't exist, show error
                $errorMessage = "This email is not registered for any jumuiya. Please sign up first.";
            }

            $stmt->close();
        }
        ?>

        <!-- If there is an error, display it -->
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message" style="color: red; text-align: center; font-weight: bold; padding: 10px;">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form action="testemail.php" method="POST">
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone_number" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" name="subscribe">Subscribe</button>
</form>
    </section>
</main>

    <footer>
        <p>&copy; 2024 South Eastern Kenya University Catholic Students Association. All Rights Reserved.</p>
    </footer>

    <script src="group-scripts.js"></script>
</body>
</html>
