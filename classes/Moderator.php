<?php
require_once 'User.php';

class Moderator extends User {

    private string $moderator_level;

    public function __construct(string $username, string $email, string $password, string $role,?int $id = null, 
        ?string $bio = null,?string $profile_picture = null,bool $is_active = true,?DateTime $created_at = null,
        ?DateTime $last_login = null,string $moderator_level = 'Junior'
    ) 
    {
        parent::__construct($username, $email, $password, $role, $id, $bio, $profile_picture, $is_active, $created_at, $last_login);
        $this->moderator_level = $moderator_level;
    }

    public function getModeratorLevel(): string { 
        return $this->moderator_level; 
    }

    public function setModeratorLevel(string $level): void { 
        $this->moderator_level = $level; 
    }
}
?>