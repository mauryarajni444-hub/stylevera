<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class AdminCategoryController extends Controller {
    public function index() {
        return view('admin.categories.index', ['categories' => Category::withCount('products')->orderBy('sort_order')->paginate(20)]);
    }
    public function create() {
        return view('admin.categories.create');
    }
    public function store(Request $r) {
        $r->validate(['name_en' => 'required']);
        Category::create($r->except('_token') + ['slug' => Str::slug($r->name_en) . '-' . Str::random(4)]);
        return redirect()->route('admin.categories.index')->with('success', 'Category created!');
    }
    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $r, Category $category) {
        $r->validate(['name_en' => 'required']);
        $data = $r->except('_token', '_method');
        $data['is_active']   = $r->boolean('is_active');
        $data['is_featured'] = $r->boolean('is_featured');
        $category->update($data);
        return back()->with('success', 'Category updated!');
    }
    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Deleted.');
    }
}
