<?php
// Set response type

require_once "db_conn.php";

// Get POST data
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');
$selectedCourse = trim($_POST['course'] ?? '');

// Split course and course_detail safely
$course = '';
$course_detail = '';

if ($selectedCourse) {
    list($course, $course_detail) = preg_split('/\s*-\s*/', $selectedCourse, 2);
}

// Validate required fields
if (!$name || !$email || !$message || !$course || !$course_detail) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'All required fields must be filled.'
    ]);
    exit;
}

// Insert into database using prepared statement
$stmt = $conn->prepare(
    "INSERT INTO contact_messages (uname, uemail, uphone, course, course_detail, cmessage) VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Prepare statement failed.'
    ]);
    exit;
}

$stmt->bind_param(
    "ssssss",
    $name,
    $email,
    $phone,
    $course,
    $course_detail,
    $message
);

if ($stmt->execute()) {
    echo  'Message saved successfully!';
    echo  '<script>window.location.href="index.php"</script>';
} else {
    http_response_code(500);
    echo 'Database insert failed.';
}

$stmt->close();
$conn->close();
