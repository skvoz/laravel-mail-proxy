<?php

namespace App\Events;

use App\Domain\Email\Email;
use Illuminate\Queue\SerializesModels;

class MessageWasPurchasedEvent extends Event
{
    use SerializesModels;
    /**
     * @var Email
     */
    public $email;

    /**
     * Create a new event instance.
     *
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        //
        $this->email = $email;
    }
}
