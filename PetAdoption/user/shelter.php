<?php
session_start();
require_once '../config.php';

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $note = trim($_POST['note']);
    
    $shelter_sql = "SELECT Shelter_id FROM Shelter LIMIT 1";
    $shelter_result = $conn->query($shelter_sql);
    $shelter_id = $shelter_result->fetch_assoc()['Shelter_id'] ?? 1;
    
    $sql = "INSERT INTO ShelterAppointment (Shelter_id, User_name, User_email, User_phone, Appointment_date, Appointment_time, Note, Status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $shelter_id, $fullname, $email, $phone, $date, $time, $note);
    
    if($stmt->execute()) {
        $message = 'Your Meet & Greet appointment has been scheduled!';
    } else {
        $error = 'Failed to schedule appointment. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet & Greet - Pet Adoption</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/shelter.css">
</head>
<body>
    
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pet.php">Find a Pet</a></li>
                <li><a href="shelter.php" class="active">Meet & Greet</a></li>
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

    
    <div class="shelter-container">
        <h1 class="page-title">Meet & Greet</h1>

        <?php if($message): ?>
            <div style="max-width: 600px; margin: 0 auto 20px; padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; text-align: center;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div style="max-width: 600px; margin: 0 auto 20px; padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        
        <div class="schedule-wrapper">
            
            <div class="form-section">
                <form id="meetGreetForm" method="POST" action="shelter.php">
                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" placeholder="Fullname *" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Email Address *" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" placeholder="Phone *" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" id="date" name="date" placeholder="dd/mm/yyyy" onfocus="(this.type='date')">
                    </div>
                    
                    <div class="form-group">
                        <input type="time" id="time" name="time" min="07:00" max="22:00" required>
                    </div>
                    
                    <div class="form-group">
                        <textarea id="note" name="note" rows="4" placeholder="Additional Note"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">Schedule Visit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php
            $sql = "SELECT * FROM Users WHERE User_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            if($user):
            ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('fullname').value = '<?php echo addslashes($user['Name']); ?>';
                document.getElementById('email').value = '<?php echo addslashes($user['Email']); ?>';
                <?php if($user['Phone']): ?>
                document.getElementById('phone').value = '<?php echo addslashes($user['Phone']); ?>';
                <?php endif; ?>
            });
            <?php endif; ?>
        <?php endif; ?>
    </script>
</body>
</html>
