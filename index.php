<?php
// session_start();
// require_once 'classes/User.php';
// require_once 'classes/BasicUser.php';
// require_once 'classes/ProUser.php';
// include_once 'classes/Post.php';
// include_once 'classes/Comment.php';

// if (!isset($_SESSION['user_id'])) {
//     header("Location: views/login.php");
//     exit();
// }

// $user = User::getUserById($_SESSION['user_id']);

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

// if (isset($_POST['submit']))
// {
//     $imageName = $_FILES['image_file']['name'];
//     $imageTmpName = $_FILES['image_file']['tmp_name'];
//     $imageSize = $_FILES['image_file']['size'];
    
//     $targetfolder = 'upload/' . $imageName;
    
//     move_uploaded_file($imageTmpName, $targetfolder);
    
//     $userId = $user->getId();
//     $Title = $_POST['Title'];
//     $description = $_POST['description'];

//     $post = new Post($userId,$Title,$description,$targetfolder,$imageSize);

//     $user->createPost($post);
// }



// $AllPost = Post::getAllPosts();

// print_r($AllPost);
// print_r($user);
// $onePost = new Post($user->getId(), "one", "Description one","uploads/test1_image.jpg", 1024);
// $twoPost = new Post($user->getId(), "two", "Description two","uploads/test8_image.jpg", 104);
// $threePost = new Post($user->getId(), "three", "description three","uploads/test87_image.jpg", 1985);
// $user->createPost($onePost);
// $user->createPost($twoPost);
// $user->createPost($threePost);
// $userPostes = $user->getAllPostUser();

// foreach ($userPostes as $p)
// {
    //     echo "Title: " . $p->getTitle() . "<br>";
    //     echo "Description: " . $p->getDescription() . "<br>";
    //     echo "userID: " . $p->getUserId() . "<br>";
    //     echo "Created At: " . $p->getCreatedAt() . "<br>";
    //     echo "<br><br>";
    // }
    
// $newComment = new Comment(11, 2, "Test Comment methods take object from comment claass");
// Comment::DeleteCom(3);
// NewCommentData($userID, $postID, $Content)
// NewCommentData($userID, $postID, $Content)
// Comment::NewCommentData(15,1,"Nice Post");
// Comment::NewCommentData(11,1,"Gooo");
// Comment::NewCommentData(12,1,"Morocoo");
// Comment::NewCommentData(13,1,"This is soo Funny");
// Comment::NewCommentData(14,1,"Me too");
// Comment::NewCommentData(15,1,"HAHHAHA");

// Comment::CommentPost(1);


// test add user
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/BasicUser.php'; // 
require_once __DIR__ . '/repo/UserRepo.php';

$randomNum = rand(100, 999);
$username  = "TestUser_" . $randomNum;
$email     = "test_user" . $randomNum . "@gmail.com";
$password  = "123456";
$hashedPass = password_hash($password, PASSWORD_DEFAULT);

$newUser = new BasicUser(
    $username, 
    $email, 
    $hashedPass, 
    'basic',
    []
);

$newUser->setBio("Hada bio dyal test automatic.");
$newUser->setProfilePicture("uploads/default_avatar.png");

$userRepo = new UserRepo();

echo "<h2>Testing AddUser...</h2>";

if ($userRepo->AddUser($newUser)) {
    echo "<h3 style='color: green;'>Success! User added.</h3>";
    echo "<b>New User ID:</b> " . $newUser->getId() . "<br>";
    echo "<b>Username:</b> " . $newUser->getUsername() . "<br>";
    echo "<b>Email:</b> " . $newUser->getEmail() . "<br>";
    echo "<hr>";
    echo "Checking Database...<br>";
    
    $dbUser = User::getUserById($newUser->getId());
    if ($dbUser) {
        echo "User Fond it  (Role: " . $dbUser->getRole() . ")";
    } else {
        echo "Not fond in DB.";
    }

} else {
    echo "<h3 style='color: red;'>Failed to add user.</h3>";
}
// end test add user
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