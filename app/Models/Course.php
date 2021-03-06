<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $name
 * @property int $hours
 * @property string $description
 * @property string $price
 * @property int $language_id
 * @property int $teacher_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course query()
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereDescription($value)
 * @method static Builder|Course whereHours($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereLanguageId($value)
 * @method static Builder|Course whereName($value)
 * @method static Builder|Course wherePrice($value)
 * @method static Builder|Course whereTeacherId($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\User $teacher
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hours', 'description', 'price', 'language_id', 'teacher_id'];

    /*
     * The users that have signed up this course.
     */
    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('cost');
    }

    /*
     * The users that take part in this course.
     */
    public function participants() {
        return $this->belongsToMany(User::class, 'course_participant')->withTimestamps();
    }

    /*
     * The user that teaches this course.
     */
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /*
     * The language that this course teaches.
     */
    public function language() {
        return $this->belongsTo(Language::class);
    }
}
