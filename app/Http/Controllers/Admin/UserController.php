<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
       public function index()
    {
        return response()->json(User::all());
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,user',
        'status' => 'required|in:active,pending,suspended,banned,inactive,archived',
        'avatar' => 'nullable|string|max:255',
        'notifications_enabled' => 'boolean',
        'notification_type' => 'nullable|string|in:email,sms,push',
        'badges' => 'nullable|string',
        'permissions' => 'nullable|string',
        'session_history' => 'nullable|string',
    ]);

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);

    return response()->json($user, 201);
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:6',
        'role' => 'sometimes|in:admin,user',
        'status' => 'sometimes|in:active,pending,suspended,banned,inactive,archived',
        'avatar' => 'nullable|string|max:255',
        'notifications_enabled' => 'boolean',
        'notification_type' => 'nullable|string|in:email,sms,push',
        'badges' => 'nullable|string',
        'permissions' => 'nullable|string',
        'session_history' => 'nullable|string',
    ]);

    if (isset($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    }

    $user->update($validated);

    return response()->json($user);
}

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}