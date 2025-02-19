<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class DanceCostumesFilter extends APIFilter
{
    protected array $safeParams = [
        'name' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
