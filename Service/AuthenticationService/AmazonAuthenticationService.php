<?php

namespace Port1HybridAuth\Service\AuthenticationService;



use Port1HybridAuth\Model\User;
use Port1HybridAuth\Service\AbstractAuthenticationService;

/**
 * Class AmazonAuthenticationService
 * @package Port1HybridAuth\Service\AuthenticationService
 */
class AmazonAuthenticationService extends AbstractAuthenticationService
{

    /**
     * @return User|null
     */
    public function getUser()
    {
        $user = parent::getUser();

        if ($user != null) {
            $userProfil = $this->getUserProfile();


            // we can use displayName to determine the firstName and lastName by exploding the space delimiter
            if (empty($userProfil->displayName) === false) {
                list($firstName, $lastName) = explode(' ', $userProfil->displayName);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
            }
        }

        return $user;
    }
}
