<?php
session_start(); // Start the session

// Database connection
$conn = new mysqli("localhost", "root", "", "secasa");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email is set
if (!isset($_POST['email'])) {
    $_SESSION['error_message'] = "Access Denied. Email not set.";
    header("Location: error.php");
    exit;
}

// Get email from POST request
$email = $_POST['email'];
$_SESSION['email'] = $email; // Store email in session for future use, but do not display it

// Check if the user is an admin across all saint tables
function isAdmin($email, $conn) {
    // List of tables to check
    $tables = ['stpauls', 'stmonica', 'standrew', 'stfrancis'];

    // Loop through each table and check for admin status
    foreach ($tables as $table) {
        $sql = "SELECT admin, all_admin FROM $table WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['all_admin'] == 1) {
                return 'all_admin'; // Return if user is an all_admin
            } elseif ($row['admin'] == 1) {
                return $table; // Return the specific table name if user is admin
            }
        }
    }

    return null; // No admin found
}

// Validate if user is an all_admin or a specific saint's admin
$adminStatus = isAdmin($email, $conn);

if ($adminStatus) {
    if ($adminStatus == 'all_admin') {
        // User is an all_admin, redirect to all admin message sending page
        header("Location: admin.php");
        exit;
    } else {
        // User is an admin for a specific saint, redirect to saint-specific send page
        header("Location: " . $adminStatus . "_admin_send.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Access Denied. You are not an admin.";
    header("Location: error.php"); // Redirect to error page
    exit;
}

$conn->close();
?>
