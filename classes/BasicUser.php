<?php
require_once 'User.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repo/PostRepo.php';
require_once __DIR__ . '/../repo/CommentRepo.php';
require_once __DIR__ . '/Post.php';

class BasicUser extends User {
    
    private int $monthly_uploads;
    private array $PostUser;

    public function __construct(string $username, string $email, string $password, string $role, $PostUser = [], ?int $id = null, ?string $bio = null, ?string $profile_picture = null, bool $is_active = true, ?DateTime $created_at = null, ?DateTime $last_login = null, int $monthly_uploads = 0) 
    {
        parent::__construct(
            $username, $email, $password, $role, $id, $bio, 
            $profile_picture, $is_active, $created_at, $last_login
        );
        $this->monthly_uploads = $monthly_uploads;
        $this->PostUser = $PostUser;
    }

    public function getAllPostUser() { return $this->PostUser; }
    public function InsetToArrayPost(array $allpost) { $this->PostUser = $allpost; }

    public function createPost(Post $post) 
    {
        $PostRepo = new PostRepo();
        if ($PostRepo->InsertPost($post)) {
            $this->GetPostUser();
        }
    }
    
    public function GetPostUser()
    {
        $PostRepo = new PostRepo();
        $allPost = $PostRepo->getPosts($this->getId());
        $this->InsetToArrayPost($allPost);
        return $this->getAllPostUser();
    }

    public function addComment(Comment $comm) 
    {
        $commentRepo = new CommentRepo();
        return $commentRepo->AddComment($comm);
    }

    public static function getCommentsByPostId($postId) {
        $commentRepo = new CommentRepo();
        return $commentRepo->getCommentsByPostId($postId);
    }

    public function deletePost($postID)
    {
        $PostRepo = new PostRepo();
        return $PostRepo->deletePost($postID);
    }
}
?>