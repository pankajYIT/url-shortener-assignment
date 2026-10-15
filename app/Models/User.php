<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; use Illuminate\Database\Eloquent\Relations\BelongsTo; use Illuminate\Database\Eloquent\Relations\HasMany; use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use Notifiable; protected $fillable = ['company_id','name','email','password','role']; protected $hidden = ['password','remember_token']; protected function casts(): array { return ['password'=>'hashed']; } public function company(): BelongsTo { return $this->belongsTo(Company::class); } public function shortUrls(): HasMany { return $this->hasMany(ShortUrl::class, 'created_by'); } public function hasRole(string ...$roles): bool { return in_array($this->role, $roles, true); } }
