<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Notifications\UserCreatedOrUpdated;

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

    public function store(StoreUserRequest $req)
    {
        $user = DB::transaction(function () use ($req) {
            return User::create([
                ...$req->validated(),
                'password' => bcrypt($req->password),
            ]);
        });

        $this->notifyAdmins($user, 'created');

        return UserResource::make($user)->response()->setStatusCode(201);
    }

    public function update(UpdateUserRequest $req, User $user)
    {
        DB::transaction(function () use ($req, $user) {
            $user->update([
                ...$req->validated(),
                'password' => $req->filled('password') ? bcrypt($req->password) : $user->password
            ]);
        });

        $this->notifyAdmins($user, 'updated');

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        DB::transaction(fn () => $user->delete());
        return response()->json(['message' => 'User deleted']);
    }

    public function updateOrder(Request $req)
    {
        DB::transaction(fn () =>
            collect($req->ordered)->each(
                fn ($i) => User::whereId($i['id'])->update(['order' => $i['order']])
            )
        );
        return response()->json(['status' => 'success']);
    }

protected function notifyAdmins(User $user, $action)
{
    User::all()->each(function ($u) use ($user, $action) {
        $u->notify(new UserCreatedOrUpdated($user, $action));
    });
}

}