<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.category.index', [
            'categories' => Category::search($request->query('q'))->render(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            Category::create($request->validated());

            return redirect()->route('category.index')->with('notification', ['icon' => 'success', 'title' => 'Kategori Unit', 'message' => 'Berhasil menambahkan kategori unit!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Kategori Unit', 'message' => 'Gagal menambahkan kategori unit!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('pages.category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $category->update($request->validated());

            return back()->with('notification', ['icon' => 'success', 'title' => 'Kategori Unit', 'message' => 'Berhasil mengubah kategori unit!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Kategori Unit', 'message' => 'Gagal mengubah kategori unit!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();

            return back()->with('notification', ['icon' => 'success', 'title' => 'Kategori Unit', 'message' => 'Berhasil menghapus data kategori unit!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Kategori Unit', 'message' => 'Gagal menghapus data kategori unit!']);
        }
    }
}
