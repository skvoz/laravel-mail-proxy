<?php
namespace App\Http\Controllers;


use App\Entities\Email;
use App\Entities\Scientist;
use App\Infrastructure\Email\DoctrineEmailRepository;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\App;
use LaravelDoctrine\ORM\Facades\EntityManager;

class EmailController extends Controller
{
    public function index()
    {
        var_dump(new DoctrineEmailRepository());
        die;
        var_dump(App::environment());
        die;
//        $scientist = new Scientist(
//            'Albert',
//            'Einstein'
//        );
//
//        $scientist->addTheory(
//            new Theory('Theory of relativity')
//        );
        $repository = EntityManager::getRepository(Email::class);
        /** @var Scientist $scientists */
        $emails = $repository->findAll();

//        EntityManager::persist($scientist);
//        EntityManager::flush();

        return view('post', [
            'items' => $emails,
        ]);
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function send(Request $request)
    {
        echo 123;
    }
}