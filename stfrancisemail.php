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

// Function to send email
function sendEmail($email, $subject, $body) {
    $mail = new PHPMailer(true);
    $admin_email = "mutitupeter76@gmail.com";

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $admin_email;
        $mail->Password   = 'fbwj edrn alpz alur';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($admin_email, 'SECASA');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Check if form is submitted
if (isset($_POST['subscribe'])) {
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = $_POST['password'];

    // Insert user into database (you might want to adjust this as per your actual table structure)
    $stmt = $conn->prepare("INSERT INTO stfrancis (email, phone_number, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $phoneNumber, $password);
    if ($stmt->execute()) {
        // Send welcome email
        $welcomeSubject = 'Welcome to SECASA!';
        $welcomeBody = "
        <h1>Welcome to SECASA!</h1>
        <p>Thank you for subscribing! You will now receive important updates about jumuiya meetings and activities. Stay tuned!</p>
        <p>We look forward to seeing you at our upcoming events.</p>
        ";
        sendEmail($email, $welcomeSubject, $welcomeBody);

        echo "<div style='color: green;'>Subscription successful! Welcome email sent.</div>";
    } else {
        echo "<div style='color: red;'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Function to send reminder emails every Tuesday at 7 AM and 6 PM
function sendWeeklyReminders() {
    global $conn;
    $sql = "SELECT email FROM stfrancis";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $email = $row['email'];

        // Send Tuesday morning reminder
        $morningSubject = 'Reminder: Jumuiya Meeting Today at 7:30 PM';
        $morningBody = "
        <h1>Good Morning!</h1>
        <p>This is a friendly reminder to join us for the jumuiya meeting today at 7:30 PM. Your participation is important for our community.</p>
        <p>We hope to see you there!</p>
        ";
        sendEmail($email, $morningSubject, $morningBody);

        // Send Tuesday evening reminder
        $eveningSubject = 'Final Reminder: Jumuiya Meeting Tonight at 7:30 PM';
        $eveningBody = "
        <h1>Good Evening!</h1>
        <p>This is a final reminder for the jumuiya meeting happening tonight at 7:30 PM. Don't miss out on the opportunity to connect with fellow members.</p>
        <p>Your presence makes a difference!</p>
        ";
        sendEmail($email, $eveningSubject, $eveningBody);
    }
}

// Check if it's Tuesday and the right time to send reminders
if (date('N') == 2) { // 2 means Tuesday
    $currentHour = date('H');
    if ($currentHour == 7 || $currentHour == 18) { // 7 AM or 6 PM
        sendWeeklyReminders();
    }
}

$conn->close();
?>
