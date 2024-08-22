<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function index(){
        return inertia('User/Index', [
            'users' => User::query()
                ->where('type', Properties::$customer)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(Request::input('perPage') ?? 10)
                ->withQueryString()
                ->through(fn($user) => [
                    'user' => $user
                ]),
            'filters' => Request::only(['search','perPage', 'dateRange']),
            'main_url' => URL::route('admin.user.index')
        ]);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->customer()->delete();
//        $user->addresses()->delete();
        $user->orders()->delete();
//        return $user->checkouts;
//        $user->checkouts()->delete();
        $user->delete();
        return back();
    }

}
