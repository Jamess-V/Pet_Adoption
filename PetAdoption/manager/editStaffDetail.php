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

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $employment_type = $_POST['employmentType'];
    $hire_date = $_POST['joinDate'];
    $work_schedule = $_POST['workSchedule'];
    $salary = $_POST['salary'];
    $emergency_name = $_POST['emergencyName'];
    $emergency_relation = $_POST['relationship'];
    $emergency_phone = $_POST['emergencyPhone'];
    
    $update_query = "UPDATE Staff SET Name=?, Email=?, PhoneNumber=?, DateOfBirth=?, Gender=?, Address=?, 
                     Position=?, Department=?, EmploymentType=?, HireDate=?, WorkSchedule=?, Salary=?, 
                     EmergencyContactName=?, EmergencyContactRelation=?, EmergencyContactPhone=? WHERE Staff_id=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssssssssssssi", $name, $email, $phone, $dob, $gender, $address, 
                              $position, $department, $employment_type, $hire_date, $work_schedule, $salary,
                              $emergency_name, $emergency_relation, $emergency_phone, $staff_id);
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
    <title>Edit Staff Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/editStaffDetail.css">
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

        
        <main class="edit-staff-content">
            
            <div id="saveNotification" class="save-notification">
                <svg viewBox="0 0 24 24" class="check-icon">
                    <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Changes Saved</span>
            </div>
            <div class="edit-header">
                <h2>Edit Staff Details</h2>
                <div class="edit-actions">
                    <button class="cancel-btn" onclick="window.location.href='staffManagementDetail.php?staff_id=<?php echo $staff_id; ?>'">Cancel</button>
                    <button class="save-btn" onclick="document.getElementById('editForm').submit()">Save Changes</button>
                </div>
            </div>
            <form method="POST" class="edit-form" id="editForm">
                <div class="form-container">
                    <div class="form-section">
                        <h3 class="section-title">Personal Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($staff['Name']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="employeeId">Employee ID</label>
                                <input type="text" id="employeeId" name="employeeId" value="EMP<?php echo str_pad($staff['Staff_id'], 3, '0', STR_PAD_LEFT); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['Email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['PhoneNumber'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="<?php echo $staff['DateOfBirth'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value="Female" <?php echo ($staff['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Male" <?php echo ($staff['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Other" <?php echo ($staff['Gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($staff['Address'] ?? ''); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">Employment Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($staff['Position'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id="department" name="department" required>
                                    <option value="Operations" <?php echo ($staff['Department'] === 'Operations') ? 'selected' : ''; ?>>Operations</option>
                                    <option value="Animal Care" <?php echo ($staff['Department'] === 'Animal Care') ? 'selected' : ''; ?>>Animal Care</option>
                                    <option value="Administration" <?php echo ($staff['Department'] === 'Administration') ? 'selected' : ''; ?>>Administration</option>
                                    <option value="Veterinary" <?php echo ($staff['Department'] === 'Veterinary') ? 'selected' : ''; ?>>Veterinary</option>
                                    <option value="Volunteer" <?php echo ($staff['Department'] === 'Volunteer') ? 'selected' : ''; ?>>Volunteer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employmentType">Employment Type</label>
                                <select id="employmentType" name="employmentType" required>
                                    <option value="Full-time" <?php echo ($staff['EmploymentType'] === 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                                    <option value="Part-time" <?php echo ($staff['EmploymentType'] === 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                                    <option value="Contract" <?php echo ($staff['EmploymentType'] === 'Contract') ? 'selected' : ''; ?>>Contract</option>
                                    <option value="Volunteer" <?php echo ($staff['EmploymentType'] === 'Volunteer') ? 'selected' : ''; ?>>Volunteer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="joinDate">Join Date</label>
                                <input type="date" id="joinDate" name="joinDate" value="<?php echo $staff['HireDate'] ?? ''; ?>" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="workSchedule">Work Schedule</label>
                                <input type="text" id="workSchedule" name="workSchedule" value="<?php echo htmlspecialchars($staff['WorkSchedule'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="salary">Salary (per year)</label>
                                <input type="text" id="salary" name="salary" value="<?php echo htmlspecialchars($staff['Salary'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" disabled>
                                    <option value="Manager" <?php echo ($staff['Position'] === 'Manager') ? 'selected' : ''; ?>>Manager</option>
                                    <option value="Senior Staff" <?php echo ($staff['Position'] === 'Senior Staff') ? 'selected' : ''; ?>>Senior Staff</option>
                                    <option value="Staff" <?php echo ($staff['Position'] === 'Staff') ? 'selected' : ''; ?>>Staff</option>
                                    <option value="Volunteer" <?php echo ($staff['Position'] === 'Volunteer') ? 'selected' : ''; ?>>Volunteer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">Emergency Contact</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="emergencyName">Contact Name</label>
                                <input type="text" id="emergencyName" name="emergencyName" value="<?php echo htmlspecialchars($staff['EmergencyContactName'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="relationship">Relationship</label>
                                <input type="text" id="relationship" name="relationship" value="<?php echo htmlspecialchars($staff['EmergencyContactRelation'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="emergencyPhone">Phone Number</label>
                                <input type="text" id="emergencyPhone" name="emergencyPhone" value="<?php echo htmlspecialchars($staff['EmergencyContactPhone'] ?? ''); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        function saveChanges(event) {
            event.preventDefault();
            const notification = document.getElementById('saveNotification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    window.location.href = 'staffManagementDetail.html';
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>