<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\AuthController; use App\Http\Controllers\ShortUrlController; use App\Http\Controllers\InvitationController;
Route::get('/', fn()=>auth()->check()?redirect('/urls'):redirect('/login'));
Route::get('/login',[AuthController::class,'showLogin'])->name('login'); Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth')->group(function(){ Route::post('/logout',[AuthController::class,'logout']); Route::get('/urls',[ShortUrlController::class,'index']); Route::get('/urls/create',[ShortUrlController::class,'create']); Route::post('/urls',[ShortUrlController::class,'store']); Route::get('/s/{code}',[ShortUrlController::class,'resolve'])->where('code','[A-Za-z0-9]{8}'); Route::get('/invitations/create',[InvitationController::class,'create']); Route::post('/invitations',[InvitationController::class,'store']); });
