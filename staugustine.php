<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAint Augustine membership signup</title>
    <link rel="stylesheet" href="staugustine.css">
</head>
<body>
   
        <button class="toggle-button" onclick="toggleSidebar()">☰</button>
      
   

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
    <div class="landing-content">
        <h1 class="heading">Welcome to St. Paul's Community</h1>
        <p class="paragraph">Join us in our mission to inspire and support each other. Together, we can make a difference in our lives and the community.</p>
    </div>
    <main onclick="closeSidebar()">
        <section class="landing">
            <h2>SECASA Groups and Activities</h2>
            <p>Learn more about our jumuiyas, contacts, and what they do.</p>
        </section>

        <section class="group-form">
            <h3>Register for SECASA Groups</h3>
            <form action="register.php" method="POST" enctype="multipart/form-data">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="first_name" required>

        <label for="secondName">Second Name:</label>
        <input type="text" id="secondName" name="second_name" required>

        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone_number" required>

        <label for="course">Course Done:</label>
        <input type="text" id="course" name="course_done" required>

        <label for="year">Year of Study:</label>
        <input type="text" id="year" name="year_of_study" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="repeatPassword">Repeat Password:</label>
        <input type="password" id="repeatPassword" name="repeat_password" required>

        <label for="image">Profile Image (Optional):</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit">Register</button>
        
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
    </form>
    <p style="text-align:center;">Or</p>
    <p style="text-align:center;"><a style="text-decoration:none; color:#22c55e;" href="success.php">Subscribe to St Paul's Reminders</a></p>

        </section>

        <section class="contact-form">
            <h3>Contact Us</h3>
            <form action="contact.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="emailContact">Email:</label>
                <input type="email" id="emailContact" name="emailContact" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 South Eastern Kenya University Catholic Students Association. All Rights Reserved.</p>
    </footer>

    <script src="group-scripts.js"></script>
</body>
</html>
