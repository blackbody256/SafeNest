<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Claim;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClaimStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

   public $claim;
    public function __construct(Claim $claim)
    {
        $this->claim=$claim;
    }

   public function build(){
    return $this->subject('Claim Status Update: ' . $this->claim->Status)
                ->view('emails.claim_status');
   }
}
