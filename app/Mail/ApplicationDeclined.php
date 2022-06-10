<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationDeclined extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Course The course that was declined.
     */
    public Course $course;
    public $date;
    public User $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Course $course, $date, User $teacher)
    {
        $this->course = $course;
        $this->date = $date;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.decline');
    }
}
