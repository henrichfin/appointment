<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    if (!isset($data['id'])) {
        throw new Exception('Appointment ID is required');
    }

    $query = "UPDATE appointments SET 
        student_name = :studentName,
        requester_name = :requesterName,
        requester_type = :requesterType,
        appointment_date = :appointmentDate,
        appointment_time = :appointmentTime,
        reason = :reason,
        status = :status
        WHERE id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':studentName', $data['studentName']);
    $stmt->bindParam(':requesterName', $data['requesterName']);
    $stmt->bindParam(':requesterType', $data['requesterType']);
    $stmt->bindParam(':appointmentDate', $data['appointmentDate']);
    $stmt->bindParam(':appointmentTime', $data['appointmentTime']);
    $stmt->bindParam(':reason', $data['reason']);
    $stmt->bindParam(':status', $data['status']);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Appointment updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update appointment');
    }
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
