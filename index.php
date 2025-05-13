<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guidance Counselor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../appointment/assets/css/index.css">
    <style>
        .sidebar {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #343a40;
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .stat-card {
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-pending { background-color: #ffc107; color: #212529; }
        .badge-approved { background-color: #28a745; }
        .badge-completed { background-color: #17a2b8; }
        .badge-cancelled { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>SGRMS</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-users"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link text-danger" href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-alt me-2"></i>Appointments</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                <i class="fas fa-plus me-2"></i>Add Appointment
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card bg-primary">
                    <h5 class="card-title">Pending</h5>
                    <h3 class="card-text" id="pending-count">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success">
                    <h5 class="card-title">Approved</h5>
                    <h3 class="card-text" id="approved-count">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning">
                    <h5 class="card-title">Today</h5>
                    <h3 class="card-text" id="today-count">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info">
                    <h5 class="card-title">Total</h5>
                    <h3 class="card-text" id="total-count">0</h3>
                </div>
            </div>
        </div>

        <!-- Filter Panel -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status-filter">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Requester</label>
                        <select class="form-select" id="requester-filter">
                            <option value="all">All Requesters</option>
                            <option value="parent">Parent</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" id="from-date-filter">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" id="to-date-filter">
                    </div>
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary me-2" id="apply-filters">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <button class="btn btn-outline-secondary" id="reset-filters">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="card appointment-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="appointments-table">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Requester</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointments-body">
                            <!-- Appointments will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointment-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="studentName" class="form-label">Student Name *</label>
                                <input type="text" class="form-control" id="studentName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="requesterName" class="form-label">Requester Name *</label>
                                <input type="text" class="form-control" id="requesterName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="requesterType" class="form-label">Requester Type *</label>
                                <select class="form-select" id="requesterType" required>
                                    <option value="">Select Type</option>
                                    <option value="parent">Parent</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="appointmentDate" class="form-label">Appointment Date *</label>
                                <input type="date" class="form-control" id="appointmentDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="appointmentTime" class="form-label">Appointment Time *</label>
                                <input type="time" class="form-control" id="appointmentTime" required>
                            </div>
                            <div class="col-12">
                                <label for="appointmentReason" class="form-label">Reason *</label>
                                <textarea class="form-control" id="appointmentReason" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="autoApprove">
                                    <label class="form-check-label" for="autoApprove">
                                        Auto-approve this appointment
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-appointment">Save Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Load appointments when page loads
        loadAppointments();
        
        // Set today's date as default for date inputs
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('appointmentDate').min = today;
        document.getElementById('from-date-filter').value = today;

        // Handle save appointment button click
        $('#save-appointment').on('click', function() {
            // Collect form data
            var formData = {
                studentName: $('#studentName').val(),
                requesterName: $('#requesterName').val(),
                requesterType: $('#requesterType').val(),
                appointmentDate: $('#appointmentDate').val(),
                appointmentTime: $('#appointmentTime').val(),
                reason: $('#appointmentReason').val(),
                status: $('#autoApprove').is(':checked') ? 'approved' : 'pending'
            };

            // Validate required fields
            if (!formData.studentName || !formData.requesterName || !formData.requesterType ||
                !formData.appointmentDate || !formData.appointmentTime || !formData.reason) {
                alert('Please fill in all required fields.');
                return;
            }

            // Send AJAX request to add appointment
            $.ajax({
                url: 'api/add_appointment.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    if (response.success) {
                        // Close the modal
                        $('#addAppointmentModal').modal('hide');
                        // Clear the form
                        $('#appointment-form')[0].reset();
                        // Refresh the appointments table
                        loadAppointments();
                        // Show success message
                        alert('Appointment added successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error adding appointment. Please check console for details.');
                }
            });
        });

        // Load appointments from server
        function loadAppointments() {
            $.ajax({
                url: 'api/get_appointments.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        renderAppointments(data.data);
                        updateStats(data.data);
                    } else {
                        console.error(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Render appointments table
        function renderAppointments(appointments = []) {
            const appointmentsBody = $('#appointments-body');
            appointmentsBody.empty();
            
            if (appointments.length === 0) {
                appointmentsBody.append(`
                    <tr>
                        <td colspan="7" class="text-center py-4">No appointments found</td>
                    </tr>
                `);
                return;
            }
            
            appointments.forEach(app => {
                const row = `
                    <tr>
                        <td>${app.student_name}</td>
                        <td>${app.requester_name} (${app.requester_type})</td>
                        <td>${formatDate(app.appointment_date)}</td>
                        <td>${formatTime(app.appointment_time)}</td>
                        <td>${app.reason}</td>
                        <td><span class="badge-status badge-${app.status}">${capitalizeFirstLetter(app.status)}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1 edit-btn" data-id="${app.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${app.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                appointmentsBody.append(row);
            });
            
            // Add event listeners to action buttons
            $('.edit-btn').click(function() {
                const appId = $(this).data('id');
                editAppointment(appId);
            });
            
            $('.delete-btn').click(function() {
                const appId = $(this).data('id');
                deleteAppointment(appId);
            });
        }

        // Update statistics counters
        function updateStats(appointments = []) {
            const today = new Date().toISOString().split('T')[0];
            
            $('#pending-count').text(appointments.filter(a => a.status === 'pending').length);
            $('#approved-count').text(appointments.filter(a => a.status === 'approved').length);
            $('#today-count').text(appointments.filter(a => a.appointment_date === today).length);
            $('#total-count').text(appointments.length);
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
                $.ajax({
                    url: 'api/delete_appointment.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: id }),
                    success: function(response) {
                        if (response.success) {
                            loadAppointments();
                            alert('Appointment deleted successfully');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error deleting appointment');
                    }
                });
            }
        }
    });
    </script>
</body>
</html>