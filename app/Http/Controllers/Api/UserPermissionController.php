<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserPermissionController extends Controller
{
    public function assignRole (Request $request)
    {
        $apiKey = $request->header('x-api-key');
        // $body = $request->body('user-role');
        
        if($apiKey != env('USER_PERMISSION_API_KEY'))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $validated = $request->validate([
                'user_name' => 'required|string',
                'role' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $userName = $request->input('user_name');
        $role = $request->input('role');

        return response()->json([
            'status' => 'success',
            'message' => "Assigned '{$userName}' to role '{$role}' successfully",
        ]);
    }
}
