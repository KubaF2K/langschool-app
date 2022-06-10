<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string|null $img
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Course[] $courses
 * @property-read Collection|User[] $users
 * @property-read int|null $courses_count
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereCode($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereDescription($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereImg($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $fillable = ['code', 'name', 'description', 'img'];

    /*
     * The courses that teach this language.
     */
    public function courses() {
        return $this->hasMany(Course::class);
    }

    /*
     * The teachers that have this language assigned.
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    use HasFactory;
}
