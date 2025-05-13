<?php
session_start();
require_once 'config/database.php';

// Validate user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST['student_name']) || empty($_POST['requester_name']) || 
        empty($_POST['requester_type']) || empty($_POST['appointment_date']) || 
        empty($_POST['appointment_time']) || empty($_POST['reason'])) {
        header("Location: appointments.php?message=missing_fields");
        exit();
    }

    // Validate date
    $date = DateTime::createFromFormat('Y-m-d', $_POST['appointment_date']);
    if (!$date || $date->format('Y-m-d') !== $_POST['appointment_date']) {
        header("Location: appointments.php?message=invalid_date");
        exit();
    }

    // Insert appointment
    $stmt = $conn->prepare("INSERT INTO appointments (student_name, requester_name, requester_type, 
                           appointment_date, appointment_time, reason, status) 
                           VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    
    $stmt->bind_param("ssssss", 
        $_POST['student_name'],
        $_POST['requester_name'],
        $_POST['requester_type'],
        $_POST['appointment_date'],
        $_POST['appointment_time'],
        $_POST['reason']
    );
    
    if ($stmt->execute()) {
        // Log to appointment_history
        $appointment_id = $stmt->insert_id;
        $action = 'created';
        $stmt2 = $conn->prepare("INSERT INTO appointment_history (appointment_id, action, new_date, new_time) 
                                VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $appointment_id, $action, $_POST['appointment_date'], $_POST['appointment_time']);
        $stmt2->execute();
        
        header("Location: appointments.php?message=success");
    } else {
        header("Location: appointments.php?message=error");
    }
    exit();
}

mysqli_close($conn);
?> 