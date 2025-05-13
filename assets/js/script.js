// Load appointments when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadAppointments();
    updateStats();
    
    // Set today's date as default for date inputs
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointmentDate').min = today;
    document.getElementById('from-date-filter').value = today;
});

// Load appointments from server
function loadAppointments() {
    fetch('api/get_appointments.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderAppointments(data.data);
                updateStats(data.data);
            } else {
                console.error(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Render appointments table
function renderAppointments(appointments = []) {
    const appointmentsBody = document.getElementById('appointments-body');
    appointmentsBody.innerHTML = '';
    
    if (appointments.length === 0) {
        appointmentsBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">No appointments found</td>
            </tr>
        `;
        return;
    }
    
    appointments.forEach(app => {
        addAppointmentRow(app);
    });
}

// Add a single appointment row to the table
function addAppointmentRow(appointment) {
    const appointmentsBody = document.getElementById('appointments-body');
    
    // Remove "no appointments" message if it exists
    const emptyRow = appointmentsBody.querySelector('tr td[colspan="7"]');
    if (emptyRow) {
        emptyRow.parentNode.remove();
    }
    
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${appointment.student_name}</td>
        <td>${appointment.requester_name} (${appointment.requester_type})</td>
        <td>${formatDate(appointment.appointment_date)}</td>
        <td>${formatTime(appointment.appointment_time)}</td>
        <td>${appointment.reason}</td>
        <td><span class="badge-status badge-${appointment.status}">${capitalizeFirstLetter(appointment.status)}</span></td>
        <td>
            <button class="btn btn-sm btn-outline-primary me-1 edit-btn" data-id="${appointment.id}">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${appointment.id}">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    
    // Add to the top of the table
    if (appointmentsBody.firstChild) {
        appointmentsBody.insertBefore(row, appointmentsBody.firstChild);
    } else {
        appointmentsBody.appendChild(row);
    }
    
    // Add event listeners to the new buttons
    row.querySelector('.edit-btn').addEventListener('click', function() {
        editAppointment(appointment.id);
    });
    
    row.querySelector('.delete-btn').addEventListener('click', function() {
        deleteAppointment(appointment.id);
    });
}

// Save new appointment
document.getElementById('save-appointment').addEventListener('click', function() {
    const form = document.getElementById('appointment-form');
    
    // Validate required fields
    const requiredFields = ['studentName', 'requesterName', 'requesterType', 
                          'appointmentDate', 'appointmentTime', 'reason'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            isValid = false;
        } else {
            element.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields');
        return;
    }

    const appointmentData = {
        studentName: document.getElementById('studentName').value,
        requesterName: document.getElementById('requesterName').value,
        requesterType: document.getElementById('requesterType').value,
        appointmentDate: document.getElementById('appointmentDate').value,
        appointmentTime: document.getElementById('appointmentTime').value,
        reason: document.getElementById('appointmentReason').value,
        status: document.getElementById('autoApprove').checked ? 'approved' : 'pending'
    };

    fetch('api/add_appointment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(appointmentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success handling
            form.reset();
            $('#addAppointmentModal').modal('hide'); // If using Bootstrap modal
            loadAppointments(); // Refresh the list
            alert('Appointment saved successfully!');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to save appointment');
    });
});

// Update statistics counters
function updateStats() {
    // Get current appointments from the table
    const rows = document.querySelectorAll('#appointments-body tr');
    const today = new Date().toISOString().split('T')[0];
    
    let pendingCount = 0;
    let approvedCount = 0;
    let todayCount = 0;
    
    rows.forEach(row => {
        if (!row.querySelector('td')) return; // Skip empty row
        
        const status = row.querySelector('.badge-status').textContent.toLowerCase();
        const date = row.querySelector('td:nth-child(3)').textContent;
        
        if (status === 'pending') pendingCount++;
        if (status === 'approved') approvedCount++;
        if (date.includes(today.substring(5, 7))) todayCount++; // Simple month check
    });
    
    document.getElementById('pending-count').textContent = pendingCount;
    document.getElementById('approved-count').textContent = approvedCount;
    document.getElementById('today-count').textContent = todayCount;
    document.getElementById('total-count').textContent = rows.length;
}

// Helper functions
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Placeholder functions for edit and delete
function editAppointment(id) {
    alert('Edit functionality would open a modal to edit appointment with ID: ' + id);
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        fetch('api/delete_appointment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                document.querySelector(`tr button[data-id="${id}"]`).closest('tr').remove();
                updateStats();
                alert('Appointment deleted successfully');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete appointment');
        });
    }
}