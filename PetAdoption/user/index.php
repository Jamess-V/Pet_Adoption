<?php
session_start();
require_once '../config.php';

$sql = "SELECT * FROM Pets WHERE Status = 'Available' LIMIT 3";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADOPET - Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="ADOPET Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="pet.php">Adoption</a></li>
                <li><a href="shelter.php">Meet & Greet</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span style="color: #333; margin-right: 15px;">Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <a href="logout.php" class="btn btn-login">Logout</a>
            <?php else: ?>
                <a href="signup.php" class="btn btn-signup">Sign Up</a>
                <a href="login.php" class="btn btn-login">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="hero-section">
        <h1 class="home-title">Welcome to ADOPET</h1>
        <p class="home-subtitle">Find your perfect companion and give a pet a loving home</p>
    </div>
    
    <div class="home-container">
        <h2 class="featured-title">Featured Pets</h2>
        
        <div class="featured-content">
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($pet = $result->fetch_assoc()): ?>
                    <div class="pet-card">
                        <img src="../Image/<?php echo htmlspecialchars($pet['Species']); ?>s/<?php echo htmlspecialchars(strtolower($pet['Species'])); ?>01.jpg" alt="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" onerror="this.src='../Image/pet-placeholder.jpg'">
                        <h2><?php echo htmlspecialchars($pet['Pet_Name']); ?></h2>
                        <p class="breed"><?php echo htmlspecialchars($pet['Breed']); ?></p>
                        <p class="details">
                            <?php 
                            if($pet['DateOfBirth']) {
                                $age = date_diff(date_create($pet['DateOfBirth']), date_create('now'))->y;
                                echo $age . ' Year' . ($age != 1 ? 's' : '');
                            }
                            ?> - <?php echo htmlspecialchars($pet['Gender']); ?>
                        </p>
                        <button class="view-btn" onclick="window.location.href='pet.php?pet_id=<?php echo $pet['Pet_id']; ?>'">View Details</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; width: 100%; padding: 40px;">No pets available for adoption at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
