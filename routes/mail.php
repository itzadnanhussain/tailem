<?php

use App\Http\Controllers\MailerController;
use Illuminate\Support\Facades\Route;

Route::get("email", [MailerController::class, "email"])->name("email");

Route::post("send-email", [MailerController::class, "composeEmail"])->name("send-email");
