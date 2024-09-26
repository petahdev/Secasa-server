<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader if you're using Composer
require 'vendor/autoload.php';
include 'connect.php';  // Include your database connection

// Function to send emails
function sendEmail($email, $first_name, $logoPath, $subject, $content) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mutitupeter76@gmail.com';
        $mail->Password = 'fbwj edrn alpz alur';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('mutitupeter76@gmail.com', 'SECASA');
        $mail->addAddress($email); // Add recipient

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;

        // Well-styled email with SECASA theme colors and logo
        $mailContent = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 5px; }
                .header { text-align: center; padding: 10px; }
                .header img { width: 100px; }
                .content { padding: 20px; }
                .footer { background-color: #22C55E; color: white; text-align: center; padding: 10px; }
                .button { background-color: #22C55E; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <img src='" . $logoPath . "' alt='SECASA Logo'>
                    <h2>Welcome to SECASA, $first_name!</h2>
                </div>
                <div class='content'>
                    <p>$content[0]</p>
                    <p>$content[1]</p>
                    <a href='https://secasa.site.com' class='button'>Visit Our Website</a>
                </div>
                <div class='footer'>
                    &copy; 2024 South Eastern Kenya University Catholic Students Association. All Rights Reserved.
                </div>
            </div>
        </body>
        </html>";

        $mail->Body = $mailContent;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email not sent. Error: " . $mail->ErrorInfo); // Log the error
        return false;
    }
}

// Process form submission
if (isset($_POST['subscribe'])) {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $phoneNumber = $_POST['phone_number'];
    $password = $_POST['password'];

    // Insert user details into the database
    $stmt = $conn->prepare("INSERT INTO stpauls (email, first_name, phone_number, password, last_email_sent) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $email, $first_name, $phoneNumber, $password);

    if ($stmt->execute()) {
        // Send immediate confirmation email
        $content = [
            "You have successfully subscribed to SECASA! We are excited to have you on board and look forward to your active participation.",
            "Please remember to check our website regularly for updates on events, including the upcoming jumuiya meeting scheduled for 7:30 PM in the hall. We can't wait to see you there!"
        ];
        $logoPath = "path/to/secasa-logo.png"; // Path to your logo
        if (sendEmail($email, $first_name, $logoPath, "Subscription Confirmation", $content)) {
            echo "Subscription successful. A confirmation email has been sent.";
        } else {
            echo "Subscription successful, but failed to send confirmation email.";
        }
    } else {
        echo "Subscription failed. Please try again.";
    }
}

// Schedule Tuesday emails manually within PHP
function sendTuesdayEmails() {
    global $conn;

    // Get all subscribed users
    $stmt = $conn->prepare("SELECT email, first_name, last_email_sent FROM stpauls WHERE DATEDIFF(NOW(), last_email_sent) >= 7");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $first_name = $row['first_name'];
        $lastEmailSent = $row['last_email_sent'];

        // Check if it's Tuesday and the specific time (7 AM, 6 PM)
        $dayOfWeek = date('w');
        $currentTime = date('H');

        if ($dayOfWeek == 2) {
            if ($currentTime == 7 || $currentTime == 18) {
                $reminderContent = [
                    "This is a reminder that there will be a jumuiya meeting in the hall at 7:30 PM.",
                    "We encourage you to join us for this important gathering where we'll discuss various topics and plan future activities. Your presence is greatly appreciated!"
                ];
                $logoPath = "path/to/secasa-logo.png";

                // Send email
                if (sendEmail($email, $first_name, $logoPath, "Weekly Reminder", $reminderContent)) {
                    // Update last_email_sent timestamp
                    $updateStmt = $conn->prepare("UPDATE stpauls SET last_email_sent = NOW() WHERE email = ?");
                    $updateStmt->bind_param("s", $email);
                    $updateStmt->execute();
                }
            }
        }
    }
}

// Call the function to send Tuesday emails when the script is executed
sendTuesdayEmails();
