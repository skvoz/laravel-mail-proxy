<?php

use App\Domain\Users;
use App\Domain\Users\UsersRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersRepositoryTest extends TestCase
{
    protected $repository;

    protected static $users;

    public function setUp()
    {
        parent::setUp();

        $this->repository = App::make(UsersRepository::class);
    }

    public function tearDown()
    {

    }


    public function testCreateAndSave()
    {
        $data = [
            'name' => "ashot11",
            'email' => "as".time()."hot123@ashot123.com",
        ];

        $users = $this->repository->create($data);

        self::$users = $this->repository->save($users);

        $this->seeInDatabase('users', [
            'id' => self::$users->getId(),
        ]);
    }

    public function testUpdateAndSave()
    {
        $data = [
            'name' => 'ashot321@ashot321.com',
        ];

        $users = $this->repository->update($data, self::$users->getId());

        self::$users = $this->repository->save($users);

        $this->assertEquals($data['name'], self::$users->getName());
    }

    public function testFindAll()
    {
        $users = $this->repository->findAll();

        $this->assertContainsOnlyInstancesOf(Users::class, $users);
    }

    public function testDelete()
    {
        $users = $this->repository->find(self::$users->getId());

        $result = $this->repository->delete($users);

        $this->assertTrue($result);
    }
}
