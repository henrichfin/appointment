<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    $query = "INSERT INTO appointments (
        student_name, 
        requester_name, 
        requester_type, 
        appointment_date, 
        appointment_time, 
        reason, 
        status
    ) VALUES (
        :studentName, 
        :requesterName, 
        :requesterType, 
        :appointmentDate, 
        :appointmentTime, 
        :reason, 
        :status
    )";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':studentName', $data['studentName']);
    $stmt->bindParam(':requesterName', $data['requesterName']);
    $stmt->bindParam(':requesterType', $data['requesterType']);
    $stmt->bindParam(':appointmentDate', $data['appointmentDate']);
    $stmt->bindParam(':appointmentTime', $data['appointmentTime']);
    $stmt->bindParam(':reason', $data['reason']);
    $stmt->bindParam(':status', $data['status']);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Appointment added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add appointment']);
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>