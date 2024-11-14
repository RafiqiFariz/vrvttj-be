<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizAttemptsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizAttemptRequest;
use App\Http\Resources\V1\QuizAttemptResource;
use App\Models\QuizAttempt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        abort_if(Gate::denies('quiz_attempt_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizAttemptsFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuiz = $request->query('includeQuiz', 'false');
        $includeStudent = $request->query('includeStudent', 'false');

        $quizAttempts = QuizAttempt::where($filterItems);

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizAttempts = $quizAttempts->with('quiz');
        }

        if ($includeStudent == 'true' || $includeStudent == '1') {
            $quizAttempts = $quizAttempts->with('student');
        }

        if ($paginate == 'false' || $paginate == '0') {
            return QuizAttemptResource::collection($quizAttempts->get());
        }

        return QuizAttemptResource::collection($quizAttempts->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizAttemptRequest $request): JsonResponse
    {
        $quizAttempt = QuizAttempt::create($request->all());
        return response()->json([
            "message" => "Quiz attempt created successfully",
            "data" => new QuizAttemptResource($quizAttempt),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizAttempt $quizAttempt): QuizAttemptResource
    {
        $includeQuiz = request()->query('includeQuiz');
        $includeStudent = request()->query('includeStudent');

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizAttempt = $quizAttempt->loadMissing('quiz');
        }

        if ($includeStudent == 'true' || $includeStudent == '1') {
            $quizAttempt = $quizAttempt->loadMissing('student');
        }

        return new QuizAttemptResource($quizAttempt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizAttemptRequest $request, QuizAttempt $quizAttempt): \Illuminate\Http\JsonResponse
    {
        $quizAttempt->update($request->all());

        return response()->json([
            "message" => "Quiz attempt $quizAttempt->id updated successfully",
            "data" => new QuizAttemptResource($quizAttempt),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizAttempt $quizAttempt): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('quiz_attempt_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $quizAttempt->delete();
        return response()->json([
            "message" => "Quiz attempt deleted successfully",
        ]);
    }
}
