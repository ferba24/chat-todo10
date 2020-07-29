<?php
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;

Broadcast::channel('chat', function() {
    return true;
});
/*Broadcast::channel('online', function (Request $req, $user) {
    \Log::info($req);
    if (auth()->check()) {
        return $user->toArray();
    }
});*/