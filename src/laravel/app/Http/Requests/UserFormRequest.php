<?php
namespace App\Http\Requests;

use Response;

class UserFormRequest extends Request
{

    public function rules()
    {
        return [
            'name' => 'required|max:255|min:2',
//            'email' => 'required|unique:users|email',
            'email' => 'required|email',
        ];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    // OPTIONAL OVERRIDE
    public function forbiddenResponse()
    {
        // Optionally, send a custom response on authorize failure
        // (default is to just redirect to initial page with errors)
        //
        // Can return a response, a view, a redirect, or whatever else
        return Response::make('Permission denied foo!', 403);
    }
}