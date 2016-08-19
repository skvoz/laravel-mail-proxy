<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 16.08.16
 * Time: 20:11
 */

namespace App\Http\Controllers;
use App\Domain\Email\EmailRepository;
use App\Domain\Users\UsersRepository;
use Illuminate\Support\Facades\App;
use Mail;
use App\Http\Requests\EmailFormRequest;
use App\Http\Requests\UserFormRequest;



/**
 * Class APIController
 * @package App\Http\Controllers
 */
class APIController extends Controller
{
    protected $emailRepository;
    protected $userRepository;

    public function __construct()
    {
        $this->emailRepository = App::make(EmailRepository::class);
        $this->userRepository = App::make(UsersRepository::class);
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
        $name = $request->input('name');
        $email = $request->input('email');
        $result = [];
        try {
            $users = $this->userRepository->create([
                'name'=> $name,
                'email' => $email
            ]);
            $result = [
                'api_token' => $users->getApiToken(),
            ];
            $status = 200;
        } catch (Exception $e) {
            $status = 500;
        }

        return response()->json($result, $status);
    }
}