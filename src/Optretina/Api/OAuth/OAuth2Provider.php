<?php
namespace Optretina\Api\OAuth;

use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\IdentityProvider;

class OAuth2Provider extends IdentityProvider
{
    private $api_url = 'https://api.optretina.com/';
    
    public $scopes = array();
    public $responseType = 'json';

    public function urlAuthorize()
    {
        return $this->api_url.'/authorize';
    }

    public function urlAccessToken()
    {
        return $this->api_url.'/authorize';
    }

    public function urlUserDetails(AccessToken $token)
    {
        return $this->api_url.'/me?access_token='.$token;
    }

    public function userDetails($response, AccessToken $token)
    {
        $user = new User;

        return $user;
    }

    public function userUid($response, AccessToken $token)
    {
        return null;
    }

    public function userEmail($response, AccessToken $token)
    {
        return null;
    }

    public function userScreenName($response, AccessToken $token)
    {
        return null;
    }

    public function getApiUrl()
    {
        return $this->api_url;
    }
}

