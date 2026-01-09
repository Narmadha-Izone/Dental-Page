<?php
// Set response type
header('Content-Type: application/json');

// Allow CORS (if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once "db_conn.php";

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input.']);
    exit;
}

// Validate fields
$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$phone = trim($input['phone'] ?? '');
$course = trim($input['course'] ?? '');
$message = trim($input['message'] ?? '');

if (!$name || !$email || !$message) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name, email, and message are required.']);
    exit;
}

// Insert safely using prepared statements
$stmt = $conn->prepare("INSERT INTO contact_messages (uname, uemail, uphone, course, cmessage) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed.']);
    exit;
}
$stmt->bind_param("sssss", $name, $email, $phone, $course, $message);

if ($stmt->execute()) {
    // Send email
    $to = 'narmadhamuruganandham@gmail.com';
    $subject = "New Contact Form Submission from $name";
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nCourse: $course\nMessage: $message";
    $headers = "From: $email";

    @mail($to, $subject, $body, $headers);

    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
}

$stmt->close();
$conn->close();
?>
