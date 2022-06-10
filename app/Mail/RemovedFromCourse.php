<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemovedFromCourse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Course The course that the user was removed from.
     */
    public Course $course;
    public User $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Course $course, User $teacher)
    {
        $this->course = $course;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.remove');
    }
}
