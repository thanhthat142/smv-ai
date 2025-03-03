<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        return view('frontend.index');
    }

    public function contact()
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        return view('frontend.contact');
    }

    public function cate($slug)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        $cate = Category::findBySlug($slug);

        if (!$cate) {
            return redirect(route('frontend.index'));
        }
        // get current post for category
        $posts = Post::where('category_id', $cate->id)->where('status', Helpers::STATUS_ACTIVE)->limit(10)->get();

        if ($posts->count() == 1) {
            $post = $posts->first();
            return view('frontend.post', compact('post'));
        }
        return view('frontend.category', compact('cate', 'posts'));
    }

    public function post($slug) {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        $post = Post::findBySlug($slug);
        if (!$post) {
            return redirect(route('frontend.index'));
        }
        return view('frontend.post', compact('post'));
    }

    public function saveContact()
    {
        try {
            Contact::create(request()->all());
        } catch (\Exception $e) {

        }
        return redirect(route('frontend.index'));
    }

    public function setLang($value)
    {
        Session::put('locale', $value);
        return redirect('/');
    }
}
