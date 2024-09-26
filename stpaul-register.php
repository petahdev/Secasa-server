<?php
include 'connect.php';

$errors = [];
$success = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use isset() to ensure the fields are set before accessing them
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $second_name = isset($_POST['second_name']) ? trim($_POST['second_name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $course_done = isset($_POST['course_done']) ? trim($_POST['course_done']) : '';
    $year_of_study = isset($_POST['year_of_study']) ? trim($_POST['year_of_study']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $repeat_password = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : '';
    $image = null;

    // Validate form inputs
    if (empty($first_name)) $errors['first_name'] = "First name is required";
    if (empty($second_name)) $errors['second_name'] = "Second name is required";
    if (empty($surname)) $errors['surname'] = "Surname is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format";
    if (empty($phone_number)) $errors['phone_number'] = "Phone number is required";
    if (empty($course_done)) $errors['course_done'] = "Course is required";
    if (empty($year_of_study)) $errors['year_of_study'] = "Year of study is required";
    if (strlen($password) < 6) $errors['password'] = "Password must be at least 6 characters";
    if ($password !== $repeat_password) $errors['repeat_password'] = "Passwords do not match";

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    }

    // Check for duplicate email
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT email FROM stfrancis WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['duplicate_email'] = "This email is already registered.";
        } else {
            // If no errors, insert into database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Encrypt password
            $sql = "INSERT INTO stfrancis (first_name, second_name, surname, email, phone_number, course_done, year_of_study, password, image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($sql);
            $insertStmt->bind_param("sssssssss", $first_name, $second_name, $surname, $email, $phone_number, $course_done, $year_of_study, $hashed_password, $image);

            if ($insertStmt->execute()) {
                header("Location: success-stfrancis.php"); // Redirect to a success page
                exit;
            } else {
                $errors['database'] = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

// Close connection
$conn->close();

// If there are errors, display them within the form
if (!empty($errors)) {
    echo "<div style='background-color: white; color: red; text-align: center; font-size: 24px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); margin: auto; width: 80%; max-width: 600px; position: relative; top: 50%; transform: translateY(-50%);'>
            <style>
                @media (max-width: 600px) {
                    div {
                        font-size: 28px; /* Larger text on mobile */
                    }
                }
            </style>";
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . "<br>";
    }
    echo "</div>";
    echo "<script>
            setTimeout(function() {
                window.location.href = 'stpauls.php';
            }, 4000);
          </script>";
    exit; // Ensure no further output is sent
}
?>
