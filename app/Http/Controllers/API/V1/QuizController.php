<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizzesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizRequest;
use App\Http\Resources\V1\QuizResource;
use App\Models\Quiz;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'quiz_access');

        $filter = new QuizzesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuestions = $request->query('includeQuestions', 'false');

        $quizzes = Quiz::where($filterItems);

        if ($includeQuestions == 'true' || $includeQuestions == '1') {
            $quizzes = $quizzes->with(['questions']);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return QuizResource::collection($quizzes->get());
        }

        return QuizResource::collection($quizzes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request): \Illuminate\Http\JsonResponse
    {
        $quiz = Quiz::create($request->all());
        return response()->json([
            "message" => "Quiz created successfully",
            "data" => new QuizResource($quiz),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz): QuizResource
    {
        $this->authorizeRequest(request(), 'quiz_show');
        return new QuizResource($quiz);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizRequest $request, Quiz $quiz): \Illuminate\Http\JsonResponse
    {
        $quiz->update($request->all());

        return response()->json([
            "message" => "Quiz $quiz->id updated successfully",
            "data" => new QuizResource($quiz),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz): \Illuminate\Http\JsonResponse
    {
        $this->authorizeRequest(request(), 'quiz_delete');

        $quiz->delete();
        return response()->json([
            "message" => "Quiz deleted successfully",
        ]);
    }
}
