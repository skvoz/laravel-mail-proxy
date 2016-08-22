<?php
namespace App\Domain\Users;

use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;

class UsersSaveDataMapper
{
    /**
     * @var UserFormRequest
     */
    protected $request;

    /**
     * @return array
     */
    public function execute()
    {
        $name = $this->request->input('name');
        $email = $this->request->input('email');

        return  [
            'name' => $name,
            'email' => $email,
            'password' => str_random(8),
            'api_token' => str_random(60),
            'remember_token' => str_random(60),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ];
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
}