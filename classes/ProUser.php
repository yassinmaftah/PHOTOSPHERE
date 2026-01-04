<?php
require_once 'BasicUser.php';

class ProUser extends BasicUser {
    
    private ?DateTime $subscription_start;
    private ?DateTime $subscription_end;

    public function __construct(string $username, string $email, string $password, string $role, ?int $id = null, ?string $bio = null,
                        ?string $profile_picture = null,bool $is_active = true,?DateTime $created_at = null,?DateTime $last_login = null,
                        int $monthly_uploads = 0,?DateTime $subscription_start = null,?DateTime $subscription_end = null
    ) {
        parent::__construct($username, $email, $password, $role, $id, $bio, 
                            $profile_picture, $is_active, $created_at, $last_login, $monthly_uploads
        );

        $this->subscription_start = $subscription_start;
        $this->subscription_end = $subscription_end;
    }

    public function getSubscriptionStart(): ?DateTime { return $this->subscription_start; }
    public function getSubscriptionEnd(): ?DateTime { return $this->subscription_end; }
    
    public function setSubscriptionStart(DateTime $date) { $this->subscription_start = $date; }
    public function setSubscriptionEnd(DateTime $date) { $this->subscription_end = $date; }
}
?>