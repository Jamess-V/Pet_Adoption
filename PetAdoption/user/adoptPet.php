<?php
session_start();
require_once '../config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;

if(!$pet_id) {
    header("Location: pet.php");
    exit();
}

$sql = "SELECT * FROM Pets WHERE Pet_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$pet = $stmt->get_result()->fetch_assoc();

if(!$pet) {
    header("Location: pet.php");
    exit();
}

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $question1 = trim($_POST['question1']);
    $question2 = trim($_POST['question2']);
    $question3 = trim($_POST['question3']);
    
    $answers = "Q1: " . $question1 . "\n\nQ2: " . $question2 . "\n\nQ3: " . $question3;
    
    $check_sql = "SELECT * FROM Application WHERE User_id = ? AND Pet_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $pet_id);
    $check_stmt->execute();
    $existing = $check_stmt->get_result();
    
    if($existing->num_rows > 0) {
        $error = 'You have already submitted an application for this pet.';
    } else {
        $sql = "INSERT INTO Application (User_id, Pet_id, Application_date, Status, Answers) 
                VALUES (?, ?, NOW(), 'Pending', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $user_id, $pet_id, $answers);
        
        if($stmt->execute()) {
            echo "<script>
                alert('Thank you for your application! Our team will review your submission and contact you soon.');
                window.location.href = 'index.php';
            </script>";
            exit();
        } else {
            $error = 'Failed to submit application. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Form - ADOPET</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/adoptPet.css">
</head>
<body>
    
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pet.php" class="active">Adoption</a></li>
                <li><a href="shelter.php">Meet & Greet</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <span style="color: #333; margin-right: 15px;">Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
            <a href="logout.php" class="btn btn-login">Logout</a>
        </div>
    </nav>

    
    <div class="adoption-container">
        <h1 class="adoption-form-title">Adoption Form</h1>
        
        <?php if($error): ?>
            <div style="max-width: 800px; margin: 0 auto 20px; padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="adoption-content">
            
            <div class="pet-info">
                <img src="../Image/<?php echo htmlspecialchars($pet['Species']); ?>s/<?php echo strtolower($pet['Species']); ?>01.jpg" alt="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" onerror="this.src='../Image/pet-placeholder.jpg'">
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
            </div>

            
            <div class="form-section">
                <p class="form-intro">
                    To help ensure the best possible match between pets and potential adopters, please answer the following questions honestly and completely. This questionnaire evaluates lifestyle compatibility, readiness, and long-term commitment.
                </p>

                <form id="adoptionForm" method="POST" action="adoptPet.php?pet_id=<?php echo $pet_id; ?>">
                    <div class="question">
                        <p class="question-text">
                            <strong>1.</strong> Please provide your age, occupation, and a brief description of your daily schedule, including how many hours you are typically away from home each day.
                        </p>
                        <label class="question-label">Answer:</label>
                        <textarea class="answer-input" name="question1" required></textarea>
                    </div>

                    <div class="question">
                        <p class="question-text">
                            <strong>2.</strong> Describe your living situation (house, apartment, condo) and whether you own or rent. If you rent, please note any pet restrictions. Include the number of people and children (with ages) living in your household.
                        </p>
                        <label class="question-label">Answer:</label>
                        <textarea class="answer-input" name="question2" required></textarea>
                    </div>

                    <div class="question">
                        <p class="question-text">
                            <strong>3.</strong> Do you currently have, or have you previously had, pets? If yes, describe the type of pets, how long you owned them, and what happened to them. If you have ever surrendered or rehomed a pet, please explain the circumstances.
                        </p>
                        <label class="question-label">Answer:</label>
                        <textarea class="answer-input" name="question3" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Submit Application</button>
                    <button type="button" class="back-btn" onclick="window.location.href='pet.php'">Back to Pets</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
