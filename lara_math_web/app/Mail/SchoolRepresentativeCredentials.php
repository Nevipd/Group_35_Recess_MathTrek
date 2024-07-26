<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

// mailable class for school rep details initialization
class SchoolRepresentativeCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($school, $password)
    {
        $this->school = $school;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.school_representative_credentials')
                    ->with([
                        'repName' => $this->school->representative_name,
                        'schoolName' => $this->school->name,
                        'repEmail' => $this->school->representative_email,
                        'password' => $this->password,
                    ]);
    }
}
