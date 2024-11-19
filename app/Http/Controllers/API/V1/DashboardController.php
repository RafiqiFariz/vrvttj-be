<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\DanceClothes;
use App\Models\DanceMove;
use App\Models\DanceType;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $students = Student::count();
        $danceTypes = DanceType::count();
        $danceMoves = DanceMove::count();
        $danceClothes = DanceClothes::count();

        return response()->json([
            'data' => [
                'students' => $students,
                'dance_types' => $danceTypes,
                'dance_moves' => $danceMoves,
                'dance_clothes' => $danceClothes,
            ],
            'status' => 'success',
        ]);
    }
}
