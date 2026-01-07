<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/User.php';

class UserRepo 
{
    public function AddUser(User $user)
    {
        $db = Database::getConnection();

        $sql = "INSERT INTO users (username, email, password_hash, role, bio, profile_picture, is_active, created_at, last_login) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";        
        $stmt = $db->prepare($sql);
        $createdAt = ($user->getCreatedAt()) ? $user->getCreatedAt()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
        $lastLogin = null;
        if ($user->getLastLogin() !== null) {
            $lastLogin = $user->getLastLogin()->format('Y-m-d H:i:s');
        }

        $result = $stmt->execute([$user->getUsername(),$user->getEmail(),$user->getPassword(),
            $user->getRole(),$user->getBio(),$user->getProfilePicture(),$user->isActive(),
            $createdAt,$lastLogin
        ]);

        if ($result) 
        {
            $newId = $db->lastInsertId();
            $user->setId($newId); 
            return true;
        }
        return false;
    }

    public function DeleteUser(User $user)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM users WHERE id = ?"; 
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$user->getId()]))
            return true; 
        return false;
    }

    public function UpdateUser(User $user)
    {
        $db = Database::getConnection();

        $sql = "UPDATE users SET username = ?, email = ?, password_hash = ?, 
                bio = ?, profile_picture = ?, is_active = ?
                WHERE id = ?";

        $stmt = $db->prepare($sql);
        $isActive = $user->isActive();
        
        return $stmt->execute([$user->getUsername(),$user->getEmail(),$user->getPassword(),
            $user->getBio(),$user->getProfilePicture(),$isActive,$user->getId()
        ]);
    }
}
?>