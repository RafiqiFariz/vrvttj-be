<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\StudentsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StudentRequest;
use App\Http\Resources\V1\StudentResource;
use App\Models\Student;
use App\Traits\RequestSourceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentController extends Controller
{
    use RequestSourceHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorizeRequest($request, 'student_access');

        $filter = new StudentsFilter();
        $filterItems = $filter->transform($request);

        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);
        $includeUser = $request->query('includeUser', 'false');
        $includeAnswer = $request->query('includeAnswer', 'false');

        $students = Student::where($filterItems);

        if ($includeUser == 'true' || $includeUser == '1') {
            $students = $students->with('user');
        }

        if ($includeAnswer == 'true' || $includeAnswer == '1') {
            $students = $students->with('answers');
        }

        if ($paginate == 'false' || $paginate == '0') {
            return StudentResource::collection($students->get());
        }

        return StudentResource::collection($students->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request): JsonResponse
    {
        $student = Student::create($request->all());
        return response()->json([
            "message" => "Student created successfully",
            "data" => new StudentResource($student),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): StudentResource
    {
        $this->authorizeRequest(request(), 'student_show');

        $includeUser = request()->query('includeUser');
        $includeAnswer = request()->query('includeAnswer');

        if ($includeUser) {
            $student->load('user');
        }

        if ($includeAnswer) {
            $student->load('answers');
        }

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student): JsonResponse
    {
        $student->update($request->all());

        return response()->json([
            "message" => "Student $student->id updated successfully",
            "data" => new StudentResource($student),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): JsonResponse
    {
        $this->authorizeRequest(request(), 'student_delete');

        $student->delete();
        return response()->json([
            "message" => "Student deleted successfully",
        ]);
    }
}
