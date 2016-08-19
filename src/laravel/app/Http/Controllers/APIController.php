<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 16.08.16
 * Time: 20:11
 */

namespace App\Http\Controllers;

use App\Domain\Email\EmailRepository;
use App\Domain\Users\Users;
use App\Domain\Users\UsersRepository;
use App\Domain\Users\UsersSaveDataMapper;
use Exception;
use App\Http\Requests\EmailFormRequest;
use App\Http\Requests\UserFormRequest;

/**
 * Class APIController
 * @package App\Http\Controllers
 */
class APIController extends Controller
{
    /**
     * @var EmailRepository
     */
    protected $emailRepository;
    /**
     * @var UsersRepository
     */
    protected $userRepository;
    /**
     * @var UsersSaveDataMapper
     */
    protected $userSaveDataMapper;
    /**
     * @var Users
     */
    protected $userEntity;

    /**
     * @param UsersSaveDataMapper $usersSaveDataMapper
     * @param EmailRepository $emailRepository
     * @param UsersRepository $usersRepository
     * @param Users $userEntity
     * @internal param Users $userEntitiy
     */
    public function __construct(
        UsersSaveDataMapper $usersSaveDataMapper,
        EmailRepository $emailRepository,
        UsersRepository $usersRepository,
        Users $userEntity
    ) {
        $this->userSaveDataMapper = $usersSaveDataMapper;
        $this->emailRepository = $emailRepository;
        $this->userRepository = $usersRepository;
        $this->userEntity = $userEntity;

    }
    /**
     * @param EmailFormRequest $response
     */
    public function sendEmail(EmailFormRequest $response)
    {
        $to = $response->input('to');
        $subject = $response->input('subject');
        $body = $response->input('body');
        $apiToken = $response->input('api_token');
        $currentUser = $this->userRepository->findBy([
            'api_token' => $apiToken
        ]);

        var_dump($currentUser->email);
        die;

//        $callback = function ($m) use ($user, $to, $subject) {
//
//            $m->to('skvoz.ne@gmail.com', 'John Smith')
//                ->from('skvoz.ne@gmail.com')
//                ->subject('Welcome!!!!');
//        };
//
//        Mail::raw($body, $callback);
    }

    /**
     * @param UserFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param UserFormRequest $response
     */
    public function register(UserFormRequest $request)
    {
        $this->userSaveDataMapper->setRequest($request);
        $data = $this->userSaveDataMapper->execute();

        try {
            $this->userEntity->setName($data['name']);
            $this->userEntity->setEmail($data['email']);
            $this->userEntity->setPassword($data['password']);
            $this->userEntity->setRememberToken($data['remember_token']);
            $this->userEntity->setCreatedAt($data['created_at']);
            $this->userEntity->setUpdatedAt($data['updated_at']);
            $this->userEntity->setApiToken($data['api_token']);

            $this->userRepository->save($this->userEntity);

            $result = [
                'api_token' => $this->userEntity->getApiToken(),
            ];
            $status = 200;
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage()];
            $status = 500;
        }

        return response()->json($result, $status);
    }
}