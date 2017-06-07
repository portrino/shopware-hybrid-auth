<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | https://github.com/hybridauth/hybridauth
*  (c) 2009-2015 HybridAuth authors | hybridauth.sourceforge.net/licenses.html
*/
use Facebook\PersistentData\PersistentDataFactory;
use Facebook\PersistentData\PersistentDataInterface;
use Facebook\PseudoRandomString\PseudoRandomStringGeneratorFactory;
use Facebook\PseudoRandomString\PseudoRandomStringGeneratorInterface;

/**
 * Hybrid_Providers_Typo3 provider adapter based on OAuth2 protocol
 *
 * The Provider is very similar to standard Oauth2 providers with a few differences:
 * - it sets the Content-Type header explicitly to application/x-www-form-urlencoded
 *   as required by Amazon
 * - it uses a custom OAuth2Client, because the built-in one does not use http_build_query()
 *   to set curl POST params, which causes cURL to set the Content-Type to multipart/form-data
 *
 * @property Typo3OAuth2Client $api
 */
class Hybrid_Providers_Typo3 extends Hybrid_Provider_Model_OAuth2
{

    /**
     * @const int The length of CSRF string to validate the login link.
     */
    const CSRF_LENGTH = 32;

    /**
     * Provider API wrapper
     * @var Typo3OAuth2Client
     */
    public $api = null;

    /**
     * @var PersistentDataInterface
     */
    protected $persistentDataHandler = null;

    /**
     * @var PseudoRandomStringGeneratorInterface
     */
    protected $pseudoRandomStringGenerator = null;

    /**
     * IDp wrappers initializer
     */
    function initialize()
    {

        if (!$this->config['keys']['id'] || !$this->config['keys']['secret']) {
            throw new Exception("Your application id and secret are required in order to connect to {$this->providerId}.",
                4);
        }

        // override requested scope
        if (isset($this->config['scope']) && !empty($this->config['scope'])) {
            $this->scope = $this->config['scope'];
        }

        // include OAuth2 client
        require_once Hybrid_Auth::$config['path_libraries'] . 'OAuth/OAuth2Client.php';
        require_once Hybrid_Auth::$config['path_libraries'] . 'Typo3/Typo3OAuth2Client.php';

        require_once Hybrid_Auth::$config['path_libraries'] . 'Typo3/PersistentData/PersistentDataInterface.php';
        require_once Hybrid_Auth::$config['path_libraries'] . 'Typo3/PersistentData/SessionPersistentDataHandler.php';

        // create a new OAuth2 client instance
        $this->api = new Typo3OAuth2Client(
            $this->config['keys']['id'],
            $this->config['keys']['secret'],
            $this->endpoint,
            $this->compressed
        );

        $this->api->api_base_url = 'http://finance-magazin.de.192.168.1.203.nip.io/';
        $this->api->authorize_url = 'http://finance-magazin.de.192.168.1.203.nip.io/api/oauth2/authorize/';
        $this->api->token_url = 'http://finance-magazin.de.192.168.1.203.nip.io/api/oauth2/token/';

        $this->api->curl_header = array('Content-Type: application/x-www-form-urlencoded');

        // If we have an access token, set it
        if ($this->token('access_token')) {
            $this->api->access_token = $this->token('access_token');
            $this->api->refresh_token = $this->token('refresh_token');
            $this->api->access_token_expires_in = $this->token('expires_in');
            $this->api->access_token_expires_at = $this->token('expires_at');
        }

        // Set curl proxy if exists
        if (isset(Hybrid_Auth::$config['proxy'])) {
            $this->api->curl_proxy = Hybrid_Auth::$config['proxy'];
        }

        $this->persistentDataHandler = PersistentDataFactory::createPersistentDataHandler('session');
        $this->pseudoRandomStringGenerator = PseudoRandomStringGeneratorFactory::createPseudoRandomStringGenerator('');
    }

    /**
     * {@inheritdoc}
     */
    function loginBegin()
    {
        $state = $this->persistentDataHandler->get('state') ?: $this->pseudoRandomStringGenerator->getPseudoRandomString(static::CSRF_LENGTH);
        $this->persistentDataHandler->set('state', $state);

        $parameters = ['state' => $state];
        $optionals = ['redirect_uri', 'state'];

        foreach ($optionals as $parameter) {
            if (isset($this->config[$parameter]) && !empty($this->config[$parameter])) {
                $parameters[$parameter] = $this->config[$parameter];
            }
            if (isset($this->config['state']) && !empty($this->config['state'])) {
                $this->scope = $this->config['state'];
            }
        }

        Hybrid_Auth::redirect($this->api->authorizeUrl($parameters));
    }

    /**
     * load the user profile from the IDp api client
     */
    function getUserProfile()
    {
        $fields = [
            'uid',
            'name',
            'first_name',
            'last_name',
            'email',
            'address',
            'zip',
            'city'
        ];
        $params = [
            'fields' => implode(',', $fields),
            'access_token' => $this->api->access_token,
            'appsecret_proof' => $this->api->getAppSecretProof()
        ];
        $data = $this->api->get('/api/oauth2/profile/', $params);

        if (!isset($data->uid)) {
            throw new Exception("User profile request failed! {$this->providerId} returned an invalid response.", 6);
        }

        $this->user->profile->identifier = (property_exists($data, 'uid')) ? $data->uid : '';
        $this->user->profile->displayName = (property_exists($data, 'name')) ? $data->name : '';
        $this->user->profile->firstName = (property_exists($data, 'first_name')) ? $data->first_name : '';
        $this->user->profile->lastName = (property_exists($data, 'last_name')) ? $data->last_name : '';
        $this->user->profile->email = (property_exists($data, 'email')) ? $data->email : '';
        $this->user->profile->emailVerified = (property_exists($data, 'email')) ? $data->email : '';
        $this->user->profile->address = (property_exists($data, 'address')) ? $data->address : '';
        $this->user->profile->zip = (property_exists($data, 'zip')) ? $data->zip : '';
        $this->user->profile->city = (property_exists($data, 'city')) ? $data->city : '';

        return $this->user->profile;
    }
}
