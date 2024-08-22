<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {

//        return Category::getAll();

        return inertia('ChildCategory/Index', [
            'categories' => ChildCategory::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(Request::input('perPage') ?? 10)
                ->withQueryString()
                ->through(fn($category) => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'slug' => $category->slug,
                    'summery' => $category->summery,
                    'featured' => $category->featured,
                    'icon' => $category->icon,
                    'banner' =>$category->banner,
                    'childrens_count' => $category->childrens_count,
                    'top' => $category->top,
                    'type' => $category->type,
                    'category' => $category->category,
                    'sub_cateogry' => $category->subCategory,
                    'created_at' => $category->created_at->format(config('app.date_format')),
                ]),
            'filters' => Request::only(['search','perPage', 'dateRange']),
            'parent_categories' => Category::with('subcategories')
                ->whereHas('subcategories')
                ->get(),
            'sub_categories' => SubCategory::all(),
            'main_url' => URL::route('admin.child-category.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {

        $data = Request::validate([
            'title' => 'required',
            'parent_id' => 'required',
            'sub_cat_id' => 'required',
            'order_level' => 'nullable',
            'type' => 'nullable'
        ]);

        if (Request::hasFile('icon')){
            $icon = Request::file('icon')->store('uploads/all', 'public');
            fileResize(Request::file('icon'), $icon, 60, 60);
            $data['icon'] = $icon;
        }

        if (Request::hasFile('banner')){
            $banner = Request::file('banner')->store('uploads/all', 'public');
            $data['banner'] = $banner;
        }

        $data['order_level'] = 0;
        $data['type'] = 'physical';
        $data['category_id'] = Request::input('parent_id');
        $data['sub_category_id'] = Request::input('sub_cat_id');
        ChildCategory::create($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return Category
     */
    public function show($id)
    {
        $category = ChildCategory::with(['category', 'subCategory', 'category.subCategories'])->findOrfail($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {

        $category = ChildCategory::findOrFail($id);


        $data = Request::validate([
            'title' => 'required',
            'parent_id' => 'required',
            'sub_cat_id' => 'required',
            'order_level' => 'nullable',
            'type' => 'nullable'
        ]);

        if (Request::hasFile('icon')){
            $icon = Request::file('icon')->store('uploads/all', 'public');
            fileResize(Request::file('icon'), $icon, 60, 60);
            $data['icon'] = $icon;
        }

        if (Request::hasFile('banner')){
            $banner = Request::file('banner')->store('uploads/all', 'public');
            $data['banner'] = $banner;
        }

        $data['order_level'] = 0;
        $data['type'] = 'physical';
        $data['category_id'] = Request::input('parent_id');
        $data['sub_category_id'] = Request::input('sub_cat_id');
        $category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = ChildCategory::findOrFail($id);
        $category->delete();
        return back();
    }
}
