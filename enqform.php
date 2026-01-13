<?php
require_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Assuming $conn is your mysqli connection

    $name     = $_POST['enqName'] ?? '';
    $email    = $_POST['enqEmail'] ?? '';
    $phone    = $_POST['enqPh'] ?? '';
    $enqCourse   = $_POST['enqCourse'] ?? '';
    $duration = $_POST['enqDur'] ?? '';
    $message  = $_POST['enqMsg'] ?? '';

    // SQL query to get max(slno)+1
    $sql = "
        select 
        case 
            when max(slno) is NULL then concat(YEAR(curdate()), '001')
            else max(slno) + 1
        end slno
        from enquiry_messages;
    ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $slno = $row['slno'];
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // fetch course
    $sql = "
        select 
            course
        from 
            course_details
        where course_detail='$enqCourse';
    ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $course = $row['course'];
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Prepare statement safely
    $stmt = $conn->prepare("INSERT INTO enquiry_messages (slno, enqname, enqmail, enqph, course, enqcourse, enqduration, enqmsg)  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo "Prepare statement failed: " . $conn->error;
        exit;
    }

    // Bind parameters: s = string, i = integer (all are strings here)
    $stmt->bind_param("isssssss",  $slno, $name, $email, $phone, $course, $enqCourse, $duration, $message);

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
