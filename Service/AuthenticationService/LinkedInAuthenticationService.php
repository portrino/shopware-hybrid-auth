<?php
namespace Port1HybridAuth\Service\AuthenticationService;

use Port1HybridAuth\Model\User;
use Port1HybridAuth\Service\AbstractAuthenticationService;

/**
 * Class LinkedInAuthenticationService
 *
 * @package Port1HybridAuth\Service\AuthenticationService
 */
class LinkedInAuthenticationService extends AbstractAuthenticationService
{
    /**
     * @return User|null
     */
    public function getUser()
    {
        $user = parent::getUser();

        if ($user != null) {
            $userProfil = $this->getUserProfile();
            // we can use country as isocode because it should be an ISO 3166-1 alpha-2 standard country code
            // https://developer.linkedin.com/docs/fields/location
            if (empty($userProfil->country) === false) {
                $user->setCountryIso($userProfil->country);
            }
        }

        return $user;
    }
}
