<?php

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

/**
 * Class Shopware_Controllers_Frontend_Typo3Login
 */
class Shopware_Controllers_Frontend_Typo3Login extends \Enlight_Controller_Action
{

    /**
     * forbidden action
     */
    public function forbiddenAction()
    {
        $this->Response()->setHttpResponseCode(403);
    }

    /**
     * logoutaction
     */
    public function logoutAction()
    {
    }
}