<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizAnswersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizAttemptRequest;
use App\Http\Resources\V1\QuizAttemptCollection;
use App\Http\Resources\V1\QuizAttemptResource;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuizAttemptCollection
    {
        abort_if(Gate::denies('quiz_attempt_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizAnswersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuizQuestion = $request->query('includeQuizQuestion', 'false');

        $quizOptions = QuizAttempt::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new QuizAttemptCollection($quizOptions->get());
        }

        if ($includeQuizQuestion == 'true' || $includeQuizQuestion == '1') {
            $quizOptions = $quizOptions->with('quiz');
        }

        return new QuizAttemptCollection($quizOptions->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizAttemptRequest $request): \Illuminate\Http\JsonResponse
    {
        $quizAttempt = QuizAttempt::create($request->all());
        return response()->json([
            "message" => "Quiz attempt created successfully",
            "data" => $quizAttempt,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizAttempt $quizAttempt): QuizAttemptResource
    {
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
            "data" => $quizAttempt,
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
