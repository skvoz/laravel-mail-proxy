<?php
namespace App\Infrastructure;

use Doctrine\ORM\EntityRepository;

class DoctrineBaseRepository extends EntityRepository
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