<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use App\InfoUser;
Use App\Category;
Use App\Page;
Use App\Tag;
Use App\Photo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$user = User::find(1);
        //$category = Category::find(1);
        //$page = Page::find(1);
        //dd($user->info->bio); 
        //dd($user->categories);
        //dd($user->photos); 
        //dd($user->tags); 
        //dd($user->pages); 
        //dd($category->pages); 
        //dd($page->photos); 
        
        return view('home');
    }
}
