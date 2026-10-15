<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ShortUrl extends Model { protected $fillable = ['company_id','created_by','code','original_url']; public function company(): BelongsTo { return $this->belongsTo(Company::class); } public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); } }
