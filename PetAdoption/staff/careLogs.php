<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$staff_id = $_SESSION['user_id'];
$date_filter = isset($_GET['date']) ? $_GET['date'] : 'today';
$pet_filter = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;
$activity_filter = isset($_GET['activity']) ? $_GET['activity'] : 'all';

$sql = "SELECT cl.*, p.Pet_Name, p.Species
        FROM CareLogs cl
        JOIN Pets p ON cl.Pet_id = p.Pet_id
        WHERE 1=1 ";

if($date_filter === 'today') {
    $sql .= " AND DATE(cl.Activity_date) = CURDATE()";
}

if($pet_filter > 0) {
    $sql .= " AND cl.Pet_id = $pet_filter";
}

if($activity_filter !== 'all') {
    $sql .= " AND cl.Activity_type = '" . $conn->real_escape_string($activity_filter) . "'";
}

$sql .= " ORDER BY cl.Activity_date DESC, cl.Activity_time DESC, cl.Log_id DESC";
$result = $conn->query($sql);

$pets_sql = "SELECT Pet_id, Pet_Name FROM Pets ORDER BY Pet_Name";
$pets_result = $conn->query($pets_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Pet Care Logs - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/careLogs.css">
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
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <rect x="4" y="3" width="12" height="14" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="7" y1="7" x2="13" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="10" x2="13" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Daily Pet Care Logs
            </button>
            <button class="sidebar-btn" onclick="window.location.href='shelterAppointment.php'">
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

        <main class="care-logs-content">
            <h2>Daily Pet Care Logs</h2>

            <div class="filters">
                <button class="filter-btn <?php echo $date_filter === 'today' ? 'active' : ''; ?>" onclick="window.location.href='careLogs.php?date=today'">Today</button>
                <button class="filter-btn <?php echo $date_filter === 'all' ? 'active' : ''; ?>" onclick="window.location.href='careLogs.php?date=all'">All</button>
                <select class="filter-select" onchange="window.location.href='careLogs.php?date=<?php echo $date_filter; ?>&pet_id=' + this.value">
                    <option value="0">All Pets</option>
                    <?php while($pet = $pets_result->fetch_assoc()): ?>
                        <option value="<?php echo $pet['Pet_id']; ?>" <?php echo $pet_filter == $pet['Pet_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($pet['Pet_Name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <select class="filter-select" onchange="window.location.href='careLogs.php?date=<?php echo $date_filter; ?>&pet_id=<?php echo $pet_filter; ?>&activity=' + this.value">
                    <option value="all">All Activities</option>
                    <option value="Feeding" <?php echo $activity_filter === 'Feeding' ? 'selected' : ''; ?>>Feeding</option>
                    <option value="Medication" <?php echo $activity_filter === 'Medication' ? 'selected' : ''; ?>>Medication</option>
                    <option value="Exercise" <?php echo $activity_filter === 'Exercise' ? 'selected' : ''; ?>>Exercise</option>
                    <option value="Grooming" <?php echo $activity_filter === 'Grooming' ? 'selected' : ''; ?>>Grooming</option>
                    <option value="Training" <?php echo $activity_filter === 'Training' ? 'selected' : ''; ?>>Training</option>
                    <option value="Veterinary" <?php echo $activity_filter === 'Veterinary' ? 'selected' : ''; ?>>Veterinary</option>
                </select>
            </div>

            <div class="logs-list">
                <?php if($result->num_rows > 0): ?>
                    <?php while($log = $result->fetch_assoc()): ?>
                        <div class="log-card" onclick="window.location.href='careLogsDetail.php?log_id=<?php echo $log['Log_id']; ?>'" style="cursor: pointer;">
                            <div class="log-content">
                                <img src="../Image/<?php echo htmlspecialchars($log['Species']); ?>s/<?php echo strtolower($log['Species']); ?>01.jpg" 
                                     alt="<?php echo htmlspecialchars($log['Pet_Name']); ?>"
                                     class="pet-avatar"
                                     onerror="this.src='../Image/pet-placeholder.jpg'">
                                <div class="log-details">
                                    <h3><?php echo htmlspecialchars($log['Pet_Name']); ?></h3>
                                    <p class="log-time"><?php echo date('g:i A', strtotime($log['Activity_time'])); ?></p>
                                    <p class="log-description"><?php echo htmlspecialchars($log['Description']); ?></p>
                                </div>
                            </div>
                            <span class="activity-badge <?php echo strtolower($log['Activity_type']); ?>"><?php echo htmlspecialchars($log['Activity_type']); ?></span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="padding: 40px; text-align: center; color: #666;">
                        <p>No care logs found for the selected filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>