<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class StudentAnswersFilter extends APIFilter
{
    protected array $safeParams = [
        'quizAttemptID' => ['eq', 'ne'],
        'quizQuestionID' => ['eq', 'ne'],
        'quizOptionID' => ['eq', 'ne'],
        'isCorrect' => ['eq', 'ne'],
    ];

    protected array $columnMap = [
        'quizAttemptID' => 'quiz_attempt_id',
        'quizQuestionID' => 'quiz_question_id',
        'quizOptionID' => 'quiz_option_id',
        'isCorrect' => 'is_correct',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
    ];
}
