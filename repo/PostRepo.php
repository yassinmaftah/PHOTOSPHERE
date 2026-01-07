<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Post.php';

class PostRepo 
{
    public function InsertPost(Post $post)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO posts (user_id, title, description, file_path, file_size, mime_type, dimensions, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$post->getUserId(),$post->getTitle(),$post->getDescription(),$post->getFilePath(),
            $post->getFileSize(),$post->getMimeType(),$post->getDimensions(),$post->getStatus()
        ])) 
        {return $post;}
        return null;
    }

    public function getPosts($userID)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userID]);
        
        $postsData = $stmt->fetchAll();
        $postsList = [];

        foreach ($postsData as $P_Data) {
            $postsList[] = new Post($P_Data['user_id'],$P_Data['title'],$P_Data['description'],$P_Data['file_path'],
                                    $P_Data['file_size'],$P_Data['mime_type'],$P_Data['dimensions'],
                                    $P_Data['status'] ?? 'Published',$P_Data['id'],$P_Data['created_at']
            );
        }
        return $postsList;
    }

    public function getAllPosts() 
    {
        $db = Database::getConnection();
        $sql = "SELECT posts.*, users.username, users.profile_picture 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.created_at DESC";
                
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public function deletePost($postID)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $db->prepare($sql); 
        if ($stmt->execute([$postID]))
            return true;
        return false;
    }
}