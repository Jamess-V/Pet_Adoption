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
                <li><a href="manager.html">Home</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <a href="../user/signup.html" class="btn btn-signup">Sign Up</a>
            <a href="../user/login.html" class="btn btn-login">Login</a>
        </div>
    </nav>

    <div class="staff-container">
        <aside class="sidebar">
            <button class="sidebar-btn" onclick="window.location.href='manager.html'">
                <svg viewBox="0 0 20 20">
                    <rect x="3" y="4" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="9" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="14" width="14" height="3" rx="0.5"/>
                </svg>
                Overall Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='petReport.html'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='adoptionApp.html'">
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
                    <button class="cancel-btn" onclick="window.location.href='staffManagementDetail.html'">Cancel</button>
                    <button class="save-btn" onclick="saveChanges(event)">Save Changes</button>
                </div>
            </div>
            <form class="edit-form">
                <div class="form-container">
                    <div class="form-section">
                        <h3 class="section-title">Personal Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" id="fullName" name="fullName" value="Sarah Thompson" required>
                            </div>

                            <div class="form-group">
                                <label for="employeeId">Employee ID</label>
                                <input type="text" id="employeeId" name="employeeId" value="EMP001" readonly>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="Sarah@example.com" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" value="+66 123456789" required>
                            </div>

                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="1985-05-15" required>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value="Female" selected>Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" value="123 Main Street, Bangkok, Thailand" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">Employment Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" id="position" name="position" value="Shelter Manager" required>
                            </div>

                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id="department" name="department" required>
                                    <option value="Operations" selected>Operations</option>
                                    <option value="Animal Care">Animal Care</option>
                                    <option value="Administration">Administration</option>
                                    <option value="Veterinary">Veterinary</option>
                                    <option value="Volunteer">Volunteer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employmentType">Employment Type</label>
                                <select id="employmentType" name="employmentType" required>
                                    <option value="Full-time" selected>Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Volunteer">Volunteer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="joinDate">Join Date</label>
                                <input type="date" id="joinDate" name="joinDate" value="2020-01-10" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="workSchedule">Work Schedule</label>
                                <input type="text" id="workSchedule" name="workSchedule" value="Monday - Friday, 9:00 AM - 6:00 PM" required>
                            </div>

                            <div class="form-group">
                                <label for="salary">Salary (per year)</label>
                                <input type="text" id="salary" name="salary" value="$45,000" required>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" required>
                                    <option value="Manager" selected>Manager</option>
                                    <option value="Senior Staff">Senior Staff</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Volunteer">Volunteer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">Emergency Contact</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="emergencyName">Contact Name</label>
                                <input type="text" id="emergencyName" name="emergencyName" value="John Thompson" required>
                            </div>

                            <div class="form-group">
                                <label for="relationship">Relationship</label>
                                <input type="text" id="relationship" name="relationship" value="Spouse" required>
                            </div>

                            <div class="form-group">
                                <label for="emergencyPhone">Phone Number</label>
                                <input type="text" id="emergencyPhone" name="emergencyPhone" value="+66 987654321" required>
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