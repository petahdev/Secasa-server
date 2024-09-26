<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Input Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #22c55e;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 1.1em;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #22c55e;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #1ea34b;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .success {
            color: green;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Information Form</h1>
    <form id="admin-form"  onsubmit="return validateForm()">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email">

        <button type="submit">Submit</button>
        
        <p id="message" class="error"></p>
    </form>
</div>


</body>
</html>
