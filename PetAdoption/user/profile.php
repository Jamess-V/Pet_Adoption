<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM Users WHERE User_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$sql = "SELECT a.*, p.Pet_Name, p.Breed, p.Species, p.Gender
        FROM Application a
        JOIN Pets p ON a.Pet_id = p.Pet_id
        WHERE a.User_id = ? AND a.Status = 'Approved'
        ORDER BY a.Application_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$adoptions = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - ADOPET</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pet.php">Adoption</a></li>
                <li><a href="shelter.php">Meet & Greet</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <span style="color: #333; margin-right: 15px;">Welcome, <?php echo htmlspecialchars($user['Name']); ?></span>
            <a href="logout.php" class="btn btn-login">Logout</a>
        </div>
    </nav>

    
    <div class="profile-container">
        <div class="profile-content">
            
            <div class="adoption-history">
                <h2>Adoption History</h2>
                <p class="subtitle">Pets you've adopted</p>

                <?php if($adoptions && $adoptions->num_rows > 0): ?>
                    <?php while($adoption = $adoptions->fetch_assoc()): ?>
                        <div class="adopted-pet-card">
                            <img src="../Image/<?php echo htmlspecialchars($adoption['Species']); ?>s/<?php echo strtolower($adoption['Species']); ?>01.jpg" alt="<?php echo htmlspecialchars($adoption['Pet_Name']); ?>" onerror="this.src='../Image/pet-placeholder.jpg'">
                            <div class="pet-details">
                                <h3><?php echo htmlspecialchars($adoption['Pet_Name']); ?></h3>
                                <p>Breed: <?php echo htmlspecialchars($adoption['Breed']); ?></p>
                                <p>Adopted: <?php echo date('F d, Y', strtotime($adoption['Application_date'])); ?></p>
                                <p>Status: <?php echo htmlspecialchars($adoption['Status']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; padding: 20px; color: #999;">You haven't adopted any pets yet.</p>
                <?php endif; ?>
            </div>

            
            <div class="my-profile">
                <h2>My Profile</h2>

                <div class="profile-picture">
                    <div class="avatar-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="30" r="15" stroke="#ccc" stroke-width="2" fill="none"/>
                            <path d="M 15 65 Q 15 45 40 45 Q 65 45 65 65" stroke="#ccc" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                </div>

                <div class="profile-info">
                    <div class="info-field">
                        <input type="text" value="<?php echo htmlspecialchars($user['Name']); ?>" readonly>
                    </div>

                    <div class="info-field">
                        <input type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" readonly>
                    </div>

                    <div class="info-field">
                        <input type="tel" value="<?php echo htmlspecialchars($user['Phone'] ?? 'Not provided'); ?>" readonly>
                    </div>

                    <div class="info-field">
                        <input type="text" value="<?php echo htmlspecialchars($user['Address'] ?? 'Not provided'); ?>" readonly>
                    </div>

                    <div class="info-field">
                        <textarea readonly><?php echo htmlspecialchars($user['Bio'] ?? 'No bio added yet'); ?></textarea>
                    </div>

                    <button class="edit-btn" onclick="window.location.href='editProfile.php'">Edit</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
