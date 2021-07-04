<?php

declare(strict_types=1);

namespace App\Domain\Name;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 */
class NamePattern extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function nameIdea(): BelongsTo
    {
        return $this->belongsTo(NameIdea::class, 'name_idea_id', 'id');
    }
}
