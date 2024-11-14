<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class QuizOptionsFilter extends APIFilter
{
    protected array $safeParams = [
        'is_correct' => ['eq', 'ne'],
        'score' => ['eq', 'ne', 'gt', 'lt'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'gt' => '>',
        'lt' => '<',
    ];
}
