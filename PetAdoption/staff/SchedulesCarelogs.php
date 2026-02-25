<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$staff_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_id = intval($_POST['pet_id']);
    $activity_date = $_POST['activity_date'];
    $activity_time = $_POST['activity_time'];
    $activity_type = $_POST['activity_type'];
    $description = $_POST['description'];
    $assigned_staff_id = intval($_POST['staff_id']);
    
    $insert_sql = "INSERT INTO CareLogs (Pet_id, Staff_id, Activity_date, Activity_time, Activity_type, Description) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iissss", $pet_id, $assigned_staff_id, $activity_date, $activity_time, $activity_type, $description);
    
    if($stmt->execute()) {
        $success_message = "Care task scheduled successfully!";
    } else {
        $error_message = "Error scheduling care task: " . $conn->error;
    }
}

$pets_sql = "SELECT Pet_id, Pet_Name, Species, Breed FROM Pets ORDER BY Pet_Name";
$pets_result = $conn->query($pets_sql);

if (!$pets_result) {
    die("Pets query failed: " . $conn->error);
}

$staff_sql = "SELECT Staff_id, Name FROM Staff ORDER BY Name";
$staff_result = $conn->query($staff_sql);

if (!$staff_result) {
    die("Staff query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Care Task - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/careLogsDetail.css">
    <link rel="stylesheet" href="../css/schedulesCarelogs.css">
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
                <button class="back-btn" onclick="window.location.href='staff.php'">
                    <svg viewBox="0 0 20 20">
                        <path d="M15 10H5M5 10L10 5M5 10L10 15" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Back to Dashboard
                </button>
                <h2>Schedule Care Task</h2>
            </div>

            <?php if($success_message): ?>
                <div class="success-alert">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if($error_message): ?>
                <div class="error-alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="schedule-form-container">
                <form method="POST">
                    <div class="form-card">
                        <h3 class="form-section-title">Care Task Details</h3>
                        
                        <div class="form-row">
                            <label class="form-label required-indicator">Select Pet</label>
                            <select name="pet_id" required class="form-input-field" id="pet-select">
                                    <option value="">-- Select a Pet --</option>
                                    <?php
                                    if($pets_result && $pets_result->num_rows > 0):
                                        while($pet = $pets_result->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo $pet['Pet_id']; ?>">
                                            <?php echo htmlspecialchars($pet['Pet_Name']) . ' (' . htmlspecialchars($pet['Species']) . ' - ' . htmlspecialchars($pet['Breed']) . ')'; ?>
                                        </option>
                                    <?php
                                        endwhile;
                                    endif;
                                    ?>
                                </select>
                        </div>

                        <div class="form-row">
                            <label class="form-label required-indicator">Date</label>
                            <input type="date" name="activity_date" value="<?php echo date('Y-m-d'); ?>" required class="form-input-field" min="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-row">
                            <label class="form-label required-indicator">Time</label>
                            <input type="time" name="activity_time" value="<?php echo date('H:i'); ?>" required class="form-input-field">
                        </div>

                        <div class="form-row">
                            <label class="form-label required-indicator">Activity Type</label>
                            <select name="activity_type" required class="form-input-field">
                                    <option value="">-- Select Activity --</option>
                                    <option value="Feeding">Feeding</option>
                                    <option value="Exercise">Exercise</option>
                                    <option value="Grooming">Grooming</option>
                                    <option value="Medical">Medical</option>
                                    <option value="Training">Training</option>
                                    <option value="Socialization">Socialization</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Other">Other</option>
                                </select>
                        </div>

                        <div class="form-row">
                            <label class="form-label required-indicator">Assign to Staff</label>
                            <select name="staff_id" required class="form-input-field">
                                    <?php
                                    if($staff_result && $staff_result->num_rows > 0):
                                        while($staff = $staff_result->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo $staff['Staff_id']; ?>" <?php echo $staff_id == $staff['Staff_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($staff['Name']); ?>
                                        </option>
                                    <?php
                                        endwhile;
                                    endif;
                                    ?>
                                </select>
                        </div>
                    </div>

                    <div class="form-card">
                        <h3 class="form-section-title">Task Description</h3>
                        <div class="form-row">
                            <label class="form-label required-indicator">Description</label>
                            <textarea name="description" rows="6" required class="form-textarea-field" placeholder="Enter detailed description of the care task..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions-bar">
                        <button type="button" class="btn-cancel" onclick="window.location.href='staff.php'">Cancel</button>
                        <button type="submit" class="btn-submit">Schedule Task</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
