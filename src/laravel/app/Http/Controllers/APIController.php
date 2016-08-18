<?php
/**
 * Created by PhpStorm.
 * User: kostiantyn
 * Date: 16.08.16
 * Time: 20:11
 */

namespace App\Http\Controllers;
use Mail;
use App\Entities\Users;
use App\Http\Requests\EmailFormRequest;
use App\Http\Requests\UserFormRequest;
use Aws\Ses\SesClient;



/**
 * Class APIController
 * @package App\Http\Controllers
 */
class APIController extends Controller
{
    /**
     * @param EmailFormRequest $response
     */
    public function sendEmail(EmailFormRequest $response)
    {
        $to = $response->input('to');
        $subject = $response->input('subject');
        $body = $response->input('body');
        $apiToken = $response->input('api_token');
        $user = new Users();
        $user->setEmail('aaa@aaa.com');
        $user->setName('aaa@aaa.com');


        $callback = function ($m) use ($user, $to, $subject) {

            $m->to('skvoz.ne@gmail.com', 'John Smith')
                ->from('skvoz.ne@gmail.com')
                ->subject('Welcome!!!!');
        };

        Mail::raw($body, $callback);
    }

    /**
     * @param UserFormRequest $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserFormRequest $response)
    {
        $users = new Users();
        $result = $users->stored($response);
        $status = isset($result['errors']) ? 404 : 200;

        return response()->json($result, $status);
    }
}