<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Check if ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('Appointment ID is required');
    }

    $id = $_POST['id'];

    // Prepare and execute delete query
    $query = "DELETE FROM appointments WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Check if any row was affected
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Appointment deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No appointment found with the provided ID'
        ]);
    }
} catch(Exception $e) {
    error_log("Delete Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting appointment: ' . $e->getMessage()
    ]);
}
?> 