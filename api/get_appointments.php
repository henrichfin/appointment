<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Base query
    $query = "SELECT * FROM appointments WHERE 1=1";
    $params = [];
    
    // Apply status filter
    if (isset($_GET['status']) && $_GET['status'] !== 'all' && !empty($_GET['status'])) {
        $query .= " AND status = :status";
        $params[':status'] = $_GET['status'];
    }
    
    // Apply requester type filter
    if (isset($_GET['requester']) && $_GET['requester'] !== 'all' && !empty($_GET['requester'])) {
        $query .= " AND requester_type = :requester";
        $params[':requester'] = $_GET['requester'];
    }
    
    // Apply date range filters
    if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
        $query .= " AND DATE(appointment_date) >= :from_date";
        $params[':from_date'] = $_GET['from_date'];
    }
    
    if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
        $query .= " AND DATE(appointment_date) <= :to_date";
        $params[':to_date'] = $_GET['to_date'];
    }
    
    // Add sorting
    $query .= " ORDER BY appointment_date ASC, appointment_time ASC";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format dates and times for consistent display
    foreach ($appointments as &$appointment) {
        $appointment['appointment_date'] = date('Y-m-d', strtotime($appointment['appointment_date']));
        $appointment['appointment_time'] = date('H:i', strtotime($appointment['appointment_time']));
    }
    
    echo json_encode([
        'success' => true,
        'data' => $appointments
    ]);
} catch(PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching appointments. Please try again later.'
    ]);
} catch(Exception $e) {
    error_log("General Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred. Please try again later.'
    ]);
}
?>