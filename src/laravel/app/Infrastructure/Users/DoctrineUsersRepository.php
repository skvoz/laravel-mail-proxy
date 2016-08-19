<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 19.08.16
 * Time: 17:44
 */

namespace App\Infrastructure\Users;


use App\Domain\Users\Users;
use App\Domain\Users\UsersRepository;
use App\Infrastructure\DoctrineBaseRepository;

class DoctrineUsersRepository extends DoctrineBaseRepository implements UsersRepository
{
    public function save($object)
    {
        //todo need change password generation system
        /** @var $object Users */
        $object->setPassword(111);
        $object->setApiToken(str_random(60));
//        $object->setCreatedAt(date('d-m-y H:i:s', time()));
//        $object->setUpdatedAt(date('d-m-y H:i:s', time()));

        return parent::save($object);
    }

    public function update($object, $id)
    {
        //todo need change password generation system
        /** @var $object Users */
//        $object->setUpdatedAt(date('d-m-y H:i:s', time()));

        return parent::update($object, $id);
    }
}