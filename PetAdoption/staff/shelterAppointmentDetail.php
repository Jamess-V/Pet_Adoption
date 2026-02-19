<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;
$message = '';
if(!$appointment_id) {
    header("Location: shelterAppointment.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $notes = trim($_POST['notes'] ?? '');
    
    $sql = "UPDATE ShelterAppointment SET Status = ?";
    if($notes) {
        $sql .= ", Note = ?";
    }
    $sql .= " WHERE Appointment_id = ?";
    
    $stmt = $conn->prepare($sql);
    if($notes) {
        $stmt->bind_param("ssi", $new_status, $notes, $appointment_id);
    } else {
        $stmt->bind_param("si", $new_status, $appointment_id);
    }
    
    if($stmt->execute()) {
        $message = 'Appointment updated successfully!';
    }
}

$sql = "SELECT sa.*, s.Shelter_name
        FROM ShelterAppointment sa
        LEFT JOIN Shelter s ON sa.Shelter_id = s.Shelter_id
        WHERE sa.Appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$appointment = $stmt->get_result()->fetch_assoc();

if(!$appointment) {
    header("Location: shelterAppointment.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet & Greet Appointment Detail - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/shelterAppointmentDetail.css">
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
            <button class="sidebar-btn">
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

        <main class="appointment-detail-content">
            <h1>Meet & Greet Appointment Detail</h1>
            
            <?php if($message): ?>
                <div style="padding: 15px; margin-bottom: 20px; background: #d4edda; color: #155724; border-radius: 5px;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="shelterAppointmentDetail.php?appointment_id=<?php echo $appointment_id; ?>">
            <div class="detail-card">
                <div class="detail-section">
                    <label>Visitor Name</label>
                    <p><?php echo htmlspecialchars($appointment['User_name']); ?></p>
                </div>
                <div class="detail-section">
                    <label>Contact Email</label>
                    <p><?php echo htmlspecialchars($appointment['User_email']); ?></p>
                </div>
                <div class="detail-section">
                    <label>Contact Phone</label>
                    <p><?php echo htmlspecialchars($appointment['User_phone'] ?? 'N/A'); ?></p>
                </div>
                <?php if($appointment['Shelter_name']): ?>
                <div class="detail-section">
                    <label>Shelter</label>
                    <p><?php echo htmlspecialchars($appointment['Shelter_name']); ?></p>
                </div>
                <?php endif; ?>
                <div class="detail-section">
                    <label>Requested Date & Time</label>
                    <div class="datetime-display">
                        <svg viewBox="0 0 16 16" class="calendar-icon-small">
                            <rect x="2" y="3" width="12" height="11" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <line x1="2" y1="6" x2="14" y2="6" stroke="currentColor" stroke-width="1.5"/>
                            <line x1="5" y1="1" x2="5" y2="4" stroke="currentColor" stroke-width="1.5"/>
                            <line x1="11" y1="1" x2="11" y2="4" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <span><?php echo date('M d, Y', strtotime($appointment['Appointment_date'])) . ' • ' . date('g:i A', strtotime($appointment['Appointment_time'])); ?></span>
                    </div>
                </div>
                <div class="detail-section">
                    <label>Status</label>
                    <select name="status" class="status-select">
                        <option value="Pending" <?php echo $appointment['Status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Confirmed" <?php echo $appointment['Status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Completed" <?php echo $appointment['Status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?php echo $appointment['Status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="notes-section">
                <label>Staff Notes</label>
                <textarea name="notes" placeholder="Enter notes about the shelter appointment..." rows="6"><?php echo htmlspecialchars($appointment['Note'] ?? ''); ?></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="detail-action-btn primary">Save Changes</button>
                <button type="button" class="detail-action-btn secondary" onclick="window.location.href='shelterAppointment.php'">Back to List</button>
            </div>
            </form>
        </main>
    </div>
</body>
</html>
