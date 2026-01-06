<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repo/CommentRepo.php';

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

    public static function NewCommentData($userID, $postID, $Content)
    {
        $repo = new CommentRepo();

        $com = new Comment($userID, $postID, $Content);
        if ($repo->AddComment($com))
            echo "Comment Added";
        else
            echo "Comment NOT Added";
    }

    public static function DeleteCom($idComment)
    {
        echo $idComment;
        $repo = new CommentRepo();
        if ($repo->DeleteComment($idComment))
            echo "Comment with id : " . $idComment . "Deleted";
        else
            echo "Comment with id : " . $idComment . "Not Deleted";
    }

    public static function CommentPost($postID)
    {
        $repo = new CommentRepo();
        $Comments = $repo->getCommentsByPostId($postID);
        // var_dump($Comments);
        foreach($Comments as $comment)
        {
            echo "id Comment : " . $comment->getId() . "<br>";
            echo "Use ID : " . $comment->getUserId() . "<br>";
            echo "Post ID : " . $comment->getPostId() . "<br>";
            echo "Content : " . $comment->getContent() . "<br>";
        }
    }
}
?>