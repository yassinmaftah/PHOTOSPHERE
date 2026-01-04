<?php
require_once 'User.php';
require_once __DIR__ . '/../config/Database.php';

class BasicUser extends User {
    
    private int $monthly_uploads;

    public function __construct(string $username, string $email, string $password, string $role, ?int $id = null, ?string $bio = null,?string $profile_picture = null,
    bool $is_active = true,?DateTime $created_at = null,?DateTime $last_login = null,int $monthly_uploads = 0 ) 
    {
        parent::__construct(
            $username, $email, $password, $role, $id, $bio, 
            $profile_picture, $is_active, $created_at, $last_login
        );
        $this->monthly_uploads = $monthly_uploads;
    }

    public function createPost(Post $post) {
        $db = Database::getConnection();

        $sql = "INSERT INTO posts (user_id, title, description, file_path, file_size, mime_type, dimensions, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $db->prepare($sql);

        return $stmt->execute([$post->getUserId(),$post->getTitle(),
            $post->getDescription(),$post->getFilePath(),$post->getFileSize(),
            $post->getMimeType(),$post->getDimensions()]);
    }

    public function addComment(Comment $comm) 
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$comm->getUserId(), $comm->getPostId(), $comm->getContent()]);
    }

    public static function getCommentsByPostId($postId) {
        $db = Database::getConnection();
        $sql = "SELECT comments.*, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE post_id = ? 
                ORDER BY created_at ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }
}
?>