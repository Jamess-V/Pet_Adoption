<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}
$app_query = "SELECT a.*, u.Name as UserName, u.Email as UserEmail, u.Phone as UserPhone,
              p.Pet_Name, p.Species, p.Breed, p.Gender, p.Pet_id
              FROM Application a
              JOIN Users u ON a.User_id = u.User_id
              JOIN Pets p ON a.Pet_id = p.Pet_id
              WHERE a.Status IN ('Pending', 'Approved')
              ORDER BY a.Status ASC, a.Application_date DESC";
$app_result = $conn->query($app_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Applications - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/appView.css">
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
            <button class="sidebar-btn" onclick="window.location.href='shelterAppointment.php'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 9C11.7 9 13 7.7 13 6C13 4.3 11.7 3 10 3C8.3 3 7 4.3 7 6C7 7.7 8.3 9 10 9Z"/>
                    <path d="M10 11C6.7 11 4 13.7 4 17H16C16 13.7 13.3 11 10 11Z"/>
                </svg>
                Meet & Greet
            </button>
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Applications
            </button>
        </aside>
        <main class="dashboard-content">
            <div class="page-header">
                <h2>Adoption Applications</h2>
                <p>View all pending and approved adoption applications</p>
            </div>

            <?php
            $total_apps = $app_result ? $app_result->num_rows : 0;
            $pending_query = "SELECT COUNT(*) as pending_count FROM Application WHERE Status = 'Pending'";
            $pending_result = $conn->query($pending_query);
            $pending_count = $pending_result->fetch_assoc()['pending_count'] ?? 0;
            
            $approved_query = "SELECT COUNT(*) as approved_count FROM Application WHERE Status = 'Approved'";
            $approved_result = $conn->query($approved_query);
            $approved_count = $approved_result->fetch_assoc()['approved_count'] ?? 0;
            ?>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><?php echo $total_apps; ?></div>
                    <div class="stat-label">Total Applications</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><?php echo $pending_count; ?></div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><?php echo $approved_count; ?></div>
                    <div class="stat-label">Approved</div>
                </div>
            </div>

            <div class="applications-container">
                <?php if($app_result && $app_result->num_rows > 0): ?>
                    <?php while($app = $app_result->fetch_assoc()): ?>
                        <div class="application-card">
                            <div class="app-header">
                                <div class="app-title">
                                    Application #<?php echo str_pad($app['App_id'], 4, '0', STR_PAD_LEFT); ?>
                                </div>
                                <span class="app-status-badge <?php echo strtolower($app['Status']); ?>">
                                    <?php echo $app['Status'] == 'Pending' ? 'Pending Review' : 'Approved by Manager'; ?>
                                </span>
                            </div>
                            
                            <div class="app-details">
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Applicant Name</span>
                                    <span class="app-detail-value"><?php echo htmlspecialchars($app['UserName']); ?></span>
                                </div>
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Email</span>
                                    <span class="app-detail-value"><?php echo htmlspecialchars($app['UserEmail']); ?></span>
                                </div>
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Phone</span>
                                    <span class="app-detail-value"><?php echo htmlspecialchars($app['UserPhone'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Pet Name</span>
                                    <span class="app-detail-value"><?php echo htmlspecialchars($app['Pet_Name']); ?></span>
                                </div>
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Species</span>
                                    <span class="app-detail-value"><?php echo htmlspecialchars($app['Species']); ?> (<?php echo htmlspecialchars($app['Breed']); ?>)</span>
                                </div>
                                <div class="app-detail-item">
                                    <span class="app-detail-label">Submission Date</span>
                                    <span class="app-detail-value"><?php echo date('M d, Y', strtotime($app['Application_date'])); ?></span>
                                </div>
                            </div>

                            <div class="app-actions">
                                <button class="view-btn" onclick="window.location.href='../user/pet.php?pet_id=<?php echo $app['Pet_id']; ?>'">
                                    View Pet Details
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-applications">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="14 2 14 8 20 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="16" y1="13" x2="8" y2="13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="16" y1="17" x2="8" y2="17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="10 9 9 9 8 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3>No Applications Found</h3>
                        <p>There are no pending or approved applications at this time.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
