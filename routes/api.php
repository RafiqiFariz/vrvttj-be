<?php

use App\Http\Controllers\API\V1\DanceCostumeController;
use App\Http\Controllers\API\V1\DanceController;
use App\Http\Controllers\API\V1\DanceMoveController;
use App\Http\Controllers\API\V1\DancePartController;
use App\Http\Controllers\API\V1\DancePartVideoController;
use App\Http\Controllers\API\V1\DanceTypeController;
use App\Http\Controllers\API\V1\DashboardController;
use App\Http\Controllers\API\V1\LecturerController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\API\V1\QuizAttemptController;
use App\Http\Controllers\API\V1\QuizOptionController;
use App\Http\Controllers\API\V1\QuizController;
use App\Http\Controllers\API\V1\QuizQuestionController;
use App\Http\Controllers\API\V1\QuizResultController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\StudentAnswerController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\UploadImageController;
use App\Http\Controllers\API\V1\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        Route::apiResources([
            'dances' => DanceController::class,
            'dance-types' => DanceTypeController::class,
            'dance-moves' => DanceMoveController::class,
            'dance-parts' => DancePartController::class,
            'dance-parts.videos' => DancePartVideoController::class,
            'dance-costumes' => DanceCostumeController::class,
            'lecturers' => LecturerController::class,
            'students' => StudentController::class,
            'quizzes' => QuizController::class,
            'quiz-questions' => QuizQuestionController::class,
            'quiz-options' => QuizOptionController::class,
            'quiz-attempts' => QuizAttemptController::class,
            'quiz-results' => QuizResultController::class,
            'student-answers' => StudentAnswerController::class,
            'permissions' => PermissionController::class,
            'roles' => RoleController::class,
            'users' => UserController::class,
        ]);

        Route::apiResource('dance-parts.videos', DancePartVideoController::class)->scoped();

        Route::post('upload', [UploadImageController::class, 'upload']);
    });
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return [
        'token' => $user->createToken(
            $request->device_name,
            $user->role->permissions->pluck('name')->all()
        )->plainTextToken,
    ];
});

Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out']);
})->middleware('auth:sanctum');
