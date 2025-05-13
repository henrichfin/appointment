<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Base query
    $query = "SELECT * FROM appointments WHERE 1=1";
    $params = [];
    
    // Apply filters if provided
    if (isset($_GET['status']) && $_GET['status'] !== 'all') {
        $query .= " AND status = :status";
        $params[':status'] = $_GET['status'];
    }
    
    if (isset($_GET['requester']) && $_GET['requester'] !== 'all') {
        $query .= " AND requester_type = :requester";
        $params[':requester'] = $_GET['requester'];
    }
    
    if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
        $query .= " AND appointment_date >= :from_date";
        $params[':from_date'] = $_GET['from_date'];
    }
    
    if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
        $query .= " AND appointment_date <= :to_date";
        $params[':to_date'] = $_GET['to_date'];
    }
    
    $query .= " ORDER BY appointment_date, appointment_time";
    
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $appointments
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching appointments: ' . $e->getMessage()
    ]);
}
?>