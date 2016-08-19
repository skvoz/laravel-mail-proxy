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
    public function create($data);
    public function update($data, $id);
    public function save($object);
    public function delete($object);
    public function find($id);
    public function findAll();
}