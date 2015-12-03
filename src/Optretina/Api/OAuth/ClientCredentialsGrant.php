<?php
namespace Optretina\Api\OAuth;

use League\OAuth2\Client\Token\AccessToken as AccessToken;
use League\OAuth2\Client\Grant\GrantInterface;

class ClientCredentialsGrant implements GrantInterface
{
    public function __toString()
    {
        return 'client_credentials';
    }

    public function prepRequestParams($defaultParams, $params)
    {
        if (
            !isset($params['client_id']) || empty($params['client_id']) ||
            !isset($params['client_secret']) || empty($params['client_secret'])
        ) {
            throw new \BadMethodCallException('Missing parameters: client_id and/or client_secret');
        }

        $params['grant_type'] = 'client_credentials';

        return array_merge($defaultParams, $params);
    }

    public function handleResponse($response = array())
    {
        try{
            return new AccessToken($response);
        } catch (\Exception $ex) {
            return false;
        }
    }
}
