<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class QuizzesFilter extends APIFilter
{
    protected array $safeParams = [
        'type' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
