<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|in:admin,user',
            'status' => 'sometimes|in:active,pending,suspended,banned,inactive,archived',
            'avatar' => 'nullable|string|max:255',
            'notifications_enabled' => 'boolean',
            'notification_type' => 'nullable|string|in:email,sms,push',
            'badges' => 'nullable|string',
            'permissions' => 'nullable|string',
            'session_history' => 'nullable|string',
        ];
    }
}