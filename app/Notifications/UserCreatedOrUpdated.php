<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserCreatedOrUpdated extends Notification
{
    use Queueable;

    protected $user;
    protected $action;

    public function __construct($user, $action = 'created')
    {
        $this->user = $user;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'User ' . ucfirst($this->action),
            'body' => "User {$this->user->name} has been {$this->action}.",
            'extra' => [
                'user_id' => $this->user->id,
                'email' => $this->user->email,
            ],
        ];
    }
}