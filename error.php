<?php
session_start(); // Start the session

// Get the error message from the session
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "An unknown error occurred.";
unset($_SESSION['error_message']); // Clear the error message after displaying it
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            background-color: #202221; /* Background color */
            color: #fff; /* Text color */
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 100px;
        }
        .error-message {
            font-size: 24px; /* Font size for the message */
            margin-bottom: 20px;
        }
        .redirect-message {
            font-size: 18px; /* Font size for the redirect message */
        }
    </style>
    <script>
        // Redirect after 4 seconds
        setTimeout(function() {
            window.location.href = "index.php"; // Redirect URL
        }, 4000);
    </script>
</head>
<body>
    <div class="error-message"><?php echo $error_message; ?></div>
    <div class="redirect-message">You will be redirected shortly...</div>
</body>
</html>
