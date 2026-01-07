<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Comment.php';
require_once __DIR__ . '/../interfaces/Commentable.php';

class CommentRepo implements Commentable 
{
    public function AddComment (Comment $com)
    {
        $db = Database::getConnection();
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        
        if ($stmt->execute([$com->getUserId(),$com->getPostId(),$com->getContent()]))
            return true;
        return false;
    }

    public function DeleteComment($ComId)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $db->prepare($sql);
        echo $ComId;
        if ($stmt->execute([$ComId]))
            return true;
        return false;
    }

    public function getCommentsByPostId($postId):array {
        $db = Database::getConnection();
        $AllComments = [];
        $sql = "SELECT comments.*, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE post_id = ? 
                ORDER BY created_at ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId]);
        $CommentArray = $stmt->fetchAll();
        foreach($CommentArray as $comment)
        {
            $comment = new Comment($comment['user_id'],$comment['post_id'],$comment['content'],$comment['id'],$comment['created_at']);
            $AllComments[] = $comment;
        }
        return $AllComments;
    }

}