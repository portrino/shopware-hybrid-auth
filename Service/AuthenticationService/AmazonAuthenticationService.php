<?php

namespace Port1HybridAuth\Service\AuthenticationService;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

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