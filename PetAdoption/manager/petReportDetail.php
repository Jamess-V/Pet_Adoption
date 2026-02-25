<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'manager') {
    header("Location: ../user/login.php");
    exit();
}

$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;

$pet_query = "SELECT * FROM Pets WHERE Pet_id = ?";
$stmt = $conn->prepare($pet_query);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    echo "Pet not found.";
    exit();
}

$pet = $result->fetch_assoc();

$species_folder = strtolower($pet['Species']);
if($species_folder === 'dog') {
    $species_folder = 'dogs';
} elseif($species_folder === 'cat') {
    $species_folder = 'cats';
} elseif($species_folder === 'bird') {
    $species_folder = 'birds';
} elseif($species_folder === 'capybara') {
    $species_folder = 'capybaras';
}
$pet_image = "../Image/$species_folder/" . strtolower($pet['Species']) . "01.jpg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/petReportDetail.css">
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
            <button class="sidebar-btn active">
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

        
        <main class="pet-detail-content">
            <div class="detail-header">
                <h2>Pet Details</h2>
                <button class="edit-btn" onclick="window.location.href='editPetReport.php?pet_id=<?php echo $pet_id; ?>'">Edit</button>
            </div>

            <div class="detail-container">
                <div class="detail-left">
                    
                    <div class="detail-section">
                        <h3 class="pet-name"><?php echo htmlspecialchars($pet['Pet_Name']); ?></h3>
                        <p class="pet-breed"><?php echo htmlspecialchars($pet['Breed']); ?></p>
                        <div class="basic-info">
                            <p><strong>Species:</strong> <?php echo htmlspecialchars($pet['Species']); ?></p>
                            <p><strong>Gender:</strong> <?php echo htmlspecialchars($pet['Gender']); ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo $pet['DateOfBirth'] ? date('d M Y', strtotime($pet['DateOfBirth'])) : 'Unknown'; ?></p>
                            <p><strong>Age:</strong> 
                                <?php 
                                if($pet['DateOfBirth']) {
                                    $dob = new DateTime($pet['DateOfBirth']);
                                    $now = new DateTime();
                                    $interval = $now->diff($dob);
                                    echo $interval->y . " years, " . $interval->m . " months";
                                } else {
                                    echo 'Unknown';
                                }
                                ?>
                            </p>
                            <p><strong>Size:</strong> <?php echo htmlspecialchars($pet['Size'] ?? 'Unknown'); ?></p>
                            <p><strong>Weight:</strong> <?php echo htmlspecialchars($pet['Weight'] ?? 'Unknown'); ?>kg</p>
                            <p><strong>Color:</strong> <?php echo htmlspecialchars($pet['Color'] ?? 'Unknown'); ?></p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Health & Medical</h3>
                        <div class="section-content">
                            <p><strong>Vaccination Status:</strong> <?php echo htmlspecialchars($pet['VaccinationStatus'] ?? 'Unknown'); ?></p>
                            <p><strong>Spayed/Neutered:</strong> <?php echo ($pet['Neutered'] == 1) ? 'Yes' : 'No'; ?></p>
                            <p><strong>Medical Conditions:</strong> <?php echo htmlspecialchars($pet['MedicalHistory'] ?? 'None'); ?></p>
                            <p><strong>Last Vet Checkup:</strong> <?php echo $pet['LastCheckup'] ? date('d M Y', strtotime($pet['LastCheckup'])) : 'N/A'; ?></p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Behavior & Temperament</h3>
                        <div class="section-content">
                            <p><strong>Personality:</strong> <?php echo htmlspecialchars($pet['Personality'] ?? 'Friendly and playful'); ?></p>
                            <p><strong>Training:</strong> <?php echo htmlspecialchars($pet['TrainingLevel'] ?? 'Basic training'); ?></p>
                            <p><strong>Energy Level:</strong> <?php echo htmlspecialchars($pet['EnergyLevel'] ?? 'Medium'); ?></p>
                            <p><strong>Special Needs:</strong> <?php echo htmlspecialchars($pet['SpecialNeeds'] ?? 'None'); ?></p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Shelter Information</h3>
                        <div class="section-content">
                            <p><strong>Date Added:</strong> <?php echo $pet['AdmissionDate'] ? date('d M Y', strtotime($pet['AdmissionDate'])) : 'N/A'; ?></p>
                            <p><strong>Current Status:</strong> <?php echo htmlspecialchars($pet['Status']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="detail-right">
                    <img src="<?php echo htmlspecialchars($pet_image); ?>" alt="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" class="pet-detail-photo" onerror="this.src='../Image/default-pet.jpg'">
                </div>
            </div>
        </main>
    </div>
</body>
</html>