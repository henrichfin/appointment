<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guidance Counselor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../appointment/assets/css/index.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <style>
        .sidebar {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            background-color: white;
            color: #212529;
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
        .calendar-container {
            margin-top: 20px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .calendar-container h3 {
            color: #2c3136;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        .fc-toolbar {
            margin-bottom: 25px !important;
        }
        .fc-toolbar-title {
            font-size: 1.4em !important;
            font-weight: 600 !important;
            color: #2c3136 !important;
        }
        .fc-button-primary {
            background-color: #343a40 !important;
            border-color: #343a40 !important;
            font-weight: 500 !important;
            padding: 8px 16px !important;
            text-transform: capitalize !important;
        }
        .fc-button-primary:hover {
            background-color: #23272b !important;
            border-color: #23272b !important;
        }
        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #23272b !important;
            border-color: #23272b !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.25) !important;
        }
        .fc-theme-standard td, 
        .fc-theme-standard th {
            border-color: #e9ecef !important;
        }
        .fc-col-header-cell {
            background-color: #f8f9fa !important;
            padding: 10px 0 !important;
        }
        .fc-col-header-cell-cushion {
            color: #495057 !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            padding: 8px !important;
        }
        .fc-daygrid-day-number {
            color: #495057 !important;
            text-decoration: none !important;
            padding: 8px !important;
            font-weight: 500 !important;
        }
        .fc-day-today {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        .fc-event {
            border: none !important;
            padding: 4px 8px !important;
            margin: 2px 0 !important;
            border-radius: 4px !important;
            font-size: 0.9em !important;
            font-weight: 500 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
        .fc-event-title {
            font-weight: 500 !important;
            padding: 2px 4px !important;
        }
        .fc-event.appointment-pending {
            background-color: #ffc107 !important;
            border-left: 4px solid #ffc107 !important;
            color: #212529 !important;
        }
        .fc-event.appointment-approved {
            background-color: #28a745 !important;
            border-left: 4px solid #28a745 !important;
            color: white !important;
        }
        .fc-event.appointment-completed {
            background-color: #17a2b8 !important;
            border-left: 4px solid #17a2b8 !important;
            color: white !important;
        }
        .fc-event.appointment-cancelled {
            background-color: #dc3545 !important;
            border-left: 4px solid #dc3545 !important;
            color: white !important;
        }
        .fc-button-group {
            margin-right: 10px !important;
        }
        .fc-button {
            text-transform: capitalize !important;
            font-weight: 500 !important;
        }
        .fc-event-details-modal .modal-content {
            border-radius: 8px;
            border: none;
        }
        .fc-event-details-modal .modal-header {
            background-color: #343a40;
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px 20px;
        }
        .fc-event-details-modal .modal-body {
            padding: 20px;
        }
        .fc-event-details-modal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
        }
        .fc-button-primary {
            background-color: #343a40 !important;
            border-color: #343a40 !important;
        }
        .fc-button-primary:hover {
            background-color: #23272b !important;
            border-color: #23272b !important;
        }
        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #23272b !important;
            border-color: #23272b !important;
        }
        .fc-daygrid-day-number {
            color: #495057;
            text-decoration: none;
        }
        .fc-day-today {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }
        /* New styles for dark themed modals */
        .modal-card {
            background-color: #2c3136;
            border: 1px solid #3f474e;
            border-radius: 5px;
        }
        .modal-card .card-subtitle {
            color: #adb5bd;
            font-weight: 500;
        }
        .modal-card .form-label {
            color: #e9ecef;
        }
        .modal-card .input-group-text {
            background-color: #3f474e;
            border-color: #495057;
            color: #adb5bd;
        }
        .modal-card .form-control,
        .modal-card .form-select {
            background-color: #343a40;
            border-color: #495057;
            color: #e9ecef;
        }
        .modal-card .form-control:focus,
        .modal-card .form-select:focus {
            background-color: #343a40;
            border-color: #0d6efd;
            color: #e9ecef;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .modal-card .form-control::placeholder {
            color: #6c757d;
        }
        .modal-card .form-check-label {
            color: #e9ecef;
        }
        .modal-dark-footer {
            background-color: #2c3136;
            border-top: 1px solid #3f474e;
        }
        .modal-dark-header {
            background-color: #2c3136;
            border-bottom: 1px solid #3f474e;
        }
        /* Enhanced Calendar Controls */
        .calendar-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .calendar-view-toggle {
            display: flex;
            gap: 5px;
            background: #fff;
            padding: 5px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .calendar-view-toggle .btn {
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            background-color: transparent;
            color: var(--primary-color) !important;
        }

        .calendar-view-toggle .btn:hover {
            background-color: rgba(var(--primary-rgb), .1) !important;
            color: var(--primary-color) !important;
        }

        .calendar-view-toggle .btn.active {
            background: var(--primary-color) !important;
            color: white !important;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .calendar-search {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .calendar-search .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .calendar-search .btn {
            padding: 8px 20px;
            font-weight: 500;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-search .btn i {
            font-size: 0.9rem;
        }

        /* Enhanced Calendar Buttons */
        .fc-button {
            text-transform: capitalize !important;
            font-weight: 500 !important;
            padding: 8px 16px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
        }

        .fc-button-primary {
            background-color: #343a40 !important;
            border-color: #343a40 !important;
        }

        .fc-button-primary:hover {
            background-color: #23272b !important;
            border-color: #23272b !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #23272b !important;
            border-color: #23272b !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.25) !important;
        }

        .fc-button-group {
            margin-right: 10px !important;
            display: flex !important;
            gap: 5px !important;
        }

        /* Enhanced Calendar Navigation Buttons */
        .fc-prev-button,
        .fc-next-button,
        .fc-today-button {
            /* Ensure these buttons use the primary color */
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fc-prev-button:hover,
        .fc-next-button:hover,
        .fc-today-button:hover {
            background-color: var(--primary-color-dark) !important;
            border-color: var(--primary-color-dark) !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .fc-prev-button:active,
        .fc-next-button:active,
        .fc-today-button:active {
            background-color: var(--primary-color-darker) !important;
            border-color: var(--primary-color-darker) !important;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fc-prev-button:focus,
        .fc-next-button:focus,
        .fc-today-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), .25) !important;
        }

        /* Ensure icons are visible with new background */
        .fc-prev-button .fc-icon,
        .fc-next-button .fc-icon {
            color: white !important;
        }

        /* Adjust padding for icon-only buttons if needed */
        .fc-prev-button .fc-icon-chevron-left,
        .fc-next-button .fc-icon-chevron-right {
             padding: 0 !important;
        }

        /* Calendar View Toggle Buttons */
        .calendar-view-toggle .btn {
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            background-color: transparent;
            color: var(--primary-color) !important; /* Primary text color for inactive */
        }

        .calendar-view-toggle .btn:hover {
             background-color: rgba(var(--primary-rgb), .1) !important; /* Light primary background on hover */
             color: var(--primary-color) !important;
        }

        .calendar-view-toggle .btn.active {
            background: var(--primary-color) !important;
            color: white !important;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Define CSS variables for primary colors if not already defined by Bootstrap */
        :root {
            --primary-color: #0d6efd; /* Default Bootstrap Blue */
            --primary-color-dark: #0b5ed7; /* Darker shade for hover */
            --primary-color-darker: #0a58ca; /* Even darker for active */
            --primary-rgb: 13, 110, 253; /* RGB for focus shadow */
        }
        .sidebar .nav-link.active {
            color: #212529 !important; /* Changed text color to dark for visibility */
            background-color: white; /* Set background color to white */
        }
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
        </ul>
    </div>

    <div class="main-content">
        <!-- Dashboard Header -->
        <!-- Removed the div containing the Add Appointment button -->
        <!--
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-alt me-2"></i>Appointments</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                <i class="fas fa-plus me-2"></i>Add Appointment
            </button>
        </div>
        -->

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
        <!-- Removed the entire Filter Panel card -->


        <!-- Appointments Table -->
        <div class="card appointment-table">
            <div class="card-body">
                <!-- Filter Panel Content -->
                 <div class="row g-3 mb-4">
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
                         <button class="btn btn-outline-secondary" id="reset-filters">
                             <i class="fas fa-redo me-2"></i>Reset
                         </button>
                     </div>
                 </div>
                <!-- Search Bar and Add Appointment Button -->
                <div class="row mb-3">
                    <div class="col-md-12 d-flex justify-content-end align-items-center">
                         <!-- Add Appointment Button -->
                         <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                             <i class="fas fa-plus me-2"></i>Add Appointment
                         </button>
                        <!-- Search Bar -->
                        <div class="input-group" style="max-width: 400px;">
                            <input type="text" class="form-control" id="appointment-search" placeholder="Search appointments...">
                            <button class="btn btn-primary" id="search-appointments">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </div>
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

        <!-- Calendar Section -->
        <div class="calendar-container">
            <h3><i class="fas fa-calendar me-2"></i>Appointment Calendar</h3>
            
            <!-- Calendar Controls -->
            <div class="calendar-controls">
                <div class="calendar-view-toggle">
                    <button class="btn active" data-view="dayGridMonth">
                        <i class="fas fa-calendar-alt me-1"></i>Month
                    </button>
                    <button class="btn" data-view="timeGridWeek">
                        <i class="fas fa-calendar-week me-1"></i>Week
                    </button>
                    <button class="btn" data-view="timeGridDay">
                        <i class="fas fa-calendar-day me-1"></i>Day
                    </button>
                </div>
                
                <div class="calendar-search">
                    <input type="date" class="form-control" id="calendar-date-search" placeholder="Search by date">
                    <button class="btn btn-primary" id="calendar-search-btn">
                        <i class="fas fa-search"></i>Search
                    </button>
                    <button class="btn btn-outline-secondary" id="calendar-reset-btn">
                        <i class="fas fa-redo"></i>Reset
                    </button>
                </div>
            </div>
            
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header modal-dark-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Schedule New Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointment-form" class="needs-validation" novalidate>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Student Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="studentName" class="form-label">Student Name *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" class="form-control" id="studentName" placeholder="Enter student's full name" required>
                                                    <div class="invalid-feedback">Please enter student name</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Requester Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="requesterName" class="form-label">Requester Name *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                    <input type="text" class="form-control" id="requesterName" placeholder="Enter requester's full name" required>
                                                    <div class="invalid-feedback">Please enter requester name</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="requesterType" class="form-label">Requester Type *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                    <select class="form-select" id="requesterType" required>
                                                        <option value="">Select Type</option>
                                                        <option value="parent">Parent/Guardian</option>
                                                        <option value="teacher">Teacher</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select requester type</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Appointment Details</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="appointmentDate" class="form-label">Appointment Date *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    <input type="date" class="form-control" id="appointmentDate" required>
                                                    <div class="invalid-feedback">Please select appointment date</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="appointmentTime" class="form-label">Appointment Time *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    <input type="time" class="form-control" id="appointmentTime" required>
                                                    <div class="invalid-feedback">Please select appointment time</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="appointmentReason" class="form-label">Reason for Appointment *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                    <textarea class="form-control" id="appointmentReason" rows="3" placeholder="Please provide a brief description of the appointment purpose" required></textarea>
                                                    <div class="invalid-feedback">Please enter appointment reason</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="autoApprove">
                                    <label class="form-check-label" for="autoApprove">
                                        <i class="fas fa-check-circle text-success me-1"></i>Auto-approve this appointment
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-dark-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="save-appointment">
                        <i class="fas fa-save me-1"></i>Schedule Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Appointment Modal -->
    <div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header modal-dark-header">
                    <h5 class="modal-title" id="editAppointmentModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-appointment-form" class="needs-validation" novalidate>
                        <input type="hidden" id="edit-appointment-id">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Student Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="edit-studentName" class="form-label">Student Name *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" class="form-control" id="edit-studentName" placeholder="Enter student's full name" required>
                                                    <div class="invalid-feedback">Please enter student name</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Requester Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="edit-requesterName" class="form-label">Requester Name *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                    <input type="text" class="form-control" id="edit-requesterName" placeholder="Enter requester's full name" required>
                                                    <div class="invalid-feedback">Please enter requester name</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit-requesterType" class="form-label">Requester Type *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                    <select class="form-select" id="edit-requesterType" required>
                                                        <option value="">Select Type</option>
                                                        <option value="parent">Parent/Guardian</option>
                                                        <option value="teacher">Teacher</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select requester type</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card modal-card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3">Appointment Details</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="edit-appointmentDate" class="form-label">Appointment Date *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    <input type="date" class="form-control" id="edit-appointmentDate" required>
                                                    <div class="invalid-feedback">Please select appointment date</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit-appointmentTime" class="form-label">Appointment Time *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    <input type="time" class="form-control" id="edit-appointmentTime" required>
                                                    <div class="invalid-feedback">Please select appointment time</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="edit-appointmentReason" class="form-label">Reason for Appointment *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                    <textarea class="form-control" id="edit-appointmentReason" rows="3" placeholder="Please provide a brief description of the appointment purpose" required></textarea>
                                                    <div class="invalid-feedback">Please enter appointment reason</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit-status" class="form-label">Appointment Status *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                                    <select class="form-select" id="edit-status" required>
                                                        <option value="pending">Pending</option>
                                                        <option value="approved">Approved</option>
                                                        <option value="completed">Completed</option>
                                                        <option value="cancelled">Cancelled</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select appointment status</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-dark-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="update-appointment">
                        <i class="fas fa-save me-1"></i>Update Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
    $(document).ready(function() {
        // Initialize FullCalendar with enhanced options
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '' // Remove default view buttons as we're using custom ones
            },
            themeSystem: 'bootstrap5',
            height: 'auto',
            events: [], // Will be populated with appointments
            eventClick: function(info) {
                // Show appointment details in a modal with enhanced styling
                Swal.fire({
                    title: '<h4 class="mb-3">Appointment Details</h4>',
                    html: `
                        <div class="text-start">
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Student Information</h6>
                                <p class="mb-0"><strong>Name:</strong> ${info.event.extendedProps.studentName}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Requester Information</h6>
                                <p class="mb-0"><strong>Name:</strong> ${info.event.extendedProps.requesterName}</p>
                                <p class="mb-0"><strong>Type:</strong> ${info.event.extendedProps.requesterType}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Appointment Details</h6>
                                <p class="mb-0"><strong>Reason:</strong> ${info.event.extendedProps.reason}</p>
                                <p class="mb-0"><strong>Status:</strong> <span class="badge-status badge-${info.event.extendedProps.status}">${info.event.extendedProps.status}</span></p>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#343a40',
                    customClass: {
                        container: 'fc-event-details-modal'
                    }
                });
            },
            eventDidMount: function(info) {
                // Enhanced tooltips for events
                $(info.el).tooltip({
                    title: `
                        <div class="text-start">
                            <strong>${info.event.title}</strong><br>
                            ${info.event.extendedProps.requesterName} (${info.event.extendedProps.requesterType})<br>
                            Status: ${info.event.extendedProps.status}
                        </div>
                    `,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    html: true
                });
            },
            dayMaxEvents: true,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            // Enhanced calendar options
            nowIndicator: true,
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Monday to Friday
                startTime: '08:00',
                endTime: '17:00'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '17:00:00',
            allDaySlot: false,
            slotDuration: '00:30:00',
            slotLabelInterval: '01:00',
            expandRows: true,
            stickyHeaderDates: true,
            dayMaxEventRows: true,
            buttonText: {
                today: 'Today'
            }
        });
        calendar.render();

        // Handle custom view toggle buttons
        $('.calendar-view-toggle .btn').click(function() {
            const view = $(this).data('view');
            $('.calendar-view-toggle .btn').removeClass('active');
            $(this).addClass('active');
            calendar.changeView(view);
        });

        // Handle date search
        $('#calendar-search-btn').click(function() {
            const searchDate = $('#calendar-date-search').val();
            if (searchDate) {
                calendar.gotoDate(searchDate);
                // Highlight the searched date
                $('.fc-day').removeClass('fc-day-highlight');
                $(`.fc-day[data-date="${searchDate}"]`).addClass('fc-day-highlight');
            }
        });

        // Handle search reset
        $('#calendar-reset-btn').click(function() {
            $('#calendar-date-search').val('');
            $('.fc-day').removeClass('fc-day-highlight');
            calendar.today();
        });

        // Add enter key support for date search
        $('#calendar-date-search').keypress(function(e) {
            if (e.which == 13) {
                $('#calendar-search-btn').click();
            }
        });

        // Add highlight style for searched date
        $('<style>')
            .text(`
                .fc-day-highlight {
                    background-color: rgba(13, 110, 253, 0.1) !important;
                    box-shadow: inset 0 0 0 2px #0d6efd !important;
                }
            `)
            .appendTo('head');

        // Function to update calendar events
        function updateCalendarEvents(appointments) {
            var events = appointments.map(function(appointment) {
                return {
                    title: appointment.student_name,
                    start: appointment.appointment_date + 'T' + appointment.appointment_time,
                    className: 'appointment-' + appointment.status.toLowerCase(),
                    extendedProps: {
                        studentName: appointment.student_name,
                        requesterName: appointment.requester_name,
                        requesterType: appointment.requester_type,
                        reason: appointment.reason,
                        status: appointment.status
                    }
                };
            });
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        }

        // Load appointments when page loads
        loadAppointments();
        
        // Set today's date as default for date inputs
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('appointmentDate').min = today;
        document.getElementById('from-date-filter').value = today;

        // Form validation for add appointment
        const appointmentForm = document.getElementById('appointment-form');
        
        // Handle save appointment button click with validation
        $('#save-appointment').on('click', function() {
            if (!appointmentForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                appointmentForm.classList.add('was-validated');
                return;
            }

            // Collect form data
            var formData = {
                studentName: $('#studentName').val().trim(),
                requesterName: $('#requesterName').val().trim(),
                requesterType: $('#requesterType').val(),
                appointmentDate: $('#appointmentDate').val(),
                appointmentTime: $('#appointmentTime').val(),
                reason: $('#appointmentReason').val().trim(),
                status: $('#autoApprove').is(':checked') ? 'approved' : 'pending'
            };

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
                        // Clear the form and validation
                        appointmentForm.reset();
                        appointmentForm.classList.remove('was-validated');
                        // Refresh the appointments table and calendar
                        loadAppointments();
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Appointment added successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Error adding appointment'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error adding appointment. Please try again.'
                    });
                }
            });
        });

        // Clear form and validation when modal is closed
        $('#addAppointmentModal').on('hidden.bs.modal', function () {
            appointmentForm.reset();
            appointmentForm.classList.remove('was-validated');
        });

        // Set minimum date for appointment date input
        $('#appointmentDate').attr('min', today);

        // Load appointments from server
        function loadAppointments() {
            // Get filter values
            const filters = {
                status: $('#status-filter').val(),
                requester: $('#requester-filter').val(),
                from_date: $('#from-date-filter').val(),
                to_date: $('#to-date-filter').val()
            };

            // Validate date filters
            if (filters.from_date && filters.to_date) {
                const fromDate = new Date(filters.from_date);
                const toDate = new Date(filters.to_date);
                
                if (fromDate > toDate) {
                    alert('From date cannot be later than To date');
                    return;
                }
            }

            $.ajax({
                url: 'api/get_appointments.php',
                type: 'GET',
                data: filters,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        renderAppointments(data.data);
                        updateStats(data.data);
                        updateCalendarEvents(data.data);
                    } else {
                        console.error(data.message);
                        $('#appointments-body').html('<tr><td colspan="7" class="text-center py-4 text-danger">Error loading appointments</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#appointments-body').html('<tr><td colspan="7" class="text-center py-4 text-danger">Error loading appointments</td></tr>');
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

        // Update the editAppointment function
        function editAppointment(id) {
            // Find the appointment data from the existing table row
            const row = $(`button[data-id="${id}"]`).closest('tr');
            const appointment = {
                id: id,
                student_name: row.find('td:eq(0)').text(),
                requester_name: row.find('td:eq(1)').text().split(' (')[0],
                requester_type: row.find('td:eq(1)').text().match(/\((.*?)\)/)[1],
                appointment_date: row.find('td:eq(2)').text(),
                appointment_time: row.find('td:eq(3)').text(),
                reason: row.find('td:eq(4)').text(),
                status: row.find('.badge-status').text().toLowerCase()
            };
            
            // Populate the edit form
            $('#edit-appointment-id').val(appointment.id);
            $('#edit-studentName').val(appointment.student_name);
            $('#edit-requesterName').val(appointment.requester_name);
            $('#edit-requesterType').val(appointment.requester_type);
            $('#edit-appointmentDate').val(appointment.appointment_date);
            $('#edit-appointmentTime').val(appointment.appointment_time);
            $('#edit-appointmentReason').val(appointment.reason);
            $('#edit-status').val(appointment.status);
            
            // Show the modal
            $('#editAppointmentModal').modal('show');
        }

        // Handle update appointment button click
        $('#update-appointment').on('click', function() {
            const formData = {
                id: $('#edit-appointment-id').val(),
                studentName: $('#edit-studentName').val().trim(),
                requesterName: $('#edit-requesterName').val().trim(),
                requesterType: $('#edit-requesterType').val(),
                appointmentDate: $('#edit-appointmentDate').val(),
                appointmentTime: $('#edit-appointmentTime').val(),
                reason: $('#edit-appointmentReason').val().trim(),
                status: $('#edit-status').val()
            };

            // Validate required fields
            if (!formData.studentName || !formData.requesterName || !formData.requesterType ||
                !formData.appointmentDate || !formData.appointmentTime || !formData.reason) {
                alert('Please fill in all required fields.');
                return;
            }

            // Send AJAX request to update appointment
            $.ajax({
                url: 'api/update_appointment.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    if (response.success) {
                        // Close the modal
                        $('#editAppointmentModal').modal('hide');
                        
                        // Find the row for the updated appointment and update its content
                        const updatedApp = formData; // Assuming formData has the latest data
                        const row = $(`#appointments-body tr button[data-id="${updatedApp.id}"]`).closest('tr');
                        
                        if (row.length) {
                            row.find('td:eq(0)').text(updatedApp.studentName);
                            row.find('td:eq(1)').text(`${updatedApp.requesterName} (${updatedApp.requesterType})`);
                            row.find('td:eq(2)').text(formatDate(updatedApp.appointmentDate));
                            row.find('td:eq(3)').text(formatTime(updatedApp.appointmentTime));
                            row.find('td:eq(4)').text(updatedApp.reason);
                            
                            // Update status badge
                            const statusBadge = row.find('td:eq(5) .badge-status');
                            statusBadge.removeClass().addClass(`badge-status badge-${updatedApp.status}`).text(capitalizeFirstLetter(updatedApp.status));
                        }

                        // Update stats and calendar (these functions should ideally handle single updates too, but refreshing them for now)
                        loadAppointments(); // Re-fetch data to ensure stats and calendar are in sync

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Appointment updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Error updating appointment'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error updating appointment. Please try again.'
                    });
                }
            });
        });

        // Clear form when modal is closed
        $('#editAppointmentModal').on('hidden.bs.modal', function () {
            $('#edit-appointment-form')[0].reset();
        });

        // Delete appointment function
        function deleteAppointment(id) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                $.ajax({
                    url: 'api/delete_appointment.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Refresh the appointments table and calendar
                            loadAppointments();
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Appointment deleted successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Error deleting appointment'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error deleting appointment. Please try again.'
                        });
                    }
                });
            }
        }

        // Handle apply filters button click
        $('#apply-filters').on('click', function() {
            loadAppointments();
        });

        // Handle reset filters button click
        $('#reset-filters').on('click', function() {
            // Reset all filter values
            $('#status-filter').val('all');
            $('#requester-filter').val('all');
            $('#from-date-filter').val(today);
            $('#to-date-filter').val('');
            
            // Reload appointments with reset filters
            loadAppointments();
        });

        // Add change event listeners to filters for real-time updates
        $('#status-filter, #requester-filter').on('change', function() {
            loadAppointments();
        });

        // Add change event listeners to date filters
        $('#from-date-filter, #to-date-filter').on('change', function() {
            const fromDate = $('#from-date-filter').val();
            const toDate = $('#to-date-filter').val();
            
            if (fromDate && toDate) {
                const from = new Date(fromDate);
                const to = new Date(toDate);
                
                if (from > to) {
                    alert('From date cannot be later than To date');
                    $(this).val(''); // Clear the invalid date
                    return;
                }
            }
            
            loadAppointments();
        });

        // Search functionality
        $('#search-appointments').on('click', function() {
            const searchTerm = $('#appointment-search').val().toLowerCase();
            const rows = $('#appointments-body tr');
            
            rows.each(function() {
                const text = $(this).text().toLowerCase();
                if (text.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Add event listener for Enter key in search input
        $('#appointment-search').on('keypress', function(e) {
            if (e.key === 'Enter') {
                $('#search-appointments').click();
            }
        });

        // Clear search when input is cleared
        $('#appointment-search').on('input', function() {
            if ($(this).val() === '') {
                $('#appointments-body tr').show();
            }
        });
    });
    </script>
</body>
</html>