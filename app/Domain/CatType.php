<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\CatType
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CatType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CatType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $key
 * @method static \Database\Factories\Domain\CatTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CatType whereKey($value)
 */
class CatType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
