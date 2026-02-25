<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$log_id = isset($_GET['log_id']) ? intval($_GET['log_id']) : 0;

if(!$log_id) {
    header("Location: careLogs.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activity_date = $_POST['activity_date'];
    $activity_time = $_POST['activity_time'];
    $activity_type = $_POST['activity_type'];
    $description = $_POST['description'];
    $staff_id = intval($_POST['staff_id']);
    
    $update_sql = "UPDATE CareLogs SET
                   Activity_date = ?,
                   Activity_time = ?,
                   Activity_type = ?,
                   Description = ?,
                   Staff_id = ?
                   WHERE Log_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssii", $activity_date, $activity_time, $activity_type, $description, $staff_id, $log_id);
    
    if($stmt->execute()) {
        $_SESSION['success_message'] = "Care log updated successfully!";
        header("Location: careLogsDetail.php?log_id=" . $log_id);
        exit();
    } else {
        $error_message = "Error updating care log: " . $conn->error;
    }
}

$sql = "SELECT cl.*, p.Pet_Name, p.Species, p.Breed, s.Name as Staff_Name
        FROM CareLogs cl
        JOIN Pets p ON cl.Pet_id = p.Pet_id
        LEFT JOIN Staff s ON cl.Staff_id = s.Staff_id
        WHERE cl.Log_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $log_id);
$stmt->execute();
$log = $stmt->get_result()->fetch_assoc();

if(!$log) {
    header("Location: careLogs.php");
    exit();
}
$staff_sql = "SELECT Staff_id, Name FROM Staff ORDER BY Name";
$staff_result = $conn->query($staff_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Care Log - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/careLogsDetail.css">
    <link rel="stylesheet" href="../css/editCareLogsDetail.css">
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
            <span style="color: #333; margin-right: 15px;">Staff: <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Staff'); ?></span>
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
            <button class="sidebar-btn active" onclick="window.location.href='careLogs.php'">
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
            <button class="sidebar-btn" onclick="window.location.href='AppView.php'">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Applications
            </button>
        </aside>

        <main class="care-log-detail-content">
            <div class="detail-header">
                <button class="back-btn" onclick="window.location.href='careLogsDetail.php?log_id=<?php echo $log_id; ?>'">
                    <svg viewBox="0 0 20 20">
                        <path d="M15 10H5M5 10L10 5M5 10L10 15" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Back to Detail
                </button>
                <h2>Edit Care Log</h2>
            </div>

            <?php if(isset($error_message)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="detail-container">
                <div class="pet-header-section">
                    <img src="../Image/<?php echo strtolower($log['Species']); ?>s/<?php echo strtolower($log['Species']); ?>01.jpg" 
                         alt="<?php echo htmlspecialchars($log['Pet_Name']); ?>"
                         class="pet-detail-avatar"
                         onerror="this.src='../Image/pet-placeholder.jpg'">
                    <div class="pet-header-info">
                        <h3><?php echo htmlspecialchars($log['Pet_Name']); ?></h3>
                        <p class="pet-type"><?php echo htmlspecialchars($log['Species']) . ' • ' . htmlspecialchars($log['Breed']); ?></p>
                    </div>
                </div>

                <form method="POST" class="edit-log-form">
                    <div class="log-info-card">
                        <div class="info-row">
                            <div class="info-label">Date</div>
                            <div class="info-value">
                                <input type="date" name="activity_date" value="<?php echo htmlspecialchars($log['Activity_date']); ?>" required class="form-input">
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Time</div>
                            <div class="info-value">
                                <input type="time" name="activity_time" value="<?php echo htmlspecialchars($log['Activity_time']); ?>" required class="form-input">
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Activity Type</div>
                            <div class="info-value">
                                <select name="activity_type" required class="form-input">
                                    <option value="Feeding" <?php echo $log['Activity_type'] === 'Feeding' ? 'selected' : ''; ?>>Feeding</option>
                                    <option value="Exercise" <?php echo $log['Activity_type'] === 'Exercise' ? 'selected' : ''; ?>>Exercise</option>
                                    <option value="Grooming" <?php echo $log['Activity_type'] === 'Grooming' ? 'selected' : ''; ?>>Grooming</option>
                                    <option value="Medical" <?php echo $log['Activity_type'] === 'Medical' ? 'selected' : ''; ?>>Medical</option>
                                    <option value="Training" <?php echo $log['Activity_type'] === 'Training' ? 'selected' : ''; ?>>Training</option>
                                    <option value="Socialization" <?php echo $log['Activity_type'] === 'Socialization' ? 'selected' : ''; ?>>Socialization</option>
                                    <option value="Cleaning" <?php echo $log['Activity_type'] === 'Cleaning' ? 'selected' : ''; ?>>Cleaning</option>
                                    <option value="Other" <?php echo $log['Activity_type'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Staff Member</div>
                            <div class="info-value">
                                <select name="staff_id" required class="form-input">
                                    <?php
                                    if($staff_result && $staff_result->num_rows > 0):
                                        while($staff = $staff_result->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo $staff['Staff_id']; ?>" <?php echo $log['Staff_id'] == $staff['Staff_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($staff['Name']); ?>
                                        </option>
                                    <?php
                                        endwhile;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="log-description-card">
                        <h4>Description</h4>
                        <textarea name="description" rows="6" required class="form-textarea"><?php echo htmlspecialchars($log['Description']); ?></textarea>
                    </div>

                    <div class="log-actions">
                        <button type="button" class="action-btn secondary" onclick="window.location.href='careLogsDetail.php?log_id=<?php echo $log_id; ?>'">Cancel</button>
                        <button type="submit" class="action-btn primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
