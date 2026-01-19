<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - King's Dental Academy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2c5f7f;
            --secondary: #4a9fd8;
            --accent: #f0a500;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(240, 165, 0, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;   /* 🔑 important */
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;  /* fills circle without distortion */
            transition: transform 0.3s ease;
        }

        .logo-circle:hover img {
            transform: scale(1.05);
        }


        .logo-section h1 {
            color: var(--white);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .logo-section p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--white);
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(44, 95, 127, 0.6);
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            color: var(--dark);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input::placeholder {
            color: rgba(26, 26, 46, 0.5);
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 1);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(240, 165, 0, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(44, 95, 127, 0.6);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.5rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--white);
            font-size: 0.9rem;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent);
        }

        .forgot-password {
            color: var(--white);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: var(--accent);
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: var(--accent);
            color: var(--dark);
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(240, 165, 0, 0.4);
        }

        .login-btn:hover {
            background: #ffc233;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(240, 165, 0, 0.5);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        .divider span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--white);
            font-size: 0.95rem;
        }

        .signup-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #ffc233;
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-home a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .back-home a:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.9);
            color: var(--white);
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: none;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .success-message {
            background: rgba(40, 167, 69, 0.9);
            color: var(--white);
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }

            .logo-section h1 {
                font-size: 1.5rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    

    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-circle">
                    <img src="images/logo.jpg" alt="King's Dental Academy Logo">
                </div>
                <h1>King's Dental Academy</h1>
            </div>

            <div class="error-message" id="errorMessage">
                Invalid username or password
            </div>

            <div class="success-message" id="successMessage">
                Login successful! Redirecting...
            </div>

            <form id="loginForm" method="post" action="#">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username" 
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            👁️
                        </button>
                    </div>
                </div>
<!--
                <div class="form-options">
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
-->
                <button type="submit" class="login-btn" name="login">Login</button> 
            </form>
<!--
            <div class="divider">
                <span>or</span>
            </div>

            <div class="signup-link">
                Don't have an account? <a href="#">Sign up</a>
            </div>
-->
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');

        // Password visibility toggle
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
        });

      
        // Clear error on input
        document.getElementById('username').addEventListener('input', () => {
            errorMessage.style.display = 'none';
        });

        document.getElementById('password').addEventListener('input', () => {
            errorMessage.style.display = 'none';
        });

        // Forgot password handler
        document.querySelector('.forgot-password').addEventListener('click', (e) => {
            e.preventDefault();
            alert('Password reset functionality will be implemented soon!');
        });

        // Sign up handler
        document.querySelector('.signup-link a').addEventListener('click', (e) => {
            e.preventDefault();
            alert('Sign up page coming soon!');
        });
    </script>

    <?php
        require_once "db_conn.php";
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $userpassword = $_POST['password'];

            // 3. Prepare SQL query to prevent SQL injection
            $stmt = $conn->prepare("SELECT `uname`, `password` FROM `users` WHERE binary(`uname`) = ? AND binary(`password`) = ?");
            $stmt->bind_param("ss", $username, $userpassword); // "ss" = 2 strings

            $stmt->execute();
            $stmt->store_result();

            // 4. Check if a row exists
            if ($stmt->num_rows > 0) {
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;

                echo "<script>document.getElementById('successMessage').style.display='block';</script>";
                echo "<script>window.location.href='enquirydetails.php'</script>";

            } else {
                echo "<script>document.getElementById('errorMessage').style.display='block';</script>";
                echo "<script>window.location.href='index.php'</script>";
            }

            $stmt->close();
        }

        $conn->close();
    ?>


</body>
</html>