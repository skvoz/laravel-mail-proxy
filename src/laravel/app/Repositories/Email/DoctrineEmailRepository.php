<?php
namespace App\Repositories\Email;

use App\Domain\Email\EmailRepository;
use App\Repositories\DoctrineBaseRepository;

class DoctrineEmailRepository extends DoctrineBaseRepository implements EmailRepository
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