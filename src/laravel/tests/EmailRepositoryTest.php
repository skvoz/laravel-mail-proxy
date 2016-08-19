<?php

use App\Domain\Email\EmailRepository;
use App\Domain\Email\Email;
use Illuminate\Support\Facades\App;


class EmailRepositoryTest extends TestCase
{
    protected $repository;

    protected static $email;

    public function setUp()
    {
        parent::setUp();

        $this->repository = App::make(EmailRepository::class);
    }

    public function tearDown()
    {

    }


    public function testCreateAndSave()
    {
        $data = [
            'target' => "ashot@ashot.com",
            'subject' => "test subject",
            'body' => "test body",
            'user_id' => 9999,
        ];

        $email = $this->repository->create($data);

        self::$email = $this->repository->save($email);

        $this->seeInDatabase('email', [
            'id' => self::$email->getId(),
        ]);
    }

    public function testUpdateAndSave()
    {
        $data = [
            'target' => 'ashot1@ashot.com',
            'subject' => 'test subject1',
            'body' => 'test body1',
            'user_id' => 9998,
        ];

        $email = $this->repository->update($data, self::$email->getId());

        self::$email = $this->repository->save($email);

        $this->assertEquals($data['target'], self::$email->getTarget());
        $this->assertEquals($data['subject'], self::$email->getSubject());
        $this->assertEquals($data['body'], self::$email->getBody());
        $this->assertEquals($data['user_id'], self::$email->getUserId());
    }

    public function testFindAll()
    {
        $email = $this->repository->findAll();

        $this->assertContainsOnlyInstancesOf(Email::class, $email);
    }

    public function testDelete()
    {
        $email = $this->repository->find(self::$email->getId());

        $result = $this->repository->delete($email);

        $this->assertTrue($result);
    }
}
