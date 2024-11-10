<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizzesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizRequest;
use App\Http\Resources\V1\QuizCollection;
use App\Http\Resources\V1\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuizCollection
    {
        abort_if(Gate::denies('quiz_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizzesFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $quizzes = Quiz::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new QuizCollection($quizzes->get());
        }

        return new QuizCollection($quizzes->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request): \Illuminate\Http\JsonResponse
    {
        $quiz = Quiz::create($request->all());
        return response()->json([
            "message" => "Quiz created successfully",
            "data" => $quiz,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz): QuizResource
    {
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
            "data" => $quiz,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('quiz_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $quiz->delete();
        return response()->json([
            "message" => "Quiz deleted successfully",
        ]);
    }
}
