<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Importation;

class ImportationFailed extends Mailable
{
    use Queueable, SerializesModels;

     public ?string $lastCompleted;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Importation $importation)
    {
        $this->lastCompleted = Importation::getLastCompletedEnd();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.importation-failed')->subject('Importação Falhou!!! - ' . config('app.name'));
    }
}
