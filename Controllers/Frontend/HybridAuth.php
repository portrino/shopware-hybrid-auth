<?php

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
        \Hybrid_Endpoint::process();
    }
}
