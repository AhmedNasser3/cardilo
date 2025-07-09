<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
        ];
    }
}