<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'manager') {
    header("Location: ../user/login.php");
    exit();
}

$manager_id = $_SESSION['user_id'];

$sql = "SELECT a.*, u.Name as UserName, u.Email, u.Phone, u.Address, p.Pet_Name, p.Species
        FROM Application a
        JOIN Users u ON a.User_id = u.User_id
        JOIN Pets p ON a.Pet_id = p.Pet_id
        ORDER BY a.Application_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Applications - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/adoptionApp.css">
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
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Application Status
            </button>
            <button class="sidebar-btn" onclick="window.location.href='staffManagement.php'">
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

        
        <<main class="adoption-app-content">
            <h2>Adoption Applications</h2>
            <p class="subtitle">User Details</p>

            <div class="application-list">
                <?php if($result->num_rows > 0): ?>
                    <?php while($app = $result->fetch_assoc()): ?>
                        <div class="application-card">
                            <div class="card-content">
                                <h3 class="applicant-name"><?php echo htmlspecialchars($app['UserName']); ?></h3>
                                <div class="applicant-info">
                                    <div class="info-row">
                                        <p><strong>Pet:</strong> <?php echo htmlspecialchars($app['Pet_Name']) . ' (' . htmlspecialchars($app['Species']) . ')'; ?></p>
                                    </div>
                                    <div class="info-row">
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($app['Email']); ?></p>
                                    </div>
                                    <div class="info-row">
                                        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($app['Phone'] ?? 'N/A'); ?></p>
                                    </div>
                                    <div class="info-row">
                                        <p><strong>Home Address:</strong> <?php echo htmlspecialchars($app['Address'] ?? 'N/A'); ?></p>
                                    </div>
                                    <div class="reason-section">
                                        <p><strong>Application Date:</strong> <?php echo date('M d, Y', strtotime($app['Application_date'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-actions">
                                <span class="status-badge <?php echo strtolower($app['Status']); ?>"><?php echo htmlspecialchars($app['Status']); ?></span>
                                <button class="view-details-btn" onclick="window.location.href='adoptionAppDetail.php?app_id=<?php echo $app['Application_id']; ?>'">View more Details</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="padding: 40px; text-align: center; color: #666;">
                        <p>No applications found.</p>
                    </div>
                <?php endif; ?>
                </div>
        </main>
    </div>
</body>
</html>