<?php
require_once 'C:/xampp/htdocs/appointment/config/database.php';

// Get appointments
$query = "SELECT * FROM appointments ORDER BY appointment_date, appointment_time";
$result = $conn->query($query);

if ($result) {
    $appointments = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error retrieving appointments: " . $conn->error);
}
?>

<!-- Display appointments table -->
<?php if (!empty($appointments)): ?>
    <?php foreach($appointments as $appointment): ?>
        <tr>
            <td><?= htmlspecialchars($appointment['student_name']) ?></td>
            <td><?= htmlspecialchars($appointment['requester_name']) ?></td>
            <td><?= ucfirst(htmlspecialchars($appointment['requester_type'])) ?></td>
            <td><?= date('M d, Y', strtotime($appointment['appointment_date'])) ?></td>
            <td><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
            <td><?= htmlspecialchars($appointment['reason']) ?></td>
            <td>
                <span class="status-badge <?= $appointment['status'] ?>">
                    <?= ucfirst($appointment['status']) ?>
                </span>
            </td>
            <td class="actions">
                <a href="view.php?id=<?= $appointment['id'] ?>" class="action-btn" title="View Details">
                    <i class="fas fa-eye"></i>
                </a>
                <?php if ($appointment['status'] === 'pending'): ?>
                    <button type="button" 
                            class="btn btn-sm btn-info edit-btn" 
                            data-id="<?= $appointment['id'] ?>"
                            data-bs-toggle="modal" 
                            data-bs-target="#editAppointmentModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <a href="cancel.php?id=<?= $appointment['id'] ?>" class="action-btn" title="Cancel" 
                       onclick="return confirm('Are you sure you want to cancel this appointment?')">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" style="text-align: center;">No appointments found</td>
    </tr>
<?php endif; ?>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAppointmentForm">
                    <input type="hidden" id="edit_appointment_id">
                    
                    <div class="mb-3">
                        <label for="edit_student_name">Student Name:</label>
                        <input type="text" class="form-control" id="edit_student_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_requester_name">Requester Name:</label>
                        <input type="text" class="form-control" id="edit_requester_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_requester_type">Requester Type:</label>
                        <select class="form-control" id="edit_requester_type" required>
                            <option value="parent">Parent</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_appointment_date">Appointment Date:</label>
                        <input type="date" class="form-control" id="edit_appointment_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_appointment_time">Appointment Time:</label>
                        <input type="time" class="form-control" id="edit_appointment_time" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_reason">Reason:</label>
                        <textarea class="form-control" id="edit_reason" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status">Status:</label>
                        <select class="form-control" id="edit_status" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateAppointment()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editAppointment(id, student_name, requester_name, requester_type, date, time, reason, status) {
    // Fill the form with the appointment data
    document.getElementById('edit_appointment_id').value = id;
    document.getElementById('edit_student_name').value = student_name;
    document.getElementById('edit_requester_name').value = requester_name;
    document.getElementById('edit_requester_type').value = requester_type;
    document.getElementById('edit_appointment_date').value = date;
    document.getElementById('edit_appointment_time').value = time;
    document.getElementById('edit_reason').value = reason;
    document.getElementById('edit_status').value = status;

    // Show the modal
    var modal = new bootstrap.Modal(document.getElementById('editAppointmentModal'));
    modal.show();
}

function updateAppointment() {
    // Get form data
    var formData = {
        id: document.getElementById('edit_appointment_id').value,
        student_name: document.getElementById('edit_student_name').value,
        requester_name: document.getElementById('edit_requester_name').value,
        requester_type: document.getElementById('edit_requester_type').value,
        appointment_date: document.getElementById('edit_appointment_date').value,
        appointment_time: document.getElementById('edit_appointment_time').value,
        reason: document.getElementById('edit_reason').value,
        status: document.getElementById('edit_status').value
    };

    // Send AJAX request
    fetch('api/update_appointment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Appointment updated successfully!');
            location.reload(); // Refresh the page
        } else {
            alert('Error updating appointment: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error updating appointment');
        console.error('Error:', error);
    });
}
</script> 