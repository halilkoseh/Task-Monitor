<?php
namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @param Task $task The task instance
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.task_status_updated')->subject(' Görev Stastü Güncellendi');


    }
}



