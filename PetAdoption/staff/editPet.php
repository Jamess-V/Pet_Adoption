<?php
session_start();
require_once '../config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../user/login.php");
    exit();
}

$staff_id = $_SESSION['user_id'];
$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;
$message = '';
$error = '';

if(!$pet_id) {
    header("Location: petManagement.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_name = trim($_POST['pet_name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $color = trim($_POST['color']);
    $status = $_POST['status'];
    
    $birth_year = date('Y') - $age;
    $date_of_birth = "$birth_year-01-01";
    
    $sql = "UPDATE Pets SET Pet_Name = ?, Species = ?, Breed = ?, Gender = ?, DateOfBirth = ?, Color = ?, Status = ? WHERE Pet_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $pet_name, $species, $breed, $gender, $date_of_birth, $color, $status, $pet_id);
    
    if($stmt->execute()) {
        echo "<script>
            alert('Pet information updated successfully!');
            window.location.href = 'petManagement.php';
        </script>";
        exit();
    } else {
        $error = 'Failed to update pet. Please try again.';
    }
}

$sql = "SELECT * FROM Pets WHERE Pet_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$pet = $stmt->get_result()->fetch_assoc();

if(!$pet) {
    header("Location: petManagement.php");
    exit();
}

$age = 0;
if($pet['DateOfBirth']) {
    $age = date_diff(date_create($pet['DateOfBirth']), date_create('now'))->y;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/editPet.css">
    <link rel="stylesheet" href="../css/buttons.css">
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
            <button class="sidebar-btn active">
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
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Applications
                <span class="read-only">(Read-only)</span>
            </button>
        </aside>
        <main class="edit-pet-content">
            <div class="edit-pet-form">
                <?php if($error): ?>
                    <div style="padding: 15px; margin-bottom: 20px; background: #f8d7da; color: #721c24; border-radius: 5px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <div class="pet-photo-section">
                    <div class="pet-photo">
                        <img src="../Image/<?php echo htmlspecialchars($pet['Species']); ?>s/<?php echo strtolower($pet['Species']); ?>01.jpg" alt="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" id="petPhoto" onerror="this.src='../Image/pet-placeholder.jpg'">
                        <button class="photo-upload-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                            </svg>
                        </button>
                        <input type="file" id="photoInput" accept="image/*" style="display: none;">
                    </div>
                </div>

                <form id="editPetForm" method="POST" action="editPet.php?pet_id=<?php echo $pet_id; ?>">
                    <div class="form-row">
                        <div class="form-field">
                            <label>Name</label>
                            <input type="text" name="pet_name" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" class="form-input" required>
                        </div>
                        <div class="form-field">
                            <label>Species</label>
                            <input type="text" name="species" value="<?php echo htmlspecialchars($pet['Species']); ?>" class="form-input" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label>Breed</label>
                            <input type="text" name="breed" value="<?php echo htmlspecialchars($pet['Breed']); ?>" class="form-input" required>
                        </div>
                        <div class="form-field">
                            <label>Age (Years)</label>
                            <input type="number" name="age" value="<?php echo $age; ?>" class="form-input" required min="0" max="30">
                        </div>
                    </div>

                    <div class="form-field full-width">
                        <label>Sex</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Male" <?php echo $pet['Gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $pet['Gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label>Color</label>
                            <input type="text" name="color" value="<?php echo htmlspecialchars($pet['Color']); ?>" class="form-input" required>
                        </div>
                        <div class="form-field">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Available" <?php echo $pet['Status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                                <option value="Pending" <?php echo $pet['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Adopted" <?php echo $pet['Status'] == 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
                                <option value="Medical Care" <?php echo $pet['Status'] == 'Medical Care' ? 'selected' : ''; ?>>Medical Care</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="save-btn">Save Changes</button>
                        <button type="button" class="cancel-btn" onclick="window.location.href='petManagement.php'">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.querySelector('.photo-upload-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('photoInput').click();
        });
        document.getElementById('photoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('petPhoto').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
