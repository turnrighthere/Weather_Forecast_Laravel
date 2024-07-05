<?
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscriber;

class UnsubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        return $this->view('emails.unsubscription-confirmation')
                    ->subject('You have been unsubscribed')
                    ->with([
                        'subscriber' => $this->subscriber,
                    ]);
    }
}
