<?php
require_once __DIR__ . '/../config/Database.php';
require_once 'Comment.php';

class Post {
    private ?int $id;
    private int $user_id;
    private string $title;
    private string $description;
    private string $file_path; 
    private int $file_size;
    private string $mime_type;
    private string $dimensions;
    private ?string $created_at;
    private ?string $status;

    public function __construct(int $user_id, string $title, string $description, string $file_path, int $file_size = 0,
        string $mime_type = 'image/jpeg', string $dimensions = '0x0',$status = "Published",?int $id = null, ?string $created_at = null
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->file_path = $file_path;
        $this->file_size = $file_size;
        $this->mime_type = $mime_type;
        $this->dimensions = $dimensions;
        $this->created_at = $created_at;
        $this->status = $status;
    }
    

    public static function getAllPosts() 
    {
        $db = Database::getConnection();
        $sql = "SELECT posts.*, users.username, users.profile_picture 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.created_at DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getFilePath() { return $this->file_path; }
    public function getUserId() { return $this->user_id; }
    public function getFileSize() { return $this->file_size; }
    public function getMimeType() { return $this->mime_type; }
    public function getDimensions() { return $this->dimensions; }
    public function getCreatedAt() { return $this->created_at; }
}
?>