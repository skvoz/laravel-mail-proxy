<?php
namespace App\Http\Controllers;


use App\Domain\Email\Email;
use App\Domain\Email\EmailRepository;
use App\Domain\Users\UsersRepository;
use Illuminate\Http\Request;
use App\Task;

class EmailController extends Controller
{
    protected $emailEntity;
    /**
     * @var EmailRepository
     */
    private $emailRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * SiteController constructor.
     * @param EmailRepository $emailRepository
     * @param UsersRepository $userRepository
     * @param Email $emailEntity
     * @internal param Validator $validator
     * @internal param \App\Domain\Email\Email $emailEntity
     */
    public function __construct(
        EmailRepository $emailRepository,
        UsersRepository $userRepository,
        Email $emailEntity
    )
    {
        $this->emailRepository = $emailRepository;
        $this->emailEntity = $emailEntity;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $emails = $this->emailRepository->findAll();

        return view('index', [
            'items' => $emails,
            'request' => $request,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function view(Request $request, $id)
    {
        $email = $this->emailRepository->find($id);

        if (!$email) {
            throw new \Exception('Email not found', 404);
        }

        return view('email', [
            'email' => $email,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request, $id)
    {
        try {
            $email = $this->emailRepository->find($id);
            $this->emailRepository->delete($email);
            $request->session()->flash('status', 'Successful operation');
        } catch (\Exception $e) {
            $request->session()->flash('error', $e->getMessage());
        }

        return redirect('/');
    }

    public function test()
    {
        //test code
    }
}