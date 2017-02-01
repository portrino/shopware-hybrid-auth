<?php

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

/**
 * Class Shopware_Controllers_Frontend_SocialUser
 */
class Shopware_Controllers_Frontend_SocialUser extends \Enlight_Controller_Action
{

    /**
     *
     */
    public function preDispatch()
    {
        /** @var \Shopware\Components\Plugin $plugin */
        $plugin = $this->get('kernel')->getPlugins()['Port1HybridAuth'];
        $this->get('template')->addTemplateDir($plugin->getPath() . '/Resources/views/');
    }

    /**
     * action login
     */
    public function loginAction()
    {
        $provider = $this->Request()->getParam('provider');

        if ($provider) {
            /** @var \Port1HybridAuth\Service\SingleSignOnService $singleSignOnService */
            $singleSignOnService = $this->container->get('port1_hybrid_auth.single_sign_on_service');
            $isUserLoggedIn = $singleSignOnService->loginAndRegisterVia($provider);

            if ($isUserLoggedIn) {
                return $this->redirect(
                    [
                        'controller' => $this->Request()->getParam('sTarget', 'account'),
                        'action' => $this->Request()->getParam('sTargetAction', 'index')
                    ]
                );
            }


            $this->forward('index', 'register', 'frontend', [
                'sTarget' => $this->Request()->getParam('sTarget')
            ]);

        } else {
            // @todo: redirect to referere or error?
        }

    }

}