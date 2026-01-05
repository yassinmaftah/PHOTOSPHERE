<?php
require_once __DIR__ . '/../config/Database.php';
class UserRepo 
{
    public function InsertPost(Post $post)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO posts (user_id, title, description, file_path, file_size, mime_type, dimensions, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$post->getUserId(),$post->getTitle(),
            $post->getDescription(),$post->getFilePath(),$post->getFileSize(),
            $post->getMimeType(),$post->getDimensions()]))
        {
            return $post;
        }
    }

    public function getPosts($userID)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userID]);
        $postsData = $stmt->fetchAll();
        $postsList = [];
        foreach ($postsData as $row) {$postsList[] = new Post($row['user_id'],$row['title'],$row['description'],$row['file_path'],0,$row['id'],$row['created_at']);}
        return $postsList;
    }
}