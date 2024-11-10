<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada user yang terautentikasi, jika ada maka atur hak aksesnya
        if ($request->user()) {
            $roles = Role::with('permissions')->get();
            $permissions = [];

            foreach ($roles as $role) {
                // Siapa saja yang memiliki hak akses (permission) ini
                foreach ($role->permissions as $permission) {
                    $permissions[$permission->name][] = $role->id; //['user_edit' => [1, 3]]
                }
            }

            foreach ($permissions as $name => $role) {
                /**
                 * Cek apakah user yang bersangkutan memiliki hak akses tertentu,
                 * jika punya maka definisikan gatenya
                 */
                Gate::define($name, function ($user) use ($role) {
                    return in_array($user->role->id, $role);
                });
            }
        }

        return $next($request);
    }
}
