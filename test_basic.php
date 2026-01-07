<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/BasicUser.php';
require_once __DIR__ . '/classes/Post.php';
require_once __DIR__ . '/classes/Comment.php';

require_once __DIR__ . '/repo/UserRepo.php';
require_once __DIR__ . '/repo/PostRepo.php';
require_once __DIR__ . '/repo/CommentRepo.php';

// Create User
$rand = rand(1000, 9999);
$username = "TestUser_" . $rand;
$email = "user" . $rand . "@test.com";

$user = new BasicUser(
    $username, 
    $email, 
    password_hash('123456', PASSWORD_DEFAULT), 
    'basic'
);

$userRepo = new UserRepo();

$userRepo->AddUser($user);

$post = new Post(
    $user->getId(),
    "Post Test ($rand)",
    "this is description for  post number $rand. Test auto.",
    "uploads/test_image.jpg"
);

$postRepo = new PostRepo();

$db = Database::getConnection();
$postRepo->InsertPost($post);
$newPostId = $db->lastInsertId();

if ($newPostId)
    echo "Created";
else 
    echo "Not create";

// User ID + Post ID + Content
$comment = new Comment(
    $user->getId(), 
    $newPostId, 
    "Nice"
);

if ($user->addComment($comment))
    echo "Comment Added";
else 
    echo "Not Add comment";

echo "User " . $user->getUsername() . "id: " . $user->getId() . "<br>";
echo "Post ID: " . $newPostId . "<br>";
echo "Comment Link: User[" . $user->getId() . "] -> Post[" . $newPostId . "]<br>";

?>