<?php
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Administrator.php';
require_once __DIR__ . '/../classes/Moderator.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = User::login($email,$password);

    if ($user) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRole();

        if ($user instanceof Administrator) {
            header("Location: ../AdminDashboard.php"); 
        } 
        else if ($user instanceof Moderator)
        {
            header("Location: ../ModerateurDashboard.php");
        }
        else {
            header("Location: ../index.php");
        }
        exit();

    } else {
        $message = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - PhotoSphere</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; }
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>

    <form method="POST">
        <h2>Login</h2>
        
        <?php if ($message): ?>
            <span class="error"><?= $message; ?></span>
        <?php endif; ?>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Log In</button>
        
        <p style="text-align:center;">
            <a href="signup.php">Create an account</a>
        </p>
    </form>

</body>
</html>