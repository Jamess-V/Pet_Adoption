<?php
session_start();
require_once '../config.php';

$sql = "SELECT * FROM Pets WHERE Status = 'Available' ORDER BY Pet_Name";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADOPET - Pet</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/petBrowsing.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="ADOPET Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pet.php" class="active">Adoption</a></li>
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

    
    <div class="main-content">
        <div class="hero-filter-section">
            <h1>Adopt a Pet</h1>
            <p>Browse through our collection of pets looking for their forever homes.</p>
            
            <h3>Filter by Type:</h3>
            <div class="filter-options">
                <label>
                    <input type="radio" name="pet-type" value="all" checked> All
                </label>
                <label>
                    <input type="radio" name="pet-type" value="Dog"> Dogs
                </label>
                <label>
                    <input type="radio" name="pet-type" value="Cat"> Cats
                </label>
                <label>
                    <input type="radio" name="pet-type" value="Bird"> Birds
                </label>
                <label>
                    <input type="radio" name="pet-type" value="Capybara"> Capybaras
                </label>
            </div>
        </div>
        
        
        <div class="pet-list" id="pet-list">
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($pet = $result->fetch_assoc()): ?>
                    <div class="pet-card" data-type="<?php echo htmlspecialchars($pet['Species']); ?>">
                        <img src="../Image/<?php echo htmlspecialchars($pet['Species']); ?>s/<?php echo htmlspecialchars(strtolower($pet['Species'])); ?>01.jpg" alt="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" onerror="this.src='../Image/pet-placeholder.jpg'">
                        <div class="pet-info">
                            <h2><?php echo htmlspecialchars($pet['Pet_Name']); ?></h2>
                            <p class="breed"><?php echo htmlspecialchars($pet['Species']); ?> • <?php echo htmlspecialchars($pet['Breed']); ?></p>
                            <p class="details">
                                <?php
                                if($pet['DateOfBirth']) {
                                    $age = date_diff(date_create($pet['DateOfBirth']), date_create('now'))->y;
                                    echo $age . ' Year' . ($age != 1 ? 's' : '');
                                }
                                ?> old
                            </p>
                            <button class="adopt-btn" onclick="window.location.href='adoptPet.php?pet_id=<?php echo $pet['Pet_id']; ?>'">Adopt Me</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; width: 100%; padding: 40px;">No pets available for adoption at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.querySelectorAll('input[name="pet-type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const filterValue = this.value;
                const petCards = document.querySelectorAll('.pet-card');
                
                petCards.forEach(card => {
                    if(filterValue === 'all' || card.dataset.type === filterValue) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>