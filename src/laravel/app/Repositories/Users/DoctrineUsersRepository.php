<?php
namespace App\Repositories\Users;

use App\Domain\Users\UsersRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineUsersRepository extends EntityRepository implements UsersRepository
{
    /**
     * @param $object
     * @return mixed
     */
    public  function save($object)
    {
        $this->_em->persist($object);
        $this->_em->flush($object);
    }

    /**
     * @param $object
     * @return bool
     */
    public  function delete($object)
    {
        $this->_em->remove($object);
        $this->_em->flush($object);
    }
}