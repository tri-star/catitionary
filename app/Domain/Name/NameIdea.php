<?php

declare(strict_types=1);

namespace App\Domain\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Domain\Name\NameIdea
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|CatType[] $catTypes
 * @property-read int|null $cat_types_count
 * @method static \Database\Factories\Domain\Name\NameIdeaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea query()
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NameIdea whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|CatCharacterics[] $catCharacterics
 * @property-read int|null $cat_characterics_count
 */
class NameIdea extends Model
{
    use HasFactory;

    const NAME_MAX_LENGTH = 50;

    protected $fillable = [
        'name',
    ];

    public function catTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            CatType::class,
            'name_ideas_cat_types',
            'name_idea_id',
            'cat_type_id',
            'id',
            'id'
        );
    }


    public function catCharacterics(): BelongsToMany
    {
        return $this->belongsToMany(
            CatCharacterics::class,
            'name_ideas_cat_characterics',
            'name_idea_id',
            'cat_characterics_id',
            'id',
            'id'
        );
    }
}
