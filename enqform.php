<?php
require_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Assuming $conn is your mysqli connection

    $name     = $_POST['enqName'] ?? '';
    $email    = $_POST['enqEmail'] ?? '';
    $phone    = $_POST['enqPh'] ?? '';
    $course   = $_POST['enqCourse'] ?? '';
    $duration = $_POST['enqDur'] ?? '';
    $message  = $_POST['enqMsg'] ?? '';

    // Prepare statement safely
    $stmt = $conn->prepare("INSERT INTO enquiry_messages (enqname, enqmail, enqph, enqcourse, enqduration, enqmsg)  VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo "Prepare statement failed: " . $conn->error;
        exit;
    }

    // Bind parameters: s = string, i = integer (all are strings here)
    $stmt->bind_param("ssssss", $name, $email, $phone, $course, $duration, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Enquiry Submitted Successfully')</script>";
         echo "<script>window.location.href='index.html'</script>";
    } else {
       echo "<script>alert('Enquiry not Submitted ')</script>";
    }

    $stmt->close();
    $conn->close();
}

?>
