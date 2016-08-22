<?php

namespace App\Listeners;

use App\Events\MessageWasPurchasedEvent;
use Illuminate\Support\Facades\Mail;

class EmailSenderListener
{
    /**
     * Handle the event.
     *
     * @param MessageWasPurchasedEvent $event
     */
    public function handle(MessageWasPurchasedEvent $event)
    {
        $to = $event->email->getTarget();
        $subject = $event->email->getSubject();
        $body = $event->email->getBody();
        $currentUser = [];
        $callback = function ($m) use ($currentUser, $to, $subject, $body) {
            $m->to($to, $to)
//                ->from($currentUser->getEmail(), $currentUser->getName())
                ->from('skvoz.ne@gmail.com', 'skvoz.ne@gmail.com')
                ->subject($subject)
                ->setBody($body);
        };

        Mail::raw($body, $callback);
    }
}
