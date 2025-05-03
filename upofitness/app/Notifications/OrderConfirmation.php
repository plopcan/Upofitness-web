<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $userName)
    {
        $this->order = $order;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmación de tu pedido en Upofitness')
                    ->view('emails.order-confirmation');
    }
}
