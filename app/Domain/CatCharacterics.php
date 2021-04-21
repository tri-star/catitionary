<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \App\Domain\CatCharacterics
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics query()
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatCharacterics whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatCharacterics extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
}
