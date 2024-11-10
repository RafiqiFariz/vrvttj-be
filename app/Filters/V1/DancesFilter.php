<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class DancesFilter extends APIFilter
{
    protected array $safeParams = [
        'name' => ['eq', 'ne'],
        'danceTypeID' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [
        'danceTypeID' => 'dance_type_id',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
