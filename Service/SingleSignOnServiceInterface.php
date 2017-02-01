<?php
namespace Port1HybridAuth\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Andre Wuttig <wuttig@portrino.de>, portrino GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class SingleSignOnServiceInterface
 * @package Port1HybridAuth\Service
 */
interface SingleSignOnServiceInterface
{
    /**
     * the overall method for the SSO workflow
     *
     * @param $provider string the authsource string (e.g.: linkedin, ...)
     * @return bool
     */
    public function loginAndRegisterVia($provider);

    /**
     * logout from provider
     *
     * @return bool TRUE if the logout was successful, FALSE if not
     */
    public function logout();
}