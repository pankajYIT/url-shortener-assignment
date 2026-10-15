<?php
namespace App\Http\Controllers;
use App\Models\ShortUrl; use Illuminate\Http\Request; use Illuminate\Support\Str;
class ShortUrlController {
 public function index(Request $request) { $user = $request->user(); $query = ShortUrl::with(['company','creator']);
   if ($user->hasRole('SuperAdmin')) { $query->whereRaw('1 = 0'); }
   elseif ($user->hasRole('Admin')) { if ($user->company_id) $query->where('company_id', '!=', $user->company_id); else $query->whereRaw('1 = 0'); }
   elseif ($user->hasRole('Member')) { $query->where('created_by', '!=', $user->id); }
   elseif ($user->hasRole('Sales','Manager')) { if ($user->company_id) $query->where('company_id', $user->company_id); else $query->whereRaw('1 = 0'); }
   else { $query->whereRaw('1 = 0'); }
   return view('urls.index', ['urls'=>$query->latest()->paginate(20)]);
 }
 public function create(Request $request) { abort_unless($request->user()->hasRole('Sales','Manager'), 403); return view('urls.create'); }
 public function store(Request $request) { abort_unless($request->user()->hasRole('Sales','Manager') && $request->user()->company_id, 403); $data=$request->validate(['original_url'=>'required|url|max:5000']); do { $code=Str::random(8); } while (ShortUrl::where('code',$code)->exists()); $url=ShortUrl::create(['company_id'=>$request->user()->company_id,'created_by'=>$request->user()->id,'code'=>$code,'original_url'=>$data['original_url']]); return redirect('/urls')->with('status','Short URL created: '.url('/s/'.$url->code)); }
 public function resolve(Request $request, string $code) { abort_unless($request->user(), 401); $url=ShortUrl::where('code',$code)->firstOrFail(); $user=$request->user(); $allowed = $user->hasRole('SuperAdmin') || ($user->hasRole('Admin') && $user->company_id !== $url->company_id) || ($user->hasRole('Member') && $user->id !== $url->created_by) || ($user->hasRole('Sales','Manager') && $user->company_id === $url->company_id); abort_unless($allowed, 403); return redirect()->away($url->original_url); }
}
