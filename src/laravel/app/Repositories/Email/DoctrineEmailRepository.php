<?php


namespace App\Repositories\Email;


use App\Domain\Email\EmailRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineEmailRepository extends EntityRepository implements EmailRepository
{
}