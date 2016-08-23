<?php
namespace App\Domain\Users;

use Illuminate\Http\Request;

class UsersSaveDataMapper
{
    /**
     * @param Request $request
     * @return array
     */
    public function execute(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

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
}