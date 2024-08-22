<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\Category;
use App\Models\Page;
use App\Models\Seo;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        return inertia('Pages/Index', [
            'pages' => Page::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(Request::input('perPage') ?? 10)
                ->withQueryString()
                ->through(fn($page) => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'summery' => $page->summery,
                    'created_at' => $page->created_at,
                    "edit_url" => URL::route('admin.pages.edit', $page->id)

                ]),
            'filters' => Request::only(['search','perPage', 'dateRange']),
            'main_url' => URL::route('admin.pages.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        return inertia('Pages/Create',[
            'main_url' => URL::route('admin.pages.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $page = new Page();

        $page->title = Request::input('title');
        $page->summery = Request::input('summery');
        $page->status = filled(Request::input('status'));
        $page->is_delete= true;
        $page->save();

        if (Request::hasFile('seoImage')){
            $icon = Request::file('seoImage')->store('uploads/all', 'public');
            fileResize(Request::file('seoImage'), $icon, Properties::$productImageWeight, Properties::$productImageHeight);
        }

        Seo::create([
            "seoable_id" => $page->id,
            "seoable_type" => "App\\Models\\Page",
            "title" => Request::input('seoTitle'),
            "key_words" => json_encode(Request::input('seoKeyWords')),
            "description" => Request::input('seoDiscriptions'),
            "icon" => $icon ?? NULL,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(Page $page)
    {
        return inertia('Pages/Edit',[
            'update_url' => URL::route('admin.pages.updatePage', $page->id),
            'page' =>$page->load('seo')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */


    public function updatePage($id){

        $page = Page::with('seo')->findOrFail($id);

        if (Request::hasFile('icon')){
            $icon = Request::file('icon')->store('uploads/all', 'public');
            $page->seo->icon = $icon;
        }

        $page->title = Request::input('title');
        $page->summery = Request::input('summery');
        $page->status = filled(Request::input('status'));
        $page->is_delete= true;
        $page->update();

        $page->seo->title = Request::input('seoTitle');
        $page->seo->key_words = json_encode(Request::input('seoKeyWords'));
        $page->seo->description = Request::input('seoDiscriptions');
        $page->seo->update();
        return redirect()->route('admin.pages.index')->with('message', 'Your page Updated...');

    }


    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return back();
    }



}
