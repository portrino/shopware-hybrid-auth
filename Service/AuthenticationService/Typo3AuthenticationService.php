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
 * Class Typo3AuthenticationService
 *
 * @package Port1HybridAuth\Service\AuthenticationService
 */
class Typo3AuthenticationService extends AbstractAuthenticationService
{

    public function initialize()
    {
        var_dump('Typo3AuthenticationService->initialize()');exit;
    }
}
