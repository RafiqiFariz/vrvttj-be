<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\QuizQuestionRequest;
use App\Http\Resources\V1\QuizQuestionResource;
use App\Models\QuizQuestion;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuizQuestionController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'quiz_question_access');

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeQuiz = $request->query('includeQuiz', 'false');
        $includeOptions = $request->query('includeOptions', 'false');

        // Kedepannya bisa diganti dengan route model binding (pakai konsep parent child).
        // Pakai ini supaya cepat proses developmentnya.
        $quizId = $request->query('quizID');

        $quizQuestions = QuizQuestion::query();

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizQuestions = $quizQuestions->with('quiz');
        }

        if ($includeOptions == 'true' || $includeOptions == '1') {
            $quizQuestions = $quizQuestions->with('options');
        }

        if ($quizId) {
            $quizQuestions = $quizQuestions->where('quiz_id', $quizId);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return QuizQuestionResource::collection($quizQuestions->get());
        }

        return QuizQuestionResource::collection($quizQuestions->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizQuestionRequest $request): JsonResponse
    {
        $quizQuestion = QuizQuestion::create($request->except('options'));
        $quizQuestion->options()->createMany($request->input('options', []));

        return response()->json([
            "message" => "Quiz question created successfully",
            "data" => new QuizQuestionResource($quizQuestion),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizQuestion $quizQuestion): QuizQuestionResource
    {
        $this->authorizeRequest(request(), 'quiz_question_show');

        $includeQuiz = request()->query('includeQuiz');
        $includeOptions = request()->query('includeOptions');

        if ($includeQuiz == 'true' || $includeQuiz == '1') {
            $quizQuestion->load('quiz');
        }

        if ($includeOptions == 'true' || $includeQuiz == '1') {
            $quizQuestion->load('options');
        }

        return new QuizQuestionResource($quizQuestion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizQuestionRequest $request, QuizQuestion $quizQuestion): JsonResponse
    {
        $quizQuestion->update($request->except('options'));

        // Ambil data options dari request
        $optionsData = $request->input('options', []);

        // Dapatkan semua id dari options dalam request
        $optionIdsInRequest = collect($optionsData)->pluck('id')->filter()->all(); // Ambil id yang ada dan bukan null

        // Hapus options yang tidak ada dalam request
        $quizQuestion->options()->whereNotIn('id', $optionIdsInRequest)->delete();

        // Pisahkan antara option yang ada id (update) dan yang tidak ada id (insert)
        $upsertData = [];
        foreach ($optionsData as $option) {
            $upsertData[] = [
                'id' => $option['id'] ?? null, // gunakan 'id' jika ada, null jika data baru
                'quiz_question_id' => $quizQuestion->id,
                'answer' => $option['answer'],
                'is_correct' => $option['is_correct'],
            ];
        }

        // Lakukan upsert untuk update atau create data options
        $quizQuestion->options()->upsert($upsertData, uniqueBy: ['id'], update: ['answer', 'is_correct']);

        return response()->json([
            "message" => "Quiz question updated successfully",
            "data" => new QuizQuestionResource($quizQuestion),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizQuestion $quizQuestion): JsonResponse
    {
        $this->authorizeRequest(request(), 'quiz_question_delete');

        $quizQuestion->delete();
        return response()->json([
            "message" => "Quiz question deleted successfully",
        ]);
    }
}
