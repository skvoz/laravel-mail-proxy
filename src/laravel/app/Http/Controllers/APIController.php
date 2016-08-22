<?php
namespace App\Http\Controllers;

use App\Domain\Email\Email;
use App\Domain\Email\EmailRepository;
use App\Domain\Users\Users;
use App\Domain\Users\UsersRepository;
use App\Domain\Users\UsersSaveDataMapper;
use App\Events\MessageWasPurchasedEvent;
use App\Repositories\Email\DoctrineEmailRepository;
use App\Repositories\Users\DoctrineUsersRepository;
use Exception;
use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Http\Request;

/**
 * Class APIController
 * @package App\Http\Controllers
 */
class APIController extends Controller
{
    /**
     * @var DoctrineEmailRepository
     */
    protected $emailRepository;
    /**
     * @var DoctrineUsersRepository
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
     * @var Email
     */
    protected $emailEntity;

    /**
     * @param UsersSaveDataMapper $usersSaveDataMapper
     * @param UsersRepository $userRepository
     * @param EmailRepository $emailRepository
     * @param Users $userEntity
     * @param Email $emailEntity
     */
    public function __construct(
        UsersSaveDataMapper $usersSaveDataMapper,
        UsersRepository $userRepository,
        EmailRepository $emailRepository,
        Users $userEntity,
        Email $emailEntity
    )
    {
        $this->userSaveDataMapper = $usersSaveDataMapper;
        $this->userEntity = $userEntity;
        $this->emailEntity = $emailEntity;
        $this->userRepository = $userRepository;
        $this->emailRepository = $emailRepository;
    }


    /**
     * @param Request $request
     * @internal param EmailFormRequest $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        try {
            $this->validate($request, [
                'to' => 'required|email|max:255',
                'subject' => 'required|max:255',
                'api_token' => 'required|min:60|max:60',
            ]);

            $to = $request->input('to');
            $subject = $request->input('subject');
            $body = $request->input('body');
            $apiToken = $request->input('api_token');

            /** @var Users $currentUser */
            $currentUser = $this->userRepository->findBy([
                'api_token' => $apiToken
            ]);

            $currentUser = isset($currentUser[0]) ? $currentUser[0] : null;

            $this->emailEntity->setTarget($to);
            $this->emailEntity->setSubject($subject);
            $this->emailEntity->setBody($body);
            $this->emailEntity->setUserId($currentUser->getId());

            $this->emailRepository->save($this->emailEntity);


            event(new MessageWasPurchasedEvent($this->emailEntity));

            $status = 200;
            $result = [];
        } catch (ValidationException $e) {
            $result = ['error' => $e->validator->getMessageBag()];
            $status = 500;
        } catch (Exception $e) {
            $status = 500;
            $result = ['error' => $e->getMessage()];
        }

        return response()->json($result, $status);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param UserFormRequest $response
     */
    public function register(Request $request)
    {

        try {
            $this->validate($request, [
                'name' => 'required|unique:App\Domain\Users\Users,name|max:255',
                'email' => 'required|email|unique:App\Domain\Users\Users,email|max:255'
            ]);

            $this->userSaveDataMapper->setRequest($request);
            $data = $this->userSaveDataMapper->execute();

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
        } catch (ValidationException $e) {
            $result = ['error' => $e->validator->getMessageBag()];
            $status = 500;
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage()];
            $status = 500;
        }

        return response()->json($result, $status);
    }
}