<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizResultsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizResultRequest;
use App\Http\Resources\V1\QuizResultResource;
use App\Models\QuizResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        abort_if(Gate::denies('quiz_result_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizResultsFilter();
        $filterItems = $filter->transform($request);

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuiz = $request->query('includeQuiz', 'false');
        $includeStudent = $request->query('includeStudent', 'false');

        $quizResults = QuizResult::where($filterItems);

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizResults = $quizResults->with('quiz');
        }

        if ($includeStudent == 'true' || $includeStudent == '1') {
            $quizResults = $quizResults->with('student');
        }

        if ($paginate == 'false' || $paginate == '0') {
            return QuizResultResource::collection($quizResults->get());
        }

        return QuizResultResource::collection($quizResults->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizResultRequest $request): JsonResponse
    {
        $quiz = QuizResult::create($request->all());
        return response()->json([
            "message" => "Quiz result created successfully",
            "data" => new QuizResultResource($quiz),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizResult $quizResult): QuizResultResource
    {
        return new QuizResultResource($quizResult);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizResultRequest $request, QuizResult $quizResult): JsonResponse
    {
        $quizResult->update($request->all());

        return response()->json([
            "message" => "Quiz result $quizResult->id updated successfully",
            "data" => new QuizResultResource($quizResult),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizResult $quizResult): JsonResponse
    {
        abort_if(Gate::denies('quiz_result_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $quizResult->delete();
        return response()->json([
            "message" => "Quiz result deleted successfully",
        ]);
    }
}
