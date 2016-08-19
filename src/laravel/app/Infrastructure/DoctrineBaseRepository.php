<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 19.08.16
 * Time: 14:01
 */

namespace App\Infrastructure;


use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityRepository;

class DoctrineBaseRepository extends EntityRepository
{
    public  function create($data)
    {
        $entity =  new $this->_entityName();

        return $this->prepare($entity, $data);
    }

    public  function update($data, $id)
    {
        $entity =  $this->find($id);

        return $this->prepare($entity, $data);
    }

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

    public function prepare($entity, $data)
    {
        $set = 'set';

        $whitelist = $entity->whitelist();

        foreach ($whitelist as $field) {
            if (isset($data[$field])) {
                $setter = $set . Inflector::classify($field) ;

                $entity->$setter($data[$field]);
            }
        }

        return $entity;

    }
}