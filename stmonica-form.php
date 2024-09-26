<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Paul Admin Message Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }
        .form-container h2 {
            text-align: center;
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container textarea {
            height: 100px;
        }
        .form-container input[type="submit"] {
            background-color: #22c55e;
            color: white;
            cursor: pointer;
            border: none;
        }
        .form-container input[type="submit"]:hover {
            background-color: #1da548;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>St. Paul Admin Message</h2>
        <form action="stpauladmin.php" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="position">Position in SECASA</label>
            <input type="text" id="position" name="position" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Enter your message here" required></textarea>

            <input type="submit" value="Send Message">
        </form>
    </div>
</body>
</html>
