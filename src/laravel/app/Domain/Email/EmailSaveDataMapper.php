<?php
namespace App\Domain\Email;


use Illuminate\Http\Request;

class EmailSaveDataMapper
{
    /**
     * @param Request $request
     * @return array
     */
    public function execute(Request $request)
    {
        $to = $request->input('to');
        $subject = $request->input('subject');
        $body = $request->input('body');

        return  [
            'target' => $to,
            'subject' => $subject,
            'body' => $body,
        ];
    }

}