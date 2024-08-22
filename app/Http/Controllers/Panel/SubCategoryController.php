<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        return inertia('SubCategory/Index', [
            'categories' => SubCategory::query()
                ->with('category')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($developer) use($search){
                            $developer->where('title', 'like', "%{$search}%");
                        });
                })
                ->latest()
                ->paginate($request->input('perPage') ?? 10)
                ->withQueryString()
                ->through(fn($category) => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'category' => $category->category,
                    'slug' => $category->slug,
                    'summery' => $category->summery,
                    'featured' => $category->featured,
                    'icon' => $category->icon,
                    'banner' =>$category->banner,
                    'childrens_count' => $category->childrens_count,
                    'top' => $category->top,
                    'type' => $category->type,
                    'created_at' => $category->created_at->format(config('app.date_format')),
                ]),
            'filters' => $request->only(['search','perPage', 'dateRange']),
            'parent_categories' => Category::get(),
            'main_url' => URL::route('admin.sub-category.index')
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'icon' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon')->store('uploads/all', 'public');
            $data['icon'] = $icon;
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner')->store('uploads/all', 'public');
            $data['banner'] = $banner;
        }

        $data['order_level'] = 0;
        $data['type'] = 'physical';
        $data['category_id'] = $request->input('parent_id');

        SubCategory::create($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param SubCategory $category
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return SubCategory::with('category')->findOrFail($id);
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
    public function update(Request $request, $id)
    {
        $category = SubCategory::findOrFail($id);

        $category->title = $request->input('title');
        $category->category_id = $request->input('parent_id');

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon')->store('uploads/all', 'public');
            $category->icon = $icon;
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner')->store('uploads/all', 'public');
            $category->banner = $banner;
        }

        $category->save();

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        $category->delete();
        return back();
    }
}
