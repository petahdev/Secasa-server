<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is loaded

// Database connection
$conn = new mysqli("localhost", "root", "", "secasa");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send email to multiple recipients
function sendEmailToAll($recipients, $name, $position, $message) {
    $mail = new PHPMailer(true);
    $admin_email = "mutitupeter76@gmail.com";

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $admin_email;
        $mail->Password   = 'fbwj edrn alpz alur'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($admin_email, 'SECASA');
        
        // Add all email addresses from the recipients array
        foreach ($recipients as $email) {
            $mail->addBCC($email); // Use BCC to send to all without exposing other recipients
        }

        $mail->isHTML(true);
        $mail->Subject = "New Admin Message from SECASA";
        $mail->Body    = "
        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
            <div style='background-color: #22c55e; height: 50px; width: 15px; position: absolute; top: 0; left: 0; clip-path: polygon(0 0, 100% 0, 0 100%);'></div>
            <h2 style='margin: 0; padding: 20px; text-align: center; color: #333;'>Message from SECASA Admin</h2>
            <div style='padding: 20px;'>
                <p style='font-size: 16px; color: #555;'><strong>Name:</strong> $name</p>
                <p style='font-size: 16px; color: #555;'><strong>Position:</strong> $position</p>
                <p style='font-size: 16px; color: #555;'><strong>Message:</strong></p>
                <p style='font-size: 16px; color: #555;'>$message</p>
            </div>
        </div>
        ";

        $mail->send();
        // Styled success message similar to error.php
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Success</title>
            <style>
                body {
                    background-color: #202221; /* Background color */
                    color: #fff; /* Text color */
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 100px;
                }
                .success-message {
                    font-size: 24px; /* Font size for the message */
                    margin-bottom: 20px;
                    color: #d4edda; /* Greenish color for success */
                }
                .status-message {
                    font-size: 18px; /* Font size for the status message */
                }
            </style>
        </head>
        <body>
            <div class='success-message'>Message sent successfully!</div>
            <div class='status-message'>The message has been sent to all members.</div>
        </body>
        </html>
        ";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to retrieve emails from all the tables
function getAllEmails($conn) {
    $tables = ['stpauls', 'staugustine', 'stmonica', 'standrew', 'stfrancis'];
    $emails = [];

    foreach ($tables as $table) {
        $sql = "SELECT email FROM $table";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        }
    }

    return $emails;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $message = $_POST['message'];

    // Get all emails from the database
    $recipients = getAllEmails($conn);

    if (!empty($recipients)) {
        // Send the email to all recipients
        sendEmailToAll($recipients, $name, $position, $message);
    } else {
        echo "<div style='color: red; text-align:center;'>No emails found in the database.</div>";
    }
}

$conn->close();
?>
