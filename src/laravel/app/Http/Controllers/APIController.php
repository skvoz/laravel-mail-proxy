<?php
namespace App\Http\Controllers;

use App\Domain\Email\Email;
use App\Domain\Email\EmailRepository;
use App\Domain\Email\EmailSaveDataMapper;
use App\Domain\Users\User;
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
     * @var User
     */
    protected $userEntity;
    /**
     * @var Email
     */
    protected $emailEntity;
    /**
     * @var EmailSaveDataMapper
     */
    private $emailSaveDataMapper;

    /**
     * @param UsersSaveDataMapper $usersSaveDataMapper
     * @param EmailSaveDataMapper $emailSaveDataMapper
     * @param UsersRepository $userRepository
     * @param EmailRepository $emailRepository
     * @param User $userEntity
     * @param Email $emailEntity
     */
    public function __construct(
        UsersSaveDataMapper $usersSaveDataMapper,
        EmailSaveDataMapper $emailSaveDataMapper,
        UsersRepository $userRepository,
        EmailRepository $emailRepository,
        User $userEntity,
        Email $emailEntity
    )
    {
        $this->userSaveDataMapper = $usersSaveDataMapper;
        $this->userEntity = $userEntity;
        $this->emailEntity = $emailEntity;
        $this->userRepository = $userRepository;
        $this->emailRepository = $emailRepository;
        $this->emailSaveDataMapper = $emailSaveDataMapper;
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

            $data = $this->emailSaveDataMapper->execute($request);
            $this->emailEntity->fillEntityArray($data);

            $userEntity = $this->userRepository->findOneBy([
                'api_token' => $request->input('api_token')
            ]);

            $userEntity->addEmail($this->emailEntity);

            $this->userRepository->save($userEntity);

            event(new MessageWasPurchasedEvent($this->emailEntity));

            $status = 200;
            $result = [];
        } catch (ValidationException $e) {
            $result = ['error' => $e->validator->getMessageBag()];
            $status = 422;
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
                'name' => 'required|unique:App\Domain\Users\User,name|max:255',
                'email' => 'required|email|unique:App\Domain\Users\User,email|max:255'
            ]);

            $data = $this->userSaveDataMapper->execute($request);
            $this->userEntity->fillEntityArray($data);
            $this->userRepository->save($this->userEntity);

            $result = [
                'api_token' => $this->userEntity->getApiToken(),
            ];
            $status = 200;
        } catch (ValidationException $e) {
            $result = ['error' => $e->validator->getMessageBag()];
            $status = 422;
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage()];
            $status = 500;
        }

        return response()->json($result, $status);
    }

}