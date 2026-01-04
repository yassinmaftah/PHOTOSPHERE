<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/BasicUser.php';
require_once 'classes/ProUser.php';
include_once 'classes/Post.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: views/login.php");
    exit();
}

$user = User::getUserById($_SESSION['user_id']);

// print_r($user);

// // public function getId(): ?int { return $this->id; }
// // public function getUsername(): string { return $this->username; }
// // public function getEmail(): string { return $this->email; }
// // public function getPassword(): string { return $this->password; }
// // public function getRole(): string { return $this->role; }
// // public function getBio(): ?string { return $this->bio; }
// // public function getProfilePicture(): ?string { return $this->profile_picture; }
// // public function isActive(): bool { return $this->is_active; }
// // public function getCreatedAt(): DateTime { return $this->created_at; }
// // public function getLastLogin(): ?DateTime { return $this->last_login; }

// echo "<br>";
// echo "<br>";
// echo $user->getId();
// echo "<br>";
// echo $user->getUsername();
// echo "<br>";
// echo $user->getEmail();
// echo "<br>";
// echo $user->getRole();
// echo "<br>";
// echo $user->getBio();
// echo "<br>";
// echo $user->getProfilePicture();
// echo "<br>";
// echo $user->isActive();
// echo "<br>";
// print_r($user->getCreatedAt()) ;
// echo "<br>";
// echo $user->getLastLogin();
// echo "<br>";

if (isset($_POST['submit']))
{
    $imageName = $_FILES['image_file']['name'];
    $imageTmpName = $_FILES['image_file']['tmp_name'];
    $imageSize = $_FILES['image_file']['size'];
    
    $targetfolder = 'upload/' . $imageName;
    
    move_uploaded_file($imageTmpName, $targetfolder);
    
    $userId = $user->getId();
    $Title = $_POST['Title'];
    $description = $_POST['description'];

    $post = new Post($userId,$Title,$description,$targetfolder,$imageSize);

    $user->createPost($post);
}

// $newComment = new Comment(11, 2, "Test Comment methods take object from comment claass");
// $user->addComment($newComment);
// print_r($user->getCommentsByPostId(2));


// $AllPost = Post::getAllPosts();

// print_r($AllPost);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Add New Post</h2>

            <label for="title">Title:</label>
            <input type="text"name="Title" placeholder="Enter a catchy title..." required>
            <br><br>
            <label for="image">Select Image:</label>
            <input type="file" name="image_file" accept="image/png, image/jpeg" required>
            <br><br>
            
            <label for="desc">Description:</label>
            <textarea name="description" rows="4"></textarea>
            <br><br>

        <button type="submit" name="submit">Upload Post</button>
    </form>

</body>
</html>