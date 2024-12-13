<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\StudentAnswersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StudentAnswerRequest;
use App\Http\Resources\V1\StudentAnswerResource;
use App\Models\StudentAnswer;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
}
