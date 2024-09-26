<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mutitupeter76@gmail.com'; // Your email
    $mail->Password   = 'fbwj edrn alpz alur'; // Your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender information
    $mail->setFrom('mutitupeter76@gmail.com', 'SECASA Admin');

    // Database connection
    include 'connect.php'; // Your DB connection file

    // Get email from form submission
    $email = $_POST['email'];

    // Check if the user is in the database
    $stmt = $conn->prepare("SELECT email FROM stpauls WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user email from the database
        $row = $result->fetch_assoc();
        $userEmail = $row['email'];

        // Recipient email address
        $mail->addAddress($userEmail); // Send email to the user from the database

        // Email content styling
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to SECASA Jumuiya Meetings';

        // Body with card-like design, black text, white background, and green button (#22c55e)
        $mail->Body = '
        <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h2 style="text-align: center; color: #22c55e; font-family: Arial, sans-serif;">Welcome to SECASA</h2>
            <p style="color: #000; text-align: center; font-family: Arial, sans-serif; line-height: 1.6;">
                Dear Jumuiya Member,<br><br>
                We are delighted to have you as part of the Saint Paul\'s Jumuiya, a community dedicated to spiritual growth, fellowship, and service.<br><br>
                Our meetings are held every Tuesday at exactly <strong>7:30 AM</strong> in <strong>Room TBH 5</strong>, located in the Tuition and Office Block (Block 1).<br><br>
                This is a wonderful opportunity to connect with fellow members, share in prayer, and grow together in faith.<br><br>
                We look forward to seeing you every Tuesday as we gather to reflect, learn, and encourage each other in our spiritual journey.<br><br>
                May this Jumuiya be a source of strength and inspiration to you.<br><br>
                Wishing you all the best and looking forward to having you join us!
            </p>
            <p style="color: #000; text-align: center; font-family: Arial, sans-serif;">Click the button below to visit our website and learn more:</p>
            <div style="text-align: center; margin-top: 20px;">
                <a href="http://petermutitu.netlify.app" style="background-color: #22c55e; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px; font-family: Arial, sans-serif;">
                    Visit SECASA Website
                </a>
            </div>
        </div>';

        // Send the email
        $mail->send();

        // Success message styled in the center of the screen with card-like appearance
        echo '
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div style="background-color: #fff; padding: 40px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <p style="color: #22c55e; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">Email has been sent successfully.</p>
            </div>
        </div>';

    } else {
        // Error message for when the user is not found in the database
        echo '<div style="color: red; text-align: center; font-family: Arial, sans-serif;">User not found in the database.</div>';
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
