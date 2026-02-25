<?php
session_start();
require_once '../config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'manager') {
    header("Location: ../user/login.php");
    exit();
}

$app_id = isset($_GET['App_id']) ? intval($_GET['App_id']) : 0;
$message = '';

if(!$app_id) {
    die("Error: No application ID provided. Make sure you clicked 'View more Details' from the applications list.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $new_status = ($action === 'approve') ? 'Approved' : 'Rejected';
    
    $sql = "UPDATE Application SET Status = ? WHERE App_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $app_id);
    
    if($stmt->execute()) {
        header("Location: adoptionApp.php");
        exit();
    }
}
$sql = "SELECT a.*, u.Name as UserName, u.Email, u.Phone, u.Address, u.Bio,
        p.Pet_Name, p.Species, p.Breed, p.Gender, p.Color
        FROM Application a
        JOIN Users u ON a.User_id = u.User_id
        JOIN Pets p ON a.Pet_id = p.Pet_id
        WHERE a.App_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $app_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();
if (!$result) {
    die("Get result failed: " . $stmt->error);
}
$app = $result->fetch_assoc();

if(!$app) {
    die("No application found for ID: " . htmlspecialchars($app_id) . ". Please check if the application exists in the database.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/adoptionAppDetail.css">
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

        
        <main class="app-detail-content">
            <div class="detail-container">
                <h2 class="applicant-name"><?php echo htmlspecialchars($app['UserName']); ?></h2>

                <div class="detail-section">
                    <h3 class="section-title">Application Status</h3>
                    <div class="section-content">
                        <p><strong>Current Status:</strong> <span class="status-badge <?php echo strtolower($app['Status']); ?>"><?php echo htmlspecialchars($app['Status']); ?></span></p>
                        <p><strong>Application Date:</strong> <?php echo date('F j, Y', strtotime($app['Application_date'])); ?></p>
                    </div>
                </div>

                <div class="detail-section">
                    <h3 class="section-title">Pet Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <p><strong>Pet Name:</strong> <?php echo htmlspecialchars($app['Pet_Name']); ?></p>
                        </div>
                        <div class="info-item">
                            <p><strong>Species:</strong> <?php echo htmlspecialchars($app['Species']); ?></p>
                        </div>
                        <div class="info-item">
                            <p><strong>Breed:</strong> <?php echo htmlspecialchars($app['Breed']); ?></p>
                        </div>
                        <div class="info-item">
                            <p><strong>Gender:</strong> <?php echo htmlspecialchars($app['Gender']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3 class="section-title">Applicant Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($app['Email']); ?></p>
                        </div>
                        <div class="info-item">
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($app['Phone'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="info-item full-width">
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($app['Address'] ?? 'N/A'); ?></p>
                        </div>
                        <?php if($app['Bio']): ?>
                        <div class="info-item full-width">
                            <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($app['Bio'])); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-section">
                    <h3 class="section-title">Application Answers</h3>
                    <div class="section-content">
                        <?php 
                        $answers = json_decode($app['Answers'], true);
                        if($answers && is_array($answers)):
                            $questions = [
                                'hasYard' => 'Do you have a yard?',
                                'homeType' => 'What type of home do you have?',
                                'otherPets' => 'Do you have other pets?',
                                'experience' => 'Previous pet experience',
                                'hours' => 'Hours pet would be alone',
                                'reason' => 'Reason for adoption'
                            ];
                            foreach($answers as $key => $value):
                        ?>
                            <p><strong><?php echo isset($questions[$key]) ? $questions[$key] : ucfirst($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></p>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <p>No additional answers provided.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($app['Status'] === 'Pending'): ?>
                <form method="POST" action="adoptionAppDetail.php?App_id=<?php echo $app_id; ?>">
                    <div class="action-buttons">
                        <button type="submit" name="action" value="approve" class="approve-btn">Approve Application</button>
                        <button type="submit" name="action" value="reject" class="decline-btn">Reject Application</button>
                    </div>
                </form>
                <?php endif; ?>
                
                <div class="action-buttons">
                    <button type="button" class="decline-btn" onclick="window.location.href='adoptionApp.php'">Back to List</button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>