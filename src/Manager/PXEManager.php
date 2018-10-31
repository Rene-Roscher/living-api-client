<?php
/**
 * Created by PhpStorm.
 * User: mrlog
 * Date: 31.10.2018
 * Time: 00:19
 */

namespace Living\Manager;


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
        return $this->living->post([
            'macAddress' => $macAddress,
            'ipAddress' => $ipAddress,
            'hostName' => $hostName,
            'osTemplate' => $osTemplate,
            'rootPassword' => $rootPassword
        ], '', $this->living->getUriInstallerApi());
    }

    /**
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function check($apiKey)
    {
        return $this->living->post([
            'action' => 'status',
            'apiKey' => $apiKey,
        ], '', $this->living->getUriInstallerApi());
    }

    /**
     * @return string
     */
    public function generateMacAddress()
    {
        return '4e:65:06:'.implode(':', str_split(substr(md5(mt_rand()), 0, 6), 2));
    }

}