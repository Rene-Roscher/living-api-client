<?php
/**
 * Created by PhpStorm.
 * User: Rene_Roscher
 * Date: 09.09.2018
 * Time: 18:52
 */

namespace Living\Manager;


use Living\Living;

class TrafficManager
{

    private $living;

    public function __construct(Living $living)
    {
        $this->living = $living;
    }

    /**
     * @param $ip | IPv4
     * @param $from | start date
     * @param $to | end date to list
     * @return array with traffic data
     */
    public function getSingleTrafficByIp($ip, $from, $to)
    {
        return json_decode($this->living->getHttpClient()->get($this->living->getUriTrafficApi().'/address/by-ip', [
            RequestOptions::JSON => [
                'ip' => $ip,
                'traffic_from' => $from,
                'traffic_to' => $to
            ]
        ])->getBody());
    }

    public function getAddressHistoryByIp($ip)
    {
        return json_decode($this->living->getHttpClient()->get($this->living->getUriTrafficApi().'/address/history', [
            RequestOptions::JSON => [
                'ip' => $ip,
            ]
        ])->getBody());
    }

    public function getTotalTrafficForSubnet($subnet, $from, $to)
    {
        return json_decode($this->living->getHttpClient()->get($this->living->getUriTrafficApi().'/traffic/sum/by-subnet', [
            RequestOptions::JSON => [
                'subnet' => $subnet,
                'traffic_from' => $from,
                'traffic_to' => $to
            ]
        ])->getBody());
    }

    public function getTotalTrafficByIp($ip, $from, $to)
    {
        return json_decode($this->living->getHttpClient()->get($this->living->getUriTrafficApi().'/traffic/sum/by-ip', [
            RequestOptions::JSON => [
                'ip' => $ip,
                'traffic_from' => $from,
                'traffic_to' => $to
            ]
        ])->getBody());
    }

    public function setRdnsFromIp($ip, $rdns)
    {
        return json_decode($this->living->getHttpClient()->post($this->living->getUriTrafficApi().'/rdns/by-ip', [
            RequestOptions::JSON => [
                'ip' => $ip,
                'rdns' => $rdns
            ]
        ])->getBody());
    }

}