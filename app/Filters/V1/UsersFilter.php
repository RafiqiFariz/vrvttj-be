<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class UsersFilter extends APIFilter
{
    protected array $safeParams = [
        'name' => ['eq', 'ne'],
        'email' => ['eq', 'ne'],
        'role_id' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
