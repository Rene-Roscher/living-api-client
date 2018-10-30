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

    /**
     * @var Ph24
     */
    private $living;

    /**
     * Payment constructor.
     * @param Ph24 $ph24
     */
    public function __construct(Living $living)
    {
        $this->living = $living;
    }

    public function get()
    {
        return $this->living->get([], '');
    }

}