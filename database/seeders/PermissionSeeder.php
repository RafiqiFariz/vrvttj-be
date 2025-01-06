<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'user_access'],
            ['name' => 'user_create'],
            ['name' => 'user_update'],
            ['name' => 'user_delete'],
            ['name' => 'user_restore'],
            ['name' => 'user_show'],

            // Student Management
            ['name' => 'student_access'],
            ['name' => 'student_create'],
            ['name' => 'student_update'],
            ['name' => 'student_delete'],
            ['name' => 'student_restore'],
            ['name' => 'student_show'],

            // Dance Type Management
            ['name' => 'dance_type_access'],
            ['name' => 'dance_type_create'],
            ['name' => 'dance_type_update'],
            ['name' => 'dance_type_delete'],
            ['name' => 'dance_type_show'],

            // Dance Management
            ['name' => 'dance_access'],
            ['name' => 'dance_create'],
            ['name' => 'dance_update'],
            ['name' => 'dance_delete'],
            ['name' => 'dance_show'],

            // Dance Part Management
            ['name' => 'dance_part_access'],
            ['name' => 'dance_part_create'],
            ['name' => 'dance_part_update'],
            ['name' => 'dance_part_delete'],
            ['name' => 'dance_part_show'],

            // Dance Part Video Management
            ['name' => 'dance_part_video_access'],
            ['name' => 'dance_part_video_create'],
            ['name' => 'dance_part_video_update'],
            ['name' => 'dance_part_video_delete'],
            ['name' => 'dance_part_video_show'],

            // Dance Move Management
            ['name' => 'dance_move_access'],
            ['name' => 'dance_move_create'],
            ['name' => 'dance_move_update'],
            ['name' => 'dance_move_delete'],
            ['name' => 'dance_move_show'],

            // Dance Costume Management
            ['name' => 'dance_costume_access'],
            ['name' => 'dance_costume_create'],
            ['name' => 'dance_costume_update'],
            ['name' => 'dance_costume_delete'],
            ['name' => 'dance_costume_show'],

            // Quiz Management
            ['name' => 'quiz_access'],
            ['name' => 'quiz_create'],
            ['name' => 'quiz_update'],
            ['name' => 'quiz_delete'],
            ['name' => 'quiz_show'],

            // Quiz Question Management
            ['name' => 'quiz_question_access'],
            ['name' => 'quiz_question_create'],
            ['name' => 'quiz_question_update'],
            ['name' => 'quiz_question_delete'],
            ['name' => 'quiz_question_show'],

            // Quiz Option Management
            ['name' => 'quiz_option_access'],
            ['name' => 'quiz_option_create'],
            ['name' => 'quiz_option_update'],
            ['name' => 'quiz_option_delete'],
            ['name' => 'quiz_option_show'],

            // Quiz Attempt Management
            ['name' => 'quiz_attempt_access'],
            ['name' => 'quiz_attempt_create'],
            ['name' => 'quiz_attempt_update'],
            ['name' => 'quiz_attempt_delete'],
            ['name' => 'quiz_attempt_show'],

            // Quiz Student Answer Management
            ['name' => 'student_answer_access'],
            ['name' => 'student_answer_create'],
            ['name' => 'student_answer_update'],
            ['name' => 'student_answer_delete'],
            ['name' => 'student_answer_show'],

            // Quiz Result Management
            ['name' => 'quiz_result_access'],
            ['name' => 'quiz_result_create'],
            ['name' => 'quiz_result_update'],
            ['name' => 'quiz_result_delete'],
            ['name' => 'quiz_result_show'],

            // Role Management
            ['name' => 'role_access'],
            ['name' => 'role_create'],
            ['name' => 'role_update'],
            ['name' => 'role_delete'],
            ['name' => 'role_show'],

            // Permission Management
            ['name' => 'permission_access'],
            ['name' => 'permission_create'],
            ['name' => 'permission_update'],
            ['name' => 'permission_delete'],
            ['name' => 'permission_show'],

            // Permission Role Management
            ['name' => 'permission_role_access'],
            ['name' => 'permission_role_create'],
            ['name' => 'permission_role_update'],
            ['name' => 'permission_role_delete'],
            ['name' => 'permission_role_show'],

            // Update Profile Request Management
            ['name' => 'update_profile_request_access'],
            ['name' => 'update_profile_request_create'],
            ['name' => 'update_profile_request_update'],
            ['name' => 'update_profile_request_edit_status'],
            ['name' => 'update_profile_request_show'],

            // Report Management
            ['name' => 'report_create'],
        ];

        Permission::insert($permissions);
    }
}
