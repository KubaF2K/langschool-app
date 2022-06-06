<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function view(User $user, Course $course)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->role->name == 'admin' || $user->role->name == 'teacher';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function update(User $user, Course $course)
    {
        return $user->role->name == 'admin' || ($user->role->name == 'teacher' && $user->id == $course->teacher_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function delete(User $user, Course $course)
    {
        return $user->role->name == 'admin' || ($user->role->name == 'teacher' && $user->id == $course->teacher_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function restore(User $user, Course $course)
    {
        return $user->role->name == 'admin' || ($user->role->name == 'teacher' && $user->id == $course->teacher_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Course $course
     * @return Response|bool
     */
    public function forceDelete(User $user, Course $course)
    {
        return $user->role->name == 'admin' || ($user->role->name == 'teacher' && $user->id == $course->teacher_id);
    }
}
