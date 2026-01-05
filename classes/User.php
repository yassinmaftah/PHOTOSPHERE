<?php
require_once __DIR__ . '/../config/Database.php';
require_once 'BasicUser.php';
require_once 'ProUser.php';
require_once 'Administrator.php';
require_once 'Moderator.php';

class User {
    protected ?int $id;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $role;
    protected ?string $bio;
    protected ?string $profile_picture;
    protected bool $is_active;
    protected DateTime $created_at;
    protected ?DateTime $last_login;

    protected $db;
    public function __construct(string $username, string $email, string $password, string $role, 
        ?int $id = null,?string $bio = null,?string $profile_picture = null,bool $is_active = true,
        ?DateTime $created_at = null,
        ?DateTime $last_login = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->bio = $bio;
        $this->profile_picture = $profile_picture;
        $this->is_active = $is_active;
        $this->last_login = $last_login;
        $this->created_at = $created_at ?? new DateTime();
        $this->db = Database::getConnection();
    }

    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRole(): string { return $this->role; }
    public function getBio(): ?string { return $this->bio; }
    public function getProfilePicture(): ?string { return $this->profile_picture; }
    public function isActive(): bool { return $this->is_active; }
    public function getCreatedAt(): DateTime { return $this->created_at; }
    public function getLastLogin(): ?DateTime { return $this->last_login; }
    public function setId(int $id): void { $this->id = $id; }
    public function setBio(string $bio): void { $this->bio = $bio; }
    public function setProfilePicture(string $url): void { $this->profile_picture = $url; }
    public function setActive(bool $status): void { $this->is_active = $status; }
    public function setLastLogin(DateTime $date): void { $this->last_login = $date; }

    public static function getUserById($id) 
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        
        $User = $stmt->fetch();

        if ($User) {
            if ($User['role'] = 'admin')
                return new Administrator($User['username'], $User['email'], $User['password_hash'], $User['role'], $User['id'], $User['bio'], $User['profile_picture'], $User['is_active'], new DateTime($User['created_at']), $User['last_login'] ? new DateTime($User['last_login']) : null, $User['is_super_admin']);
            else if ($User['role'] = 'pro')
                return new ProUser($User['username'], $User['email'], $User['password_hash'], $User['role'], $User['id'], $User['bio'], $User['profile_picture'], $User['is_active'], new DateTime($User['created_at']), $User['last_login'] ? new DateTime($User['last_login']) : null, $User['monthly_uploads'], $User['subscription_start'] ? new DateTime($User['subscription_start']) : null, $User['subscription_end'] ? new DateTime($User['subscription_end']) : null);
            else if ($User['role'] = 'moderator')
                return new Moderator($User['username'], $User['email'], $User['password_hash'], $User['role'], $User['id'], $User['bio'], $User['profile_picture'], $User['is_active'], new DateTime($User['created_at']), $User['last_login'] ? new DateTime($User['last_login']) : null, $User['moderator_level']);
            else 
                return new BasicUser($User['username'], $User['email'], $User['password_hash'], $User['role'], $User['id'], $User['bio'], $User['profile_picture'], $User['is_active'], new DateTime($User['created_at']), $User['last_login'] ? new DateTime($User['last_login']) : null, $User['monthly_uploads']);
        }
        return null;
    }

    public static function  login($email,$password)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash']))
        {
            if ($user['role'] == "admin")
            {
                return new Administrator 
                (
                    $user['username'], $user['email'], $user['password_hash'], $user['role'], 
                    $user['id'], $user['bio'], $user['profile_picture'], $user['is_active'], 
                    new DateTime($user['created_at']), 
                    $user['last_login'] ? new DateTime($user['last_login']) : null,
                    $user['is_super_admin']
                );
            }
            else if ($user['role'] == "pro")
            {
                return new ProUser
                (
                    $user['username'], $user['email'], $user['password_hash'], $user['role'], 
                    $user['id'], $user['bio'], $user['profile_picture'], $user['is_active'], 
                    new DateTime($user['created_at']), 
                    $user['last_login'] ? new DateTime($user['last_login']) : null,
                    $user['monthly_uploads'],
                    $user['subscription_start'] ? new DateTime($user['subscription_start']) : null,
                    $user['subscription_end'] ? new DateTime($user['subscription_end']) : null
                );
            }
            else if ($user['role'] == "moderator")
            {
                return new Moderator
                (
                    $user['username'], $user['email'], $user['password_hash'], $user['role'], 
                    $user['id'], $user['bio'], $user['profile_picture'], $user['is_active'], 
                    new DateTime($user['created_at']), 
                    $user['last_login'] ? new DateTime($user['last_login']) : null,
                    $user['moderator_level']
                );
            }
            else
            {
                return new BasicUser
                (
                    $user['username'], $user['email'], $user['password_hash'], $user['role'], 
                    $user['id'], $user['bio'], $user['profile_picture'], $user['is_active'], 
                    new DateTime($user['created_at']), 
                    $user['last_login'] ? new DateTime($user['last_login']) : null,
                    $user['monthly_uploads']
                );
            }
        }

        return false;
    }

    public static function userExists($username, $email) {
        $db = Database::getConnection();
        
        $sql = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$username, $email]);
        
        return $stmt->fetchColumn() > 0;
    }

    public static function signup($username, $email, $password) {
        $db = Database::getConnection();

        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users 
                (username, email, password_hash, role, is_active, created_at, monthly_uploads) 
                VALUES 
                (?, ?, ?, 'basic', 1, NOW(), 0)";
        
        $stmt = $db->prepare($sql);

        $valid =  $stmt->execute([$username,$email,$hashedPass]);
        if ($valid)
            return true;
        return false;
    }
}
?>