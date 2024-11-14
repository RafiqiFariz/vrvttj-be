<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class StudentsFilter extends APIFilter
{
    protected array $safeParams = [
        'nim' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
