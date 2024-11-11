<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\QuizAnswersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizOptionRequest;
use App\Http\Resources\V1\QuizOptionCollection;
use App\Http\Resources\V1\QuizOptionResource;
use App\Models\QuizOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuizOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuizOptionCollection
    {
        abort_if(Gate::denies('quiz_option_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new QuizAnswersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuizQuestion = $request->query('includeQuizQuestion', 'false');

        $quizOptions = QuizOption::where($filterItems);

        if ($paginate == 'false' || $paginate == '0') {
            return new QuizOptionCollection($quizOptions->get());
        }

        if ($includeQuizQuestion == 'true' || $includeQuizQuestion == '1') {
            $quizOptions = $quizOptions->with('quiz');
        }

        return new QuizOptionCollection($quizOptions->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizOptionRequest $request): \Illuminate\Http\JsonResponse
    {
        $quizOption = QuizOption::create($request->all());
        return response()->json([
            "message" => "Quiz option created successfully",
            "data" => $quizOption,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizOption $quizOption): QuizOptionResource
    {
        return new QuizOptionResource($quizOption);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizOptionRequest $request, QuizOption $quizOption): \Illuminate\Http\JsonResponse
    {
        $quizOption->update($request->all());

        return response()->json([
            "message" => "Quiz option $quizOption->id updated successfully",
            "data" => $quizOption,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizOption $quizOption): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('quiz_option_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $quizOption->delete();
        return response()->json([
            "message" => "Quiz option deleted successfully",
        ]);
    }
}
