<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $bio = trim($_POST['bio']);
    
    $sql = "UPDATE Users SET Name = ?, Phone = ?, Address = ?, Bio = ? WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $phone, $address, $bio, $user_id);
    
    if($stmt->execute()) {
        $message = 'Profile updated successfully!';
        header("Location: profile.php");
        exit();
    } else {
        $message = 'Error updating profile.';
    }
}

$sql = "SELECT * FROM Users WHERE User_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$sql = "SELECT a.*, p.Pet_Name, p.Breed, p.Species
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
    <title>Edit Profile - ADOPET</title>
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
                <h2>Edit Profile</h2>

                <?php if($message): ?>
                    <div style="padding: 10px; margin: 10px 0; background: #d4edda; color: #155724; border-radius: 5px;">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="editProfile.php">

                <div class="profile-picture">
                    <div class="avatar-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="30" r="15" stroke="#ccc" stroke-width="2" fill="none"/>
                            <path d="M 15 65 Q 15 45 40 45 Q 65 45 65 65" stroke="#ccc" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <button class="upload-photo-btn">Upload Photo</button>
                </div>

                    <div class="profile-info">
                        <div class="info-field">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
                        </div>

                        <div class="info-field">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" readonly>
                        </div>

                        <div class="info-field">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['Phone'] ?? ''); ?>">
                        </div>

                        <div class="info-field">
                            <label>Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($user['Address'] ?? ''); ?>">
                        </div>

                        <div class="info-field">
                            <label>About Me</label>
                            <textarea name="bio"><?php echo htmlspecialchars($user['Bio'] ?? ''); ?></textarea>
                        </div>

                        <div class="edit-actions">
                            <button type="button" class="cancel-btn" onclick="window.location.href='profile.php'">Cancel</button>
                            <button type="submit" class="save-btn">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>