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

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_name = $_POST['petName'];
    $breed = $_POST['breed'];
    $species = $_POST['species'];
    $gender = $_POST['gender'];
    $dateofbirth = $_POST['dateOfBirth'];
    $size = $_POST['size'];
    $weight = $_POST['weight'];
    $color = $_POST['color'];
    $vaccination_status = $_POST['vaccination'];
    $neutered = ($_POST['neutered'] === 'Yes') ? 1 : 0;
    $medical_history = $_POST['medical'];
    $last_checkup = $_POST['lastCheckup'];
    $personality = $_POST['personality'];
    $training_level = $_POST['training'];
    $energy_level = $_POST['energy'];
    $special_needs = $_POST['compatibility'];
    $admission_date = $_POST['rescueDate'];
    $status = $_POST['status'];
    
    $update_query = "UPDATE Pets SET Pet_Name=?, Breed=?, Species=?, Gender=?, DateOfBirth=?, Color=?, Status=? WHERE Pet_id=?";
    $update_stmt = $conn->prepare($update_query);
    if (!$update_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $update_stmt->bind_param("sssssssi", $pet_name, $breed, $species, $gender, $dateofbirth, $color, $status, $pet_id);
    
    if (!$update_stmt->execute()) {
        die("Update failed: " . $update_stmt->error);
    }
    
    header("Location: petReportDetail.php?pet_id=$pet_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/editPetReport.css">
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

        
        <main class="edit-pet-content">
            
            <div id="saveNotification" class="save-notification">
                <svg viewBox="0 0 24 24" class="check-icon">
                    <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Changes Saved</span>
            </div>

            <div class="edit-header">
                <h2>Edit Pet Details</h2>
                <div class="edit-actions">
                    <button class="cancel-btn" onclick="window.location.href='petReportDetail.php?pet_id=<?php echo $pet_id; ?>'">Cancel</button>
                    <button class="save-btn" onclick="document.getElementById('editForm').submit()">Save Changes</button>
                </div>
            </div>

            <form method="POST" class="edit-form" id="editForm">
                <div class="form-container">
                    <div class="form-left">
                        
                        <div class="form-section">
                            <h3 class="section-title">Basic Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="petName">Pet Name</label>
                                    <input type="text" id="petName" name="petName" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="breed">Breed</label>
                                    <input type="text" id="breed" name="breed" value="<?php echo htmlspecialchars($pet['Breed']); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="species">Species</label>
                                    <select id="species" name="species" required>
                                        <option value="Dog" <?php echo ($pet['Species'] === 'Dog') ? 'selected' : ''; ?>>Dog</option>
                                        <option value="Cat" <?php echo ($pet['Species'] === 'Cat') ? 'selected' : ''; ?>>Cat</option>
                                        <option value="Bird" <?php echo ($pet['Species'] === 'Bird') ? 'selected' : ''; ?>>Bird</option>
                                        <option value="Capybara" <?php echo ($pet['Species'] === 'Capybara') ? 'selected' : ''; ?>>Capybara</option>
                                        <option value="Other" <?php echo ($pet['Species'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" required>
                                        <option value="Male" <?php echo ($pet['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($pet['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dateOfBirth">Date of Birth</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $pet['DateOfBirth']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="size">Size</label>
                                    <select id="size" name="size" required>
                                        <option value="Small" <?php echo ($pet['Size'] === 'Small') ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo ($pet['Size'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo ($pet['Size'] === 'Large') ? 'selected' : ''; ?>>Large</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="weight">Weight (kg)</label>
                                    <input type="text" id="weight" name="weight" value="<?php echo htmlspecialchars($pet['Weight'] ?? ''); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($pet['Color'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h3 class="section-title">Health & Medical</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="vaccination">Vaccination Status</label>
                                    <select id="vaccination" name="vaccination" required>
                                        <option value="Fully vaccinated" <?php echo ($pet['VaccinationStatus'] === 'Fully vaccinated') ? 'selected' : ''; ?>>Fully vaccinated</option>
                                        <option value="Partially vaccinated" <?php echo ($pet['VaccinationStatus'] === 'Partially vaccinated') ? 'selected' : ''; ?>>Partially vaccinated</option>
                                        <option value="Not vaccinated" <?php echo ($pet['VaccinationStatus'] === 'Not vaccinated') ? 'selected' : ''; ?>>Not vaccinated</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="neutered">Spayed/Neutered</label>
                                    <select id="neutered" name="neutered" required>
                                        <option value="Yes" <?php echo ($pet['Neutered'] == 1) ? 'selected' : ''; ?>>Yes</option>
                                        <option value="No" <?php echo ($pet['Neutered'] == 0) ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="medical">Medical Conditions</label>
                                    <input type="text" id="medical" name="medical" value="<?php echo htmlspecialchars($pet['MedicalHistory'] ?? 'None'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="lastCheckup">Last Vet Checkup</label>
                                    <input type="date" id="lastCheckup" name="lastCheckup" value="<?php echo $pet['LastCheckup'] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h3 class="section-title">Behavior & Temperament</h3>
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="personality">Personality</label>
                                    <textarea id="personality" name="personality" rows="3"><?php echo htmlspecialchars($pet['Personality'] ?? ''); ?></textarea>
                                </div>

                                <div class="form-group full-width">
                                    <label for="training">Training</label>
                                    <textarea id="training" name="training" rows="2"><?php echo htmlspecialchars($pet['TrainingLevel'] ?? ''); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="energy">Energy Level</label>
                                    <select id="energy" name="energy" required>
                                        <option value="Low" <?php echo ($pet['EnergyLevel'] === 'Low') ? 'selected' : ''; ?>>Low</option>
                                        <option value="Medium" <?php echo ($pet['EnergyLevel'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Medium-high" <?php echo ($pet['EnergyLevel'] === 'Medium-high') ? 'selected' : ''; ?>>Medium-high</option>
                                        <option value="High" <?php echo ($pet['EnergyLevel'] === 'High') ? 'selected' : ''; ?>>High</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="compatibility">Special Needs</label>
                                    <input type="text" id="compatibility" name="compatibility" value="<?php echo htmlspecialchars($pet['SpecialNeeds'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-section">
                            <h3 class="section-title">Shelter Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="rescueDate">Date Added to Shelter</label>
                                    <input type="date" id="rescueDate" name="rescueDate" value="<?php echo $pet['AdmissionDate'] ?? ''; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Current Status</label>
                                    <select id="status" name="status" required>
                                        <option value="Available" <?php echo ($pet['Status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                                        <option value="Pending" <?php echo ($pet['Status'] === 'Pending') ? 'selected' : ''; ?>>Pending Adoption</option>
                                        <option value="Adopted" <?php echo ($pet['Status'] === 'Adopted') ? 'selected' : ''; ?>>Adopted</option>
                                        <option value="Medical care" <?php echo ($pet['Status'] === 'Medical care') ? 'selected' : ''; ?>>Medical Care</option>
                                        <option value="Not available" <?php echo ($pet['Status'] === 'Not available') ? 'selected' : ''; ?>>Not Available</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-right">
                        
                        <div class="photo-section">
                            <h3 class="section-title">Pet Photo</h3>
                            <div class="photo-upload">
                                <img src="../Image/Golden-Retriever.jpg" alt="Max" class="current-photo" id="photoPreview">
                                <div class="upload-controls">
                                    <label for="photoUpload" class="upload-btn">
                                        <svg viewBox="0 0 24 24" class="upload-icon">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <polyline points="17 8 12 3 7 8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <line x1="12" y1="3" x2="12" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                        Upload New Photo
                                    </label>
                                    <input type="file" id="photoUpload" accept="image/*" style="display: none;">
                                    <button type="button" class="remove-photo-btn">Remove Photo</button>
                                </div>
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
                    window.location.href = 'petReportDetail.php';
                }, 300);
            }, 3000);
        }
        document.getElementById('photoUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        document.querySelector('.remove-photo-btn').addEventListener('click', function() {
            document.getElementById('photoPreview').src = '../Image/placeholder.jpg';
            document.getElementById('photoUpload').value = '';
        });
    </script>
</body>
</html>