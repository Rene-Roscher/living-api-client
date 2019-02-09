<?php
/**
 * Created by PhpStorm.
 * User: mrlog
 * Date: 31.10.2018
 * Time: 00:19
 */

namespace Living\Manager;


use GuzzleHttp\RequestOptions;
use Living\Living;

class PXEManager
{

    private $living;

    /**
     * PXEManager constructor.
     * @param $living
     */
    public function __construct(Living $living)
    {
        $this->living = $living;
    }

    /**
     * @param $macAddress
     * @param $ipAddress
     * @param $hostName
     * @param $osTemplate
     * @param $rootPassword
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function create($macAddress, $ipAddress, $hostName, $osTemplate, $rootPassword)
    {
        return json_decode($this->living->getHttpClient()->post($this->living->getUriInstallerApi(), [
            RequestOptions::JSON => [
                'macAddress' => $macAddress,
                'ipAddress' => $ipAddress,
                'hostName' => $hostName,
                'osTemplate' => $osTemplate,
                'rootPassword' => $rootPassword
            ]
        ])->getBody());
    }

    /**
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function check($apiKey)
    {
        return json_decode($this->living->getHttpClient()->post($this->living->getUriInstallerApi().'&action=status', [
            RequestOptions::JSON => [
                'apiKey' => $apiKey
            ]
        ])->getBody());
    }

    /**
     * @return string
     */
    public function generateMacAddress()
    {
        return $this->living->getMacAddressPrefix().implode(':', str_split(substr(md5(mt_rand()), 0, 6), 2));
    }

}
