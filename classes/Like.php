<?php

class Like {
    private ?int $id;
    private int $user_id;
    private int $post_id;
    private ?string $created_at;

    public function __construct(int $user_id, int $post_id, ?int $id = null, ?string $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->created_at = $created_at;
    }

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getPostId(): int { return $this->post_id; }
    public function getCreatedAt(): ?string { return $this->created_at; }
}
?>