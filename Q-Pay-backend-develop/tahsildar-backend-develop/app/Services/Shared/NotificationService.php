<?php

namespace App\Services\Shared;



use App\Notifications\UserNotification;
use App\Repositories\Eloquent\UserRepository;

class NotificationService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function send($user_id,$title,$body,$payload = []): void
    {
        $payload['image'] = $payload['image'] ??  asset('images/notifications/default.png');
        $user = $this->userRepository->findById($user_id);
        $user->notify(new UserNotification($title,$body,$payload));
    }

}
