<?php
/**
 * Created by PhpStorm.
 * User: Rene_Roscher
 * Date: 09.09.2018
 * Time: 18:22
 */

namespace Living;


use GuzzleHttp\Client;
use Living\Manager\DDosManager;
use Living\Manager\PXEManager;

class Living
{

    private $ddosApiToken;
    private $installerApiToken;

    private $uriDdosApi;
    private $uriInstallerApi;
    private $installerResellerId;
    private $httpClient;

    /**
     * Living constructor.
     * @param $ddosApiToken
     * @param $installerApiToken
     * @param $installerResellerId
     */
    public function __construct($ddosApiToken, $installerApiToken, $installerResellerId)
    {
        $this->ddosApiToken = $ddosApiToken;
        $this->installerApiToken = $installerApiToken;
        $this->installerResellerId = $installerResellerId;
        $this->uriDdosApi = 'https://ddos.living-bots.net/api/alerts?api_token='.$ddosApiToken;
        $this->uriInstallerApi = 'https://rootserver.living-bots.net/api/reseller/kvmInstallation?resellerId='.$installerResellerId.'&token='.$installerApiToken;
        $this->httpClient = new Client([
            'allow_redirects' => false,
            'timeout' => 120
        ]);
    }

    /**
     * @param array $params
     * @param $action
     * @param $url
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function get(array $params, $action, $url)
    {
        return $this->client($params, 'GET', $action, $url);
    }

    public function post(array $params, $action, $url)
    {
        return $this->client($params, 'POST', $action, $url);
    }

    public function delete(array $params, $action, $url)
    {
        return $this->client($params, 'DELETE', $action, $url);
    }

    public function put(array $params, $action, $url)
    {
        return $this->client($params, 'PUT', $action, $url);
    }

    /**
     * @param array $params
     * @param $method
     * @param $action
     * @param $url
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    private function client(array $params, $method, $action, $url)
    {
        $params['config'] = [];
        $params['config']['timezone'] = 'UTC';
        $params = $this->formatValues($params);

        switch ($method) {
            case 'GET':
                return $this->request($this->httpClient->get($url.$action, [
                    'verify' => false,
                    'query'  => $params,
                ]));
                break;
            case 'POST':
                return $this->request($this->httpClient->post($url.$action, [
                    'verify' => false,
                    'form_params' => $params,
                ]));
                break;
            case 'PUT':
                return $this->request($this->httpClient->put($url.$action, [
                    'verify' => false,
                    'form_params' => $params,
                ]));
            case 'DELETE':
                return $this->request($this->httpClient->delete($url.$action, [
                    'verify' => false,
                    'form_params' => $params,
                ]));
            default:
                return false;
        }
    }

    /**
     * @return DDosManager
     */
    public function getDDoSManager() : DDosManager
    {
        return new DDosManager($this);
    }

    /**
     * @return DDosManager
     */
    public function getPXEManager() : PXEManager
    {
        return new PXEManager($this);
    }

    /**
     * @param $response
     * @return mixed
     */
    private function request($response)
    {
        $response = $response->getBody()->__toString();
        $result = json_decode($response);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $result;
        } else {
            return $response;
        }
    }

    /**
     * @param array $array
     * @return array
     */
    private function formatValues(array $array)
    {
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $array[$key] = self::formatValues($item);
            } else {
                if ($item instanceof \DateTime)
                    $array[$key] = $item->format("Y-m-d H:i:s");
            }
        }

        return $array;
    }

    /**
     * @return mixed
     */
    public function getDdosApiToken()
    {
        return $this->ddosApiToken;
    }

    /**
     * @return mixed
     */
    public function getInstallerApiToken()
    {
        return $this->installerApiToken;
    }

    /**
     * @return string
     */
    public function getUriDdosApi(): string
    {
        return $this->uriDdosApi;
    }

    /**
     * @return string
     */
    public function getUriInstallerApi(): string
    {
        return $this->uriInstallerApi;
    }

    /**
     * @return mixed
     */
    public function getInstallerResellerId()
    {
        return $this->installerResellerId;
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

}