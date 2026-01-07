<?php

interface Commentable 
{
    public function AddComment(Comment $com);
    public function DeleteComment($ComId);
    public function getCommentsByPostId($postId);
}