<?php

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
    private string $status;

    public function __construct(
        int $user_id, 
        string $title, 
        string $description, 
        string $file_path, 
        int $file_size = 0,
        string $mime_type = 'image/jpeg', 
        string $dimensions = '0x0',
        string $status = "Published",
        ?int $id = null, 
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->file_path = $file_path;
        $this->file_size = $file_size;
        $this->mime_type = $mime_type;
        $this->dimensions = $dimensions;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getFilePath(): string { return $this->file_path; }
    public function getFileSize(): int { return $this->file_size; }
    public function getMimeType(): string { return $this->mime_type; }
    public function getDimensions(): string { return $this->dimensions; }
    public function getStatus(): string { return $this->status; }
    public function getCreatedAt(): ?string { return $this->created_at; }
    
    public function setId(int $id): void { $this->id = $id; }
}
?>