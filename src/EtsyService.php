<?php

namespace Gentor\Etsy;


use Gentor\OAuth1Etsy\Client\Server\Etsy;
use League\OAuth1\Client\Credentials\TokenCredentials;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Foundation\Application;

/**
 * Class EtsyService
 * @package Gentor\Etsy
 */
class EtsyService
{
    /** @var Etsy $server */
    private $server;

    /** @var TokenCredentials $tokenCredentials */
    private $tokenCredentials;

    /** @var Store */
    private $session;

    /**
     * EtsyService constructor.
     * @param \Illuminate\Foundation\Application $app
     * @param array $config
     */
    public function __construct(Application $app, array $config)
    {
        $this->session = new SessionManager($app);

        $this->server = new Etsy([
            'identifier' => $config['consumer_key'],
            'secret' => $config['consumer_secret'],
            'scope' => !empty($config['scope']) ? $config['scope'] : '',
            'callback_uri' => ''
        ]);

        if (!empty($config['access_token']) && !empty($config['access_token_secret'])) {
            $tokenCredentials = new TokenCredentials();
            $tokenCredentials->setIdentifier($config['access_token']);
            $tokenCredentials->setSecret($config['access_token_secret']);

            $this->tokenCredentials = $tokenCredentials;
        }
    }

    /**
     * @param $callbackUri
     * @return string
     */
    public function authorize($callbackUri)
    {
        $this->server->getClientCredentials()->setCallbackUri($callbackUri);

        // Retrieve temporary credentials
        $temporaryCredentials = $this->server->getTemporaryCredentials();

        // Store credentials in the session, we'll need them later
        $this->session->put('temporary_credentials', serialize($temporaryCredentials));

        return $this->server->getAuthorizationUrl($temporaryCredentials);
    }

    /**
     * @param $token
     * @param $verifier
     * @return \League\OAuth1\Client\Credentials\TokenCredentials
     */
    public function approve($token, $verifier)
    {
        // Retrieve the temporary credentials we saved before
        $temporaryCredentials = unserialize($this->session->get('temporary_credentials'));

        return $this->server->getTokenCredentials($temporaryCredentials, $token, $verifier);
    }

    /**
     * Get the user's unique identifier (primary key).
     *
     * @param bool $force
     *
     * @return string|int
     */
    public function getUserUid($force = false)
    {
        $userDetails = $this->getUserDetails($force);

        return $userDetails->uid;
    }

    /**
     * Get user details by providing valid token credentials.
     *
     * @param bool $force
     *
     * @return \League\OAuth1\Client\Server\User
     */
    public function getUserDetails($force = false)
    {
        return $this->server->getUserDetails($this->tokenCredentials, $force);
    }

    /**
     * @param $method
     * @param array $args
     * @return array
     */
    public function __call($method, array $args)
    {
        $api = new EtsyApi($this->server, $this->tokenCredentials);

        return call_user_func_array([$api, $method], $args);
    }
}