<?php
require_once 'User.php';

class Administrator extends User {
    
    private bool $is_super_admin;

    public function __construct(string $username, string $email, string $password, string $role,?int $id = null, ?string $bio = null,
        ?string $profile_picture = null,bool $is_active = true,?DateTime $created_at = null,?DateTime $last_login = null,bool $is_super_admin = false
    ) {
        parent::__construct($username, $email, $password, $role, $id, $bio, $profile_picture, $is_active, $created_at, $last_login);
        $this->is_super_admin = $is_super_admin;
    }

    public function isSuperAdmin() { return $this->is_super_admin; }
    public function setSuperAdmin(bool $status) { $this->is_super_admin = $status; }
}
?>