<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\StudentAnswersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MassStudentAnswerRequest;
use App\Http\Requests\V1\StudentAnswerRequest;
use App\Http\Resources\V1\StudentAnswerResource;
use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\StudentAnswer;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class StudentAnswerController extends Controller
{
    use RequestSourceHandler;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'student_answer_access');

        $filter = new StudentAnswersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuizAttempt = $request->query('includeQuizAttempt', 'false');
        $includeQuizQuestion = $request->query('includeQuizQuestion', 'false');
        $includeQuizOption = $request->query('includeQuizOption', 'false');

        $studentAnswers = StudentAnswer::where($filterItems);

        if ($includeQuizAttempt == 'true' || $includeQuizAttempt == '1') {
            $studentAnswers = $studentAnswers->with('quizAttempt');
        }

        if ($includeQuizQuestion == 'true' || $includeQuizQuestion == '1') {
            $studentAnswers = $studentAnswers->with('quizQuestion');
        }

        if ($includeQuizOption == 'true' || $includeQuizOption == '1') {
            $studentAnswers = $studentAnswers->with('quizOption');
        }

        if ($paginate == 'false' || $paginate == '0') {
            return StudentAnswerResource::collection($studentAnswers->get());
        }

        return StudentAnswerResource::collection($studentAnswers->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentAnswerRequest $request): JsonResponse
    {
        $studentAnswer = StudentAnswer::create($request->all());
        return response()->json([
            "message" => "Student answer created successfully",
            "data" => new StudentAnswerResource($studentAnswer),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentAnswer $studentAnswer): StudentAnswerResource
    {
        $this->authorizeRequest(request(), 'student_answer_show');
        return new StudentAnswerResource($studentAnswer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentAnswerRequest $request, StudentAnswer $studentAnswer): JsonResponse
    {
        $studentAnswer->update($request->all());

        return response()->json([
            "message" => "Student answer $studentAnswer->id updated successfully",
            "data" => new StudentAnswerResource($studentAnswer),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAnswer $studentAnswer): JsonResponse
    {
        $this->authorizeRequest(request(), 'student_answer_delete');

        $studentAnswer->delete();
        return response()->json([
            "message" => "Student answer deleted successfully",
        ]);
    }

    /**
     * Bulk store a newly created resource in storage.
     */
    public function massStore(MassStudentAnswerRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            StudentAnswer::insert($request->all());

            // Hitung skor akhir dengan menghitung jumlah jawaban benar dan bobot soal
            $quizAttemptId = collect($request->all())->first()['quiz_attempt_id'];
            $quizAttempt = QuizAttempt::find($quizAttemptId);

            $quizQuestions = $quizAttempt->quiz->questions;
            $totalScore = 0;

            foreach ($quizQuestions as $quizQuestion) {
                $quizOptions = $quizQuestion->load('options')->options;
                $correctOption = $quizOptions->where('is_correct', true)->first();
                $studentAnswer = StudentAnswer::where('quiz_attempt_id', $quizAttemptId)
                    ->where('quiz_question_id', $quizQuestion->id)
                    ->first();
                if ($studentAnswer->quiz_option_id == $correctOption->id) {
                    $totalScore += $quizQuestion->weight;
                }
            }

            $quizAttempt->update(['score' => $totalScore]);

            $totalQuestions = $quizQuestions->count();
            $correctAnswers = collect($request->all())->where('is_correct', true)->count();
            $wrongAnswers = $totalQuestions - $correctAnswers;
            $totalCorrectScore = $quizQuestions->sum('weight');

            QuizResult::create([
                'quiz_id' => $quizAttempt->quiz_id,
                'student_id' => $quizAttempt->student_id,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'final_score' => $totalScore / $totalCorrectScore * 100,
                'completed_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                "message" => "Student answers created successfully",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => "Failed to create student answers",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
}
