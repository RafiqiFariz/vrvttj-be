<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class QuizResultsFilter extends APIFilter
{
    protected array $safeParams = [
        'quizID' => ['eq', 'ne'],
        'studentID' => ['eq', 'ne'],
        'finalScore' => ['eq', 'ne', 'gt', 'lt'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [
        'quizID' => 'quiz_id',
        'studentID' => 'student_id',
        'finalScore' => 'final_score',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'gt' => '>',
        'lt' => '<',
    ];
}
