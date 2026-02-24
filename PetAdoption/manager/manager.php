<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'manager') {
    header("Location: ../user/login.php");
    exit();
}

$manager_id = $_SESSION['user_id'];
$stats = [];
$sql = "SELECT COUNT(*) as total FROM Application WHERE YEAR(Application_date) = YEAR(CURDATE()) AND Status = 'Approved'";
$result = $conn->query($sql);
$stats['adoptions_year'] = $result->fetch_assoc()['total'];

$sql = "SELECT p.Species, COUNT(*) as count
        FROM Application a
        JOIN Pets p ON a.Pet_id = p.Pet_id
        WHERE a.Status = 'Approved'
        GROUP BY p.Species
        ORDER BY count DESC";
$result = $conn->query($sql);
$species_data = [];
while($row = $result->fetch_assoc()) {
    $species_data[] = $row;
}

$sql = "SELECT COUNT(*) as total FROM Application WHERE Status = 'Pending'";
$result = $conn->query($sql);
$stats['pending_apps'] = $result->fetch_assoc()['total'];
$sql = "SELECT COUNT(*) as total FROM Pets";
$result = $conn->query($sql);
$stats['total_pets'] = $result->fetch_assoc()['total'];
$sql = "SELECT COUNT(*) as total FROM Pets WHERE Status = 'Available'";
$result = $conn->query($sql);
$stats['available_pets'] = $result->fetch_assoc()['total'];
$sql = "SELECT COUNT(*) as total FROM Staff";
$result = $conn->query($sql);
$stats['total_staff'] = $result->fetch_assoc()['total'];
$sql = "SELECT
        (SELECT COUNT(*) FROM Application WHERE Status = 'Approved') as approved,
        (SELECT COUNT(*) FROM Application) as total";
$result = $conn->query($sql);
$rate_data = $result->fetch_assoc();
$stats['success_rate'] = $rate_data['total'] > 0 ? round(($rate_data['approved'] / $rate_data['total']) * 100) : 0;

$sql = "SELECT COUNT(*) as total FROM Application WHERE MONTH(Application_date) = MONTH(CURDATE()) AND YEAR(Application_date) = YEAR(CURDATE()) AND Status = 'Approved'";
$result = $conn->query($sql);
$stats['adoptions_month'] = $result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - ADOPET</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/manager.css">
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
            <button class="sidebar-btn active">
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

        
        <main class="dashboard-content">
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="stat-number" style="font-size: 48px; font-weight: bold; color: #007BFF; text-align: center; padding: 40px 0;">
                        <?php echo $stats['adoptions_year']; ?>
                    </div>
                    <div class="chart-info">
                        <h3>Adoptions This Year</h3>
                        <p>Total approved applications</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div style="padding: 20px;">
                        <?php if(!empty($species_data)): ?>
                            <?php foreach($species_data as $species): ?>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                                    <span style="font-weight: 500;"><?php echo htmlspecialchars($species['Species']); ?></span>
                                    <span style="color: #007BFF; font-weight: bold;"><?php echo $species['count']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: #999;">No data available</p>
                        <?php endif; ?>
                    </div>
                    <div class="chart-info">
                        <h3>Adoptions by Species</h3>
                        <p>Breakdown by pet type</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="stat-number" style="font-size: 48px; font-weight: bold; color: #FFC107; text-align: center; padding: 40px 0;">
                        <?php echo $stats['pending_apps']; ?>
                    </div>
                    <div class="chart-info">
                        <h3>Pending Applications</h3>
                        <p>Awaiting review</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div style="padding: 20px; text-align: center;">
                        <div style="font-size: 36px; font-weight: bold; color: #28a745;"><?php echo $stats['total_pets']; ?></div>
                        <div style="font-size: 14px; color: #666; margin-top: 5px;">Total Pets</div>
                        <div style="font-size: 28px; font-weight: bold; color: #007BFF; margin-top: 15px;"><?php echo $stats['available_pets']; ?></div>
                        <div style="font-size: 14px; color: #666; margin-top: 5px;">Available</div>
                    </div>
                    <div class="chart-info">
                        <h3>Pet Inventory</h3>
                        <p>Current shelter status</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="stat-number" style="font-size: 48px; font-weight: bold; color: #28a745; text-align: center; padding: 40px 0;">
                        <?php echo $stats['success_rate']; ?>%
                    </div>
                    <div class="chart-info">
                        <h3>Success Rate</h3>
                        <p>Application approval rate</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 500;">This Month</span>
                            <span style="color: #007BFF; font-size: 20px; font-weight: bold;"><?php echo $stats['adoptions_month']; ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 500;">Total Staff</span>
                            <span style="color: #007BFF; font-size: 20px; font-weight: bold;"><?php echo $stats['total_staff']; ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px 0;">
                            <span style="font-weight: 500;">This Year</span>
                            <span style="color: #28a745; font-size: 20px; font-weight: bold;"><?php echo $stats['adoptions_year']; ?></span>
                        </div>
                    </div>
                    <div class="chart-info">
                        <h3>Quick Stats</h3>
                        <p>Key metrics overview</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
