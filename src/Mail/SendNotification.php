<?php

namespace Chelsymooy\Subscriptions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Sichikawa\LaravelSendgridDriver\SendGrid;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels, SendGrid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $attach)
    {
        $this->data     = $data;
        $this->attach   = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(is_null($this->attach)) {
            return $this
                    ->subject(ucwords($this->data['user']['name'].', '.$this->data['title']))
                    ->from(config()->get('subscription.issuer.issuer_email'), config()->get('subscription.issuer.issuer_name'))
                    ->view('subs::emails.notification')->with('data', $this->data)
                    ;
        } else {
            return $this
                    ->subject(ucwords($this->data['user']['name'].', '.$this->data['title']))
                    ->from(config()->get('subscription.issuer.issuer_email'), config()->get('subscription.issuer.issuer_name'))
                    ->view('subs::emails.notification')->with('data', $this->data)
                    ->attachData($this->attach->output(), "attachment.pdf")
                    ;
        }
    }
}
