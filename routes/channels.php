<?php

use App\Models\Application;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-chat.{application_id}', function ($user, $application_id) {
    $application = Application::find($application_id);
    return (string) $user->id === (string) $application->user->id || $user->is_recruiter;
});
