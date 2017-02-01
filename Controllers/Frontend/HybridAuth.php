<?php

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

/**
 * Class Shopware_Controllers_Frontend_HybridAuth
 */
class Shopware_Controllers_Frontend_HybridAuth extends \Enlight_Controller_Action
{

    /**
     * action index
     */
    public function indexAction()
    {
        if ($this->Request()->getParam('hauth_done')) {
            $_REQUEST['hauth_done'] = $this->Request()->getParam('hauth_done');
        }

        \Hybrid_Endpoint::process();
    }

}