<?php

declare(strict_types=1);

namespace App\Validation;

class ValidationErrorItem
{
    const CODE_GENERAL = 'general';
    const CODE_MISSING = 'missing';
    const CODE_INVALID = 'invalid';
    const CODE_OUT_OF_RANGE = 'out_of_range';
    const CODE_DUPLICATE = 'duplicate';
}
