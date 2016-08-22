<?php
namespace App\Repositories\Users;

use App\Domain\Users\UsersRepository;
use App\Repositories\DoctrineBaseRepository;

class DoctrineUsersRepository extends DoctrineBaseRepository implements UsersRepository
{
    public  function save($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);

        return $object;
    }

    public  function delete($object)
    {
        $this->_em->remove($object);
        $this->_em->flush($object);

        return true;
    }
}