<?php
require_once __DIR__ . '/../classes/User.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        if (User::signup($username, $email, $password)) {
            header("Location: login.php?msg=success");
            exit();
        } else {
            $message = "Something went wrong.";
        }
    } catch (PDOException $e) {
        if (str_contains($e->getMessage(), 'Duplicate')) {
            $message = "Username or Email already exists!";
        } else {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; }
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Create Account</h2>
        <?php if ($message): ?><span class="error"><?= $message; ?></span><?php endif; ?>
        
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Sign Up</button>
        <p style="text-align:center;"><a href="login.php">Login here</a></p>
    </form>
</body>
</html>