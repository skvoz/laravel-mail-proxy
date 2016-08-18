<?php
namespace App\Http\Requests;

use Response;

class EmailFormRequest extends Request
{

    public function rules()
    {
        return [
            'to' => 'required|email',
            'subject' => 'required|max:255',
            'body' => 'required',
            'api_token' => 'required|max:60',
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
        return Response::make('Error data!!!', 403);
    }
}