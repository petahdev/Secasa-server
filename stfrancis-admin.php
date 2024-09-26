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
        $mail->Subject = "New Admin Message from SECASA (St. Francis)";
        $mail->Body    = "
        <h2>Message from SECASA Admin (St. Francis)</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Position:</strong> $position</p>
        <p><strong>Message:</strong></p>
        <p>$message</p>
        ";

        $mail->send();
        echo "<div style='color: green; text-align:center;'>Message sent successfully to St. Francis members!</div>";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to retrieve emails from the St. Paul table
function getStPaulEmails($conn) {
    $emails = [];
    $sql = "SELECT email FROM stfrancis";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }
    }

    return $emails;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $message = $_POST['message'];

    // Get all emails from the St. Paul table
    $recipients = getStPaulEmails($conn);

    if (!empty($recipients)) {
        // Send the email to all recipients
        sendEmailToAll($recipients, $name, $position, $message);
    } else {
        echo "<div style='color: red; text-align:center;'>No emails found for St. Francis members.</div>";
    }
}

$conn->close();
?>
