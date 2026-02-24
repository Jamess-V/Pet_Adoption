<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'manager') {
    header("Location: ../user/login.php");
    exit();
}

$staff_id = isset($_GET['staff_id']) ? intval($_GET['staff_id']) : 0;

$staff_query = "SELECT * FROM Staff WHERE Staff_id = ?";
$stmt = $conn->prepare($staff_query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    echo "Staff member not found.";
    exit();
}

$staff = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $new_position = $_POST['position'];
    $update_query = "UPDATE Staff SET Position = ? WHERE Staff_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_position, $staff_id);
    $update_stmt->execute();
    header("Location: staffManagementDetail.php?staff_id=$staff_id&updated=true");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/staffManagementDetail.css">
</head>
<body>
    
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="manager.php">Home</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <span style="color: white; margin-right: 15px;">Manager: <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></span>
            <a href="../user/logout.php" class="btn btn-login">Logout</a>
        </div>
    </nav>

    
    <div class="staff-container">
        
        <aside class="sidebar">
            <button class="sidebar-btn" onclick="window.location.href='manager.php'">
                <svg viewBox="0 0 20 20">
                    <rect x="3" y="4" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="9" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="14" width="14" height="3" rx="0.5"/>
                </svg>
                Overall Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='petReport.php'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='adoptionApp.php'">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Application Status
            </button>
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2L3 6V10C3 14.5 6 18.5 10 19C14 18.5 17 14.5 17 10V6L10 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <polyline points="7,10 9,12 13,8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                Staff
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2C5.6 2 2 5.6 2 10C2 14.4 5.6 18 10 18C14.4 18 18 14.4 18 10C18 5.6 14.4 2 10 2ZM10 16C6.7 16 4 13.3 4 10C4 6.7 6.7 4 10 4C13.3 4 16 6.7 16 10C16 13.3 13.3 16 10 16Z"/>
                    <path d="M10 6C9.4 6 9 6.4 9 7V10.4L11.3 12.7C11.7 13.1 12.3 13.1 12.7 12.7C13.1 12.3 13.1 11.7 12.7 11.3L11 9.6V7C11 6.4 10.6 6 10 6Z"/>
                </svg>
                Medical & Vaccination
            </button>
        </aside>

        
        <main class="staff-detail-content">
            
            <div id="saveNotification" class="save-notification" <?php echo isset($_GET['updated']) ? "style='display:block;'" : ""; ?>>
                <svg viewBox="0 0 24 24" class="check-icon">
                    <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Role Updated Successfully!</span>
            </div>

            <div class="detail-header">
                <h2>Staff Details</h2>
                <button class="edit-btn" onclick="window.location.href='editStaffDetail.php?staff_id=<?php echo $staff_id; ?>'">Edit</button>
            </div>

            <div class="detail-container">
                <div class="detail-left">
                    
                    <div class="detail-section">
                        <h3 class="staff-name"><?php echo htmlspecialchars($staff['Name']); ?></h3>
                        <p class="staff-position"><?php echo htmlspecialchars($staff['Position'] ?? 'Staff Member'); ?></p>
                        <div class="basic-info">
                            <p><strong>Employee ID:</strong> EMP<?php echo str_pad($staff['Staff_id'], 3, '0', STR_PAD_LEFT); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($staff['Email']); ?></p>
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($staff['PhoneNumber'] ?? 'N/A'); ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo $staff['DateOfBirth'] ? date('F d, Y', strtotime($staff['DateOfBirth'])) : 'N/A'; ?></p>
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($staff['Address'] ?? 'N/A'); ?></p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Employment Information</h3>
                        <div class="section-content">
                            <p><strong>Department:</strong> <?php echo htmlspecialchars($staff['Department'] ?? 'Operations'); ?></p>
                            <p><strong>Employment Type:</strong> <?php echo htmlspecialchars($staff['EmploymentType'] ?? 'Full-time'); ?></p>
                            <p><strong>Join Date:</strong> <?php echo $staff['HireDate'] ? date('F d, Y', strtotime($staff['HireDate'])) : 'N/A'; ?></p>
                            <p><strong>Work Schedule:</strong> <?php echo htmlspecialchars($staff['WorkSchedule'] ?? 'Monday - Friday'); ?></p>
                            <p><strong>Salary:</strong> <?php echo isset($staff['Salary']) ? '$' . number_format($staff['Salary']) . '/year' : 'N/A'; ?></p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Emergency Contact</h3>
                        <div class="section-content">
                            <p><strong>Contact Name:</strong> <?php echo htmlspecialchars($staff['EmergencyContactName'] ?? 'N/A'); ?></p>
                            <p><strong>Relationship:</strong> <?php echo htmlspecialchars($staff['EmergencyContactRelation'] ?? 'N/A'); ?></p>
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($staff['EmergencyContactPhone'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="detail-right">
                    
                    <div class="role-card">
                        <h3 class="role-title">Role & Assignment</h3>
                        <form method="POST">
                            <div class="current-role">
                                <p><strong>Current Role:</strong></p>
                                <span class="role-badge manager"><?php echo htmlspecialchars($staff['Position'] ?? 'Staff'); ?></span>
                            </div>
                            <div class="role-options">
                                <label><strong>Assign Role:</strong></label>
                                <select name="position" class="role-select">
                                    <option value="Manager" <?php echo ($staff['Position'] === 'Manager') ? 'selected' : ''; ?>>Manager</option>
                                    <option value="Senior Staff" <?php echo ($staff['Position'] === 'Senior Staff') ? 'selected' : ''; ?>>Senior Staff</option>
                                    <option value="Staff" <?php echo ($staff['Position'] === 'Staff') ? 'selected' : ''; ?>>Staff</option>
                                    <option value="Volunteer" <?php echo ($staff['Position'] === 'Volunteer') ? 'selected' : ''; ?>>Volunteer</option>
                                    <option value="Veterinary Technician" <?php echo ($staff['Position'] === 'Veterinary Technician') ? 'selected' : ''; ?>>Veterinary Technician</option>
                                    <option value="Receptionist" <?php echo ($staff['Position'] === 'Receptionist') ? 'selected' : ''; ?>>Receptionist</option>
                                </select>
                                <button type="submit" name="update_role" class="assign-role-btn">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function assignRole() {
            const roleSelect = document.getElementById('roleSelect');
            const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
            const notification = document.getElementById('saveNotification');
            notification.classList.add('show');
            const roleBadge = document.querySelector('.role-badge');
            roleBadge.textContent = selectedRole;
            roleBadge.className = 'role-badge ' + roleSelect.value;
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>