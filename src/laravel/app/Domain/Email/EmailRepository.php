<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 19.08.16
 * Time: 12:52
 */

namespace App\Domain\Email;


interface EmailRepository
{
    public function save($object);
    public function delete($object);
}