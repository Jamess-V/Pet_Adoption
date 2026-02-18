<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ADOPET</title>
    <link rel="stylesheet" href="../css/login_signup.css">
</head>
<body>
    <div class="login-container">
        <h1>ADOPET</h1>
        
        <div class="error-message" id="errorMessage"></div>

        <form method="POST" action="login.php" id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <span class="eye-icon" onclick="togglePassword()">👁</span>
                </div>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="links">
                <a href="#">Forgot Password</a>
                <a href="signup.html">Register</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon');
            
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM Manager WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['Password']) {
                session_start();
                $_SESSION['user_id'] = $user['Manager_id'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['user_type'] = 'manager';
                header("Location: ../manager/manager.php");
                exit();
            }
        }

        $sql = "SELECT * FROM Staff WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['Password']) {
                session_start();
                $_SESSION['user_id'] = $user['Staff_id'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['user_type'] = 'staff';
                header("Location: ../staff/staff.php");
                exit();
            }
        }

        $sql = "SELECT * FROM Users WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['Password']) {
                session_start();
                $_SESSION['user_id'] = $user['User_id'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['user_type'] = 'user';
                header("Location: ../user/index.php");
                exit();
            }
        }

        echo "<script>document.getElementById('errorMessage').textContent = 'Invalid email or password';</script>";
    }
    ?>
</body>
</html>
