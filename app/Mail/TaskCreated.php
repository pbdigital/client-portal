<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $task_name;
    public $first_name;
    public $subject;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $task_name)
    {
        $this->task_name = $task_name;
        $this->first_name = $first_name;
        $this->subject = 'New Request Received: '.$task_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.task-created');
    }
}
