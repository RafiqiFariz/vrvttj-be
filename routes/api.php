<?php

use App\Http\Controllers\API\V1\DanceClothesController;
use App\Http\Controllers\API\V1\DanceController;
use App\Http\Controllers\API\V1\DanceMoveController;
use App\Http\Controllers\API\V1\DancePartController;
use App\Http\Controllers\API\V1\DanceTypeController;
use App\Http\Controllers\API\V1\LecturerController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\API\V1\QuizAnswerController;
use App\Http\Controllers\API\V1\QuizController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\UploadImageController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResources([
            'dances' => DanceController::class,
            'dance-types' => DanceTypeController::class,
            'dance-moves' => DanceMoveController::class,
            'dance-parts' => DancePartController::class,
            'dance-clothes' => DanceClothesController::class,
            'lecturers' => LecturerController::class,
            'students' => StudentController::class,
            'quizzes' => QuizController::class,
            'quiz-answers' => QuizAnswerController::class,
            'permissions' => PermissionController::class,
            'roles' => RoleController::class,
            'users' => UserController::class,
        ]);

        Route::post('upload', [UploadImageController::class, 'upload']);
    });
});
