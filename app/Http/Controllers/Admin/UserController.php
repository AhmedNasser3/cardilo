<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = DB::transaction(fn () => User::create([
            ...$request->validated(),
            'password' => bcrypt($request->password),
        ]));

        return UserResource::make($user)
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(fn () => $user->update([
            ...$request->validated(),
            'password' => $request->filled('password')
                ? bcrypt($request->password)
                : $user->password,
        ]));

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        DB::transaction(fn () => $user->delete());

        return response()->json(['message' => 'User deleted']);
    }

    public function updateOrder(Request $request)
    {
        DB::transaction(fn () =>
            collect($request->ordered)
                ->each(fn ($item) =>
                    User::whereId($item['id'])->update(['order' => $item['order']])
                )
        );

        return response()->json(['status' => 'success']);
    }
}
