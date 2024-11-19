<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\UsersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserStoreRequest;
use App\Http\Requests\V1\UserUpdateRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $filter = new UsersFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $includeRole = $request->query('includeRole');
        $paginate = $request->query('paginate');
        $pageSize = $request->query('pageSize', 20);

        $users = User::where($filterItems);

        if ($includeRole) {
            $users = $users->with(['role']);
        }

        if ($paginate == 'false' || $paginate == '0') {
            return UserResource::collection($users->get());
        }

        return UserResource::collection($users->paginate($pageSize)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $request['password'] = bcrypt($request->password);

        $user = User::create($request->except('nrp', 'nim'));

        if ((int)$request->role_id === 2) {
            $user->lecturer()->create(["nrp" => $request->nrp]);
        } else if ((int)$request->role_id === 3) {
            $user->student()->create(["nim" => $request->nim]);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storePubliclyAs("images", $photoName);
            $user->update(["photo" => $photoName]);
        }

        return response()->json([
            "message" => "User created successfully",
            "data" => new UserResource($user),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $includeRole = request()->query('includeRole');

        if ($includeRole) {
            return new UserResource($user->loadMissing('role'));
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        if (!empty($request->password)) {
            $request['password'] = bcrypt($request->password);
            $user->update(["password" => $request->password]);
        }

        if ($request->photo !== $user->photo && !empty($user->photo) && !empty($request->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update($request->except('password', 'nrp', 'nim'));

        if ($request->old_role_id === 2 && $user->role_id === 2) {
            // Jika peran lama dan baru adalah 'lecturer', update NRP
            $user->lecturer()->update(["nrp" => $request->nrp]);
        } elseif ($request->old_role_id === 2 && $user->role_id !== 2) {
            // Jika peran lama adalah 'lecturer' tapi sekarang bukan,
            // buat data student baru dan hapus data lecturer
            $user->student()->create(["nim" => $request->nim]);
            $user->lecturer()->delete();
        } elseif ($request->old_role_id === 3 && $user->role_id === 3) {
            // Jika peran lama dan baru adalah 'student', update NIM
            $user->student()->update(["nim" => $request->nim]);
        } elseif ($request->old_role_id === 3 && $user->role_id !== 3) {
            // Jika peran lama adalah 'student' tapi sekarang bukan,
            // buat data lecturer baru dan hapus data student
            $user->lecturer()->create(["nrp" => $request->nrp]);
            $user->student()->delete();
        }

        return response()->json([
            "message" => "User $user->id updated successfully.",
            "data" => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        Storage::disk('public')->delete($user->photo);
        $user->delete();
        return response()->json(["message" => "User deleted successfully."]);
    }
}
