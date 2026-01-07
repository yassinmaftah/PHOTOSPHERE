<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Like.php';

class LikeRepo {
    
    public function isLiked(int $userId, int $postId): bool 
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM likes WHERE user_id = ? AND post_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId, $postId]);
        return $stmt->fetchColumn() > 0;
    }
    public function toggleLike(int $userId, int $postId): string 
    {
        $db = Database::getConnection();

        if ($this->isLiked($userId, $postId)) 
        {
            $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$userId, $postId]);
            return "removed";
        } 
        else 
        {
            $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$userId, $postId]);
            return "added";
        }
    }

    public function countLikes(int $postId): int 
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM likes WHERE post_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId]);
        
        return (int) $stmt->fetchColumn();
    }
}
?>