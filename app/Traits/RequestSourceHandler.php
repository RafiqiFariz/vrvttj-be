<?php

namespace App\Traits;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

trait RequestSourceHandler
{
    public function authorizeRequest($request, $abilities): true
    {
        $abilities = (array)$abilities;

        if ($request->hasHeader('Authorization')) {
            // Dari Mobile App/Postman/Game Engine
            foreach ($abilities as $ability) {
                if (!$request->user() || !$request->user()->tokenCan($ability)) {
                    abort(Response::HTTP_FORBIDDEN, 'Forbidden: Missing or invalid permissions.');
                }
            }
            return true;
        } else {
            // Dari SPA
            foreach ($abilities as $ability) {
                if (Gate::denies($ability)) {
                    abort(Response::HTTP_FORBIDDEN, 'Forbidden: No access for this action.');
                }
            }
            return true;
        }
    }
}

