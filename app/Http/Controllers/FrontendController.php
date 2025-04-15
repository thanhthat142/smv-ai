<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Tag;
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
        $posts = Post::where('category_id', $cate->id)->where('status', Helpers::STATUS_ACTIVE)->limit(Helpers::LIMIT_POST_IN_LIST)->get();

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

    public function tag($value)
    {

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        $tag = Tag::findBySlug($value);

        // get current post for search
        $posts = Post::where('status', Helpers::STATUS_ACTIVE)
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('id', $tag->id);
            })
            ->limit(100)
            ->get();

        return view('frontend.tag', compact('tag', 'posts'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // get current post for search
        $posts = Post::where('status', Helpers::STATUS_ACTIVE)
            ->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('content', 'LIKE', '%' . $keyword . '%')
            ->limit(100)
            ->get();

        return view('frontend.search', compact('keyword', 'posts'));
    }

    public function setLang($value)
    {
        Session::put('locale', $value);
        return redirect('/');
    }

    public function ajaxLoadMoreCate(Request $request): \Illuminate\Http\JsonResponse
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        $start = $request->input('start');
        $categoryId = $request->input('cate');

        if (!$start || !$categoryId) {
            return response()->json(['error' => 1]);
        }

        $posts = Post::where('category_id', $categoryId)->where('status', Helpers::STATUS_ACTIVE)->skip($start)->limit(Helpers::LIMIT_POST_IN_LIST)->get();

        $html = view('frontend.partials.category_post', compact('posts'))->render();
        return $html? response()->json(['html' => $html]) : response()->json(['error' => 1]);
    }
}
