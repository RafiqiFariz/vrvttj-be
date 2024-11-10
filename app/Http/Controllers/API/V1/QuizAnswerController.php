<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizAnswersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizAnswerRequest;
use App\Http\Resources\V1\QuizAnswerCollection;
use App\Http\Resources\V1\QuizAnswerResource;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuizAnswerCollection
    {
        abort_if(Gate::denies('quiz_answer_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizAnswersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeStudent = $request->query('includeStudent', 'false');
        $includeQuiz = $request->query('includeQuiz', 'false');

        $quizAnswers = QuizAnswer::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new QuizAnswerCollection($quizAnswers->get());
        }

        if ($includeStudent == 'true' || $includeStudent == '1') {
            $quizAnswers = $quizAnswers->with('student');
        }

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizAnswers = $quizAnswers->with('quiz');
        }

        return new QuizAnswerCollection($quizAnswers->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizAnswerRequest $request): \Illuminate\Http\JsonResponse
    {
        $quizAnswer = QuizAnswer::create($request->all());
        return response()->json([
            "message" => "Quiz answer created successfully",
            "data" => $quizAnswer,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizAnswer $quizAnswer): QuizAnswerResource
    {
        return new QuizAnswerResource($quizAnswer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizAnswerRequest $request, QuizAnswer $quizAnswer): \Illuminate\Http\JsonResponse
    {
        $quizAnswer->update($request->all());

        return response()->json([
            "message" => "Quiz answer $quizAnswer->id updated successfully",
            "data" => $quizAnswer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizAnswer $quizAnswer): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('quiz_answer_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $quizAnswer->delete();
        return response()->json([
            "message" => "Quiz answer deleted successfully",
        ]);
    }
}
