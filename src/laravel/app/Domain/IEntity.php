<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 23.08.16
 * Time: 13:06
 */

namespace App\Domain;


interface IEntity
{
    /**
     * @param $data key-value array
     * @return mixed
     */
    function fillEntityArray($data);
}