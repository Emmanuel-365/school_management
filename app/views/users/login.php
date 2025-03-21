<?php

use App\Config\Database;
use App\Controllers\UserController;
use App\Controllers\StudentController;




$database = new Database();

$db = $database->getConnection();

if(isset($_SESSION['user_id']))
   chooseDashboard($userController, $db);

function chooseDashboard($userController, $db){
    switch ($_SESSION['user_role']) {
        case 'admin':
            header('Location: /admin');
            break;

        case 'student':
            $studentController = new StudentController($db);   
            if($studentController->checkIsValidPassword($_SESSION['user_id'])){
                header('Location: /student');
                break;
            }else{
                header('Location: /change-password');
                break;
            }

        case 'teacher':
            header('Location: /teacher');
            break;
        
        default:
            echo 'Erreur au cours de la connexion';
            break;
    }
}


// Initialisation des contrôleurs
$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userController->login($username, $password)) {
        chooseDashboard($userController, $db);
    } else {
        echo 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Formulaire de connexion</title>
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #fdfdfd;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }
        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }
        .shape:first-child {
            background: linear-gradient(#1845ad, #23a2f6);
            left: -80px;
            top: -80px;
        }
        .shape:last-child {
            background: linear-gradient(to right, #ff512f, #f09819);
            right: -30px;
            bottom: -80px;
        }
        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }
        form * {
            font-family: 'Poppins', sans-serif;
            color: #080710;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }
        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }
        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(52, 44, 35, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }
        ::placeholder {
            color: #080710;
        }
        button {
            margin-top: 50px;
            width: 100%;
            background-color: #080710;
            color: #ffffff;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }
        .social {
            margin-top: 30px;
            display: flex;
        }
        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }
        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }
        .social .fb {
            margin-left: 25px;
        }
        .social i {
            margin-right: 4px;
        }
        /* CSS for the logo */
        img {
            display: block;
            margin: 0 auto 20px; /* Center the logo and add margin below */
            width: 30%; /* Adjust the width as needed */
            max-width: 200px; /* Maximum width */
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="#">
        <img src="../images/Keyce_logo.png" alt="logo">
        <!-- <center><h4>LOGIN</h4></center> -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?= $error_message; ?></p>
        <?php endif; ?>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>