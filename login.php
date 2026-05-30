<?php                                                          //backend authentication + a modern animated frontend UI
error_reporting(E_ALL);                                        //error handling and reporting
ini_set('display_errors', 1);

session_start();
include "db.php";                                              //connect database

$error = "";                                                  //store error meaasge if login fails

//only runs when user click on sign in 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);                          //login successful
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);             // ss-> both values are string
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['id'] = $row['id'];
        $_SESSION['user'] = $row['username'];

        header("Location: dashboard.php");                //redirect to dashboard
        exit();
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>                                           <!-- holds entire login interface --> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">  <!-- loads poppins form from google -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Particles */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120,119,198,0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120,219,255,0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {                                          /*@keyframes are used to create animations in css*/
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            display: flex;
            max-width: 900px;
            width: 95%;
            height: 550px;
            overflow: hidden;
            position: relative;
            z-index: 2;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-image {
            flex: 1;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            background-size: 400% 400%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1.5" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.8" fill="rgba(255,255,255,0.08)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            animation: grain 8s steps(10) infinite;
            opacity: 0.3;
        }

        @keyframes grain {
            0%, 100% { transform: translate(0, 0); }
            10% { transform: translate(-5%, -5%); }
            20% { transform: translate(-10%, 5%); }
            30% { transform: translate(5%, -10%); }
            40% { transform: translate(-5%, 15%); }
            50% { transform: translate(-10%, 5%); }
            60% { transform: translate(15%, 0%); }
            70% { transform: translate(0%, 10%); }
            80% { transform: translate(-15%, 0%); }
            90% { transform: translate(10%, -5%); }
        }

        .login-image i {
            font-size: 8rem;
            color: rgba(255,255,255,0.9);
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: bounce 2s ease-in-out infinite;
            z-index: 2;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        .login-form {
            flex: 1;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-form h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-form p.subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .error-message {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 8px 25px rgba(255,107,107,0.3);
            animation: shake 0.5s ease-in-out;
            border-left: 5px solid #ff4757;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            padding: 18px 20px 18px 50px;
            border: 2px solid #e1e5e9;
            border-radius: 15px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            background: rgba(255,255,255,0.8);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 10px 30px rgba(102,126,234,0.2);
            transform: translateY(-2px);
            background: rgba(255,255,255,1);
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 18px;
            transition: 0.3s ease;
        }

        .form-group input:focus + i,
        .form-group input:not(:placeholder-shown) + i {
            color: #667eea;
        }

        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(102,126,234,0.3);
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(102,126,234,0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .register-link {
            text-align: center;
        }

        .register-link p {
            color: #666;
            font-size: 15px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {                     /*Applies styles only when screen width ≤ 768px Typically targets mobile devices*/
            .login-container {
                flex-direction: column;
                height: auto;
                margin: 20px;
            }
            
            .login-image {
                height: 250px;
            }
            
            .login-image i {
                font-size: 5rem;
            }
            
            .login-form {
                padding: 40px 30px;
            }
        }

        /* Floating Elements */
        .floating-shape {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: floatShape 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes floatShape {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }
    </style>
</head>

<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>

    <div class="login-container">
        <div class="login-image">
            <i class="fas fa-user-shield"></i>
        </div>

        <div class="login-form">
            <h2>Welcome Back</h2>
            <p class="subtitle">Sign in to your account</p>

            <?php if($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-lock"></i>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="register-link">
                <p>New user? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>

    <script>
        // Add effects
        document.querySelectorAll('.form-group input').forEach(input => {            //JavaScript for adding interactive effects to your form inputs.
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Password visibility toggle
        const passwordInput = document.querySelector('input[type="password"]');
        const lockIcon = passwordInput.nextElementSibling;
        
        lockIcon.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>