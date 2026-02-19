<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$staff_id = $_SESSION['user_id'];

$date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$pet_filter = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;

$sql = "SELECT sa.*, p.Pet_Name, p.Species
        FROM ShelterAppointment sa
        JOIN Pets p ON sa.Pet_id = p.Pet_id
        WHERE 1=1 ";

if($date_filter === 'today') {
    $sql .= " AND DATE(sa.AppointmentDateTime) = CURDATE()";
} elseif($date_filter === 'week') {
    $sql .= " AND WEEK(sa.AppointmentDateTime) = WEEK(CURDATE())";
} elseif($date_filter === 'month') {
    $sql .= " AND MONTH(sa.AppointmentDateTime) = MONTH(CURDATE())";
}

if($status_filter) {
    $sql .= " AND sa.Status = '" . $conn->real_escape_string($status_filter) . "'";
}

if($pet_filter > 0) {
    $sql .= " AND sa.Pet_id = $pet_filter";
}

$sql .= " ORDER BY sa.AppointmentDateTime DESC";
$result = $conn->query($sql);

$pets_sql = "SELECT Pet_id, Pet_Name, Species FROM Pets ORDER BY Pet_Name";
$pets_result = $conn->query($pets_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet & Greet Appointments - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/shelterAppointment.css">
</head>
<body>
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="staff.php">Home</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <a href="../user/logout.php" class="btn btn-login">Logout</a>
        </div>
    </nav>

    <div class="staff-container">
        <aside class="sidebar">
            <button class="sidebar-btn" onclick="window.location.href='staff.php'">
                <svg viewBox="0 0 20 20">
                    <rect x="3" y="3" width="6" height="6" rx="1"/>
                    <rect x="11" y="3" width="6" height="6" rx="1"/>
                    <rect x="3" y="11" width="6" height="6" rx="1"/>
                    <rect x="11" y="11" width="6" height="6" rx="1"/>
                </svg>
                Dashboard
            </button>
            <button class="sidebar-btn" onclick="window.location.href='petManagement.php'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Management
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2C5.6 2 2 5.6 2 10C2 14.4 5.6 18 10 18C14.4 18 18 14.4 18 10C18 5.6 14.4 2 10 2ZM10 16C6.7 16 4 13.3 4 10C4 6.7 6.7 4 10 4C13.3 4 16 6.7 16 10C16 13.3 13.3 16 10 16Z"/>
                    <path d="M10 6C9.4 6 9 6.4 9 7V10.4L11.3 12.7C11.7 13.1 12.3 13.1 12.7 12.7C13.1 12.3 13.1 11.7 12.7 11.3L11 9.6V7C11 6.4 10.6 6 10 6Z"/>
                </svg>
                Medical Records
            </button>
            <button class="sidebar-btn" onclick="window.location.href='careLogs.php'">
                <svg viewBox="0 0 20 20">
                    <rect x="4" y="3" width="12" height="14" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="7" y1="7" x2="13" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="10" x2="13" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Daily Pet Care Logs
            </button>
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M10 9C11.7 9 13 7.7 13 6C13 4.3 11.7 3 10 3C8.3 3 7 4.3 7 6C7 7.7 8.3 9 10 9Z"/>
                    <path d="M10 11C6.7 11 4 13.7 4 17H16C16 13.7 13.3 11 10 11Z"/>
                </svg>
                Meet & Greet
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Applications
            </button>
        </aside>

        <main class="appointments-content">
            <h1>Meet & Greet Appointments</h1>

            <div class="filter-section">
                <div class="filter-dropdown">
                    <select id="dateFilter" onchange="updateFilters()">
                        <option value="">All Dates</option>
                        <option value="today" <?php echo $date_filter === 'today' ? 'selected' : ''; ?>>Today</option>
                        <option value="week" <?php echo $date_filter === 'week' ? 'selected' : ''; ?>>This Week</option>
                        <option value="month" <?php echo $date_filter === 'month' ? 'selected' : ''; ?>>This Month</option>
                    </select>
                </div>
                <div class="filter-dropdown">
                    <select id="statusFilter" onchange="updateFilters()">
                        <option value="">All Status</option>
                        <option value="Confirmed" <?php echo $status_filter === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Cancelled" <?php echo $status_filter === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="Completed" <?php echo $status_filter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>
                <div class="filter-dropdown">
                    <select id="petFilter" onchange="updateFilters()">
                        <option value="0">All Pets</option>
                        <?php while($pet = $pets_result->fetch_assoc()): ?>
                            <option value="<?php echo $pet['Pet_id']; ?>" <?php echo $pet_filter == $pet['Pet_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pet['Pet_Name']) . ' (' . htmlspecialchars($pet['Species']) . ')'; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="appointments-list">
                <?php if($result->num_rows > 0): ?>
                    <?php while($appointment = $result->fetch_assoc()): ?>
                        <div class="appointment-card">
                            <div class="appointment-info">
                                <img src="../Image/<?php echo htmlspecialchars($appointment['Species']); ?>s/<?php echo strtolower($appointment['Species']); ?>01.jpg"
                                     alt="<?php echo htmlspecialchars($appointment['Pet_Name']); ?>"
                                     class="pet-avatar"
                                     onerror="this.src='../Image/pet-placeholder.jpg'">
                                <div class="appointment-details">
                                    <h3><?php echo htmlspecialchars($appointment['Pet_Name']); ?></h3>
                                    <p class="owner-name"><?php echo htmlspecialchars($appointment['VisitorName']); ?></p>
                                    <div class="appointment-datetime">
                                        <svg viewBox="0 0 16 16" class="calendar-icon">
                                            <rect x="2" y="3" width="12" height="11" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                            <line x1="2" y1="6" x2="14" y2="6" stroke="currentColor" stroke-width="1.5"/>
                                            <line x1="5" y1="1" x2="5" y2="4" stroke="currentColor" stroke-width="1.5"/>
                                            <line x1="11" y1="1" x2="11" y2="4" stroke="currentColor" stroke-width="1.5"/>
                                        </svg>
                                        <span><?php echo date('M d, Y • g:i A', strtotime($appointment['AppointmentDateTime'])); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appointment-actions">
                                <span class="status-badge <?php echo strtolower($appointment['Status']); ?>"><?php echo htmlspecialchars($appointment['Status']); ?></span>
                                <button class="view-appointment-btn" onclick="window.location.href='shelterAppointmentDetail.php?appointment_id=<?php echo $appointment['Appointment_id']; ?>'">View Appointment</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="padding: 40px; text-align: center; color: #666;">
                        <p>No appointments found for the selected filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function updateFilters() {
            const dateFilter = document.getElementById('dateFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const petFilter = document.getElementById('petFilter').value;
            window.location.href = 'shelterAppointment.php?date_filter=' + dateFilter + '&status=' + statusFilter + '&pet_id=' + petFilter;
        }
    </script>
</body>
</html>
