<?php
/**
 * Created by PhpStorm.
 * User: Rene_Roscher
 * Date: 09.09.2018
 * Time: 18:54
 */

namespace Living;


class LivingFacade
{

    /**
     * @return Living
     */
    public static function client()
    {
        return new Living('XXXX', 'XXXX', 1);
    }

}