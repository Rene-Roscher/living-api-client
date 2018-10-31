<?php
/**
 * Created by PhpStorm.
 * User: Rene_Roscher
 * Date: 09.09.2018
 * Time: 18:52
 */

namespace Living\Manager;


use Living\Living;

class DDosManager
{

    private $living;

    public function __construct(Living $living)
    {
        $this->living = $living;
    }

    public function getAll()
    {
        return $this->living->post([], '', $this->living->getUriDdosApi());
    }

    public function getFilterDate($start, $end)
    {
        $obj = new \ArrayObject(array());

        foreach ($this->getAll() as $item => $value) {
            if($value->duration_start >= $start && $value->duration_stop <= $end) {
                $obj->append($value);
            }
        }
        return $obj;
    }

    public function getFilterAddress($ip)
    {
        $obj = new \ArrayObject(array());

        foreach ($this->getAll() as $item => $value) {
            if($value->resource_ip == $ip) {
                $obj->append($value);
            }
        }
        return $obj;
    }

}