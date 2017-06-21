<?php
namespace Optretina\Api;

class Client
{
    private $access_token;
    private $provider;
    private $debug_mode = false;

    public function __construct($client_id, $client_secret)
    {
        $this->provider = new OAuth\OAuth2Provider();

        $token = $this->provider->getAccessToken(new OAuth\ClientCredentialsGrant, [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials'
        ]);
        $this->access_token = $token;
    }
    
    public function debugMode($enabled = true)
    {
        $this->debug_mode = $enabled;
    }

    public function getCases()
    {
        $response = $this->getRequest('/cases');

        return $response;
    }

    public function getCase($id)
    {
        $response = $this->getRequest('/cases/'.intval($id));

        return $response;
    }

    public function createCase($data)
    {
        $response = $this->postRequest('/cases', $data);

        return $response;
    }
    
    public function uploadImages($id, $data)
    {
        $response = $this->postRequest('/cases/'.$id.'/images', $data);

        return $response;
    }

    public function getReport($id)
    {
        $response = $this->getRequest('/cases/report/'.intval($id));

        return $response;
    }

    private function getRequest($url)
    {
        if(empty($this->access_token->accessToken)){
            return (object) [
                'success' => false,
                'content' => 'Invalid token validation error. Please contact us. info@optretina.com'
            ];
        }

        $client = $this->provider->getHttpClient();
        $client->setBaseUrl($this->provider->getApiUrl().$url.'?access_token='.$this->access_token->accessToken);
        $request = $client->get()->send();
        $response = $request->getBody();

        if ($this->debug_mode) {
            echo $response;
        }

        $response = json_decode($response);

        return $response;
    }

    private function postRequest($url, $requestParams)
    {
        if(empty($this->access_token->accessToken)){
            return (object) [
                'success' => false,
                'content' => 'Invalid token validation error. Please contact us. info@optretina.com'
            ];
        }
        
        $requestParams['access_token'] = $this->access_token->accessToken;

        $resourceParams = array();
        if (isset($requestParams['images'])) {
            foreach ($requestParams['images'] as $img) {
                $resourceParams[] = $img;
            }
            unset($requestParams['images']);
        }

        try {
            $client = $this->provider->getHttpClient();
            $client->setBaseUrl($this->provider->getApiUrl().$url);
            $request = $client->post(null, null, $requestParams);
            foreach ($resourceParams as $img) {
                $request->addPostFile('images', $img);
            }
        } catch (\Guzzle\Common\Exception\InvalidArgumentException $ex) {
            return (object) [
                'success' => false,
                'content' => $ex->getMessage()
            ];
        }    

        $request = $request->send();
        $response = $request->getBody(true);
        
        if ($this->debug_mode) {
            echo $response;
        }
        
        $response = json_decode($response);

        return $response;
    }
}
