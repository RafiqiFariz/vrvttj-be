<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class QuizAttemptsFilter extends APIFilter
{
    protected array $safeParams = [
        'quizID' => ['eq', 'ne'],
        'studentID' => ['eq', 'ne'],
    ];

    // ini ngga kepakai
    protected array $columnMap = [
        'quizID' => 'quiz_id',
        'studentID' => 'student_id',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'gt' => '>',
        'lt' => '<',
    ];
}
