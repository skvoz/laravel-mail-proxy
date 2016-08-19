<?php


namespace App\Infrastructure\Email;


use App\Domain\Email\EmailRepository;
use App\Infrastructure\DoctrineBaseRepository;

class DoctrineEmailRepository extends DoctrineBaseRepository implements EmailRepository
{

}