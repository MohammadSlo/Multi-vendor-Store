<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $request = request();

        // $query = Category::query();

        // $name = $request->query('name');
        // $staus = $request->query('status');

        // if ($name) {
        //     $query->where('name', 'LIKE', "%{$name}%");
        // }
        // if ($staus) {
        //     $query->where('status', '=', $staus);
        // }

        $categories = Category::with('parent')
        // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select([
        //         'categories.*',
        //         'parents.name as parent_name',
        //     ])
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as counter')
            ->withCount(
                [
                    'products' => function ($query) {
                        $query->where('status', '=', 'active');

                    }])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category;

        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->input('name');
        // $request->get('name');
        // $request->post('name');
        // $request->query('name');
        // $request['name'];

        // $request->all();
        // $request->only('id', 'parent_id');
        // $request->except('image');

        $clean_data = $request->validate(Category::rules(), [
            'required' => 'The field (:attribute) is required.',
            'name.unique' => 'This category already exists!',
        ]);

        // request merge to add addiotional data to the request that don't exist in the form
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);

        //PRG

        return Redirect::route('dashboard.categories.index')->with(
            'success', 'Category Created!',
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        try {

            $category = Category::findOrFail($id);
        } catch (Exception $e) {

            return Redirect::route('dashboard.categories.index')->with(
                'warning', 'Record not found!'
            );
        }

        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {

        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');
        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route('dashboard.categories.index')->with(
            'success', 'Category Updated',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }

        //Category::destroy($id); // = Category::where('id', '=', $id)->delete();

        return Redirect::route('dashboard.categories.index')->with(
            'danger', 'Category Deleted!',
        );

    }

    protected function uploadImage(Request $request)
    {

        if (! $request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public',
        ]);

        return $path;
    }

    public function trash()
    {

        $categories = Category::onlyTrashed()->paginate();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with(
            'success', 'Category restored'
        );
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted forever!');
    }
}
