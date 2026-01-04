<?php
require_once __DIR__ . '/../config/Database.php';

class Comment {
    private ?int $id;
    private int $user_id;
    private int $post_id;
    private string $content;
    private ?string $created_at;

    public function __construct(int $user_id, int $post_id, string $content, ?int $id = null, ?string $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    public function getId() {return $this->id;}
    public function getUserId(){return $this->user_id;}
    public function getPostId(){return $this->post_id;}
    public function getContent(){return $this->content;}
    public function getCreatedAt() {return $this->created_at;}
}
?>