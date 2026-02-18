<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ADOPET</title>
    <link rel="stylesheet" href="../css/login_signup.css">
</head>
<body>
    <div class="register-container">
        <h1>ADOPET</h1>
        
        <div class="error-message" id="errorMessage"><?php echo $error_message; ?></div>
        <div class="success-message" id="successMessage"><?php echo $success_message; ?></div>

        <form method="POST" action="signup.php" id="registerForm">
            <div class="name-row">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <span class="eye-icon" onclick="togglePassword('password')">👁</span>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <span class="eye-icon" onclick="togglePassword('confirm_password')">👁</span>
                </div>
            </div>

            <button type="submit" class="register-btn">Register</button>

            <div class="links">
                <a href="login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '👁';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁';
            }
        }
    </script>
    <?php
    require_once '../config.php';

    $error_message = '';
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate inputs
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            $error_message = 'All fields are required';
        } elseif ($password !== $confirm_password) {
            $error_message = 'Passwords do not match';
        } elseif (strlen($password) < 6) {
            $error_message = 'Password must be at least 6 characters';
        } else {
            $sql = "SELECT * FROM Users WHERE Email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error_message = 'Email already registered';
            } else {
                $full_name = $firstname . ' ' . $lastname;
                $sql = "INSERT INTO Users (Name, Email, Password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $full_name, $email, $password);

                if ($stmt->execute()) {
                    $success_message = 'Registration successful!';
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2000);
                    </script>";
                } else {
                    $error_message = 'Registration failed. Please try again.';
                }
            }
        }
    }
    ?>
</body>
</html>
