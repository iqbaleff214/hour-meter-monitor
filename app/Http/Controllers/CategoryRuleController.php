<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRuleRequest;
use App\Http\Requests\UpdateCategoryRuleRequest;
use App\Models\Category;
use App\Models\CategoryRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CategoryRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category): View
    {
        return view('pages.category-rule.index', [
            'category' => $category,
            'rules' => $category->rules()->search($request->query('q'))->render(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Category $category): View
    {
        return view('pages.category-rule.create', [
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRuleRequest $request, Category $category): RedirectResponse
    {
        try {
            $input = $request->validated();
            $input['content'] = [];

            $contents = $request->input('content');
            if ($contents) {
                for ($i=0; $i < count($contents['part_number']); $i++) {
                    $input['content'][] = [
                        'part_number' => $contents['part_number'][$i],
                        'part_name' => $contents['part_name'][$i],
                        'quantity' => $contents['quantity'][$i],
                        'unit' => $contents['unit'][$i],
                        'note' => $contents['note'][$i],
                    ];
                }
            }

            CategoryRule::create($input);

            return redirect()->route('category.rule.index', $category)->with('notification', ['icon' => 'success', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Berhasil menambahkan aturan servis!']);
        } catch (Throwable $th) {
            Log::error($this::class . ': ' . $th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Gagal menambahkan aturan servis!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category, CategoryRule $rule): View
    {
        return view('pages.category-rule.edit', [
            'category' => $category,
            'rule' => $rule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRuleRequest $request, Category $category, CategoryRule $rule): RedirectResponse
    {
        try {
            $input = $request->validated();
            $input['content'] = [];

            $contents = $request->input('content');
            if ($contents) {
                for ($i=0; $i < count($contents['part_number']); $i++) {
                    $input['content'][] = [
                        'part_number' => $contents['part_number'][$i],
                        'part_name' => $contents['part_name'][$i],
                        'quantity' => $contents['quantity'][$i],
                        'unit' => $contents['unit'][$i],
                        'note' => $contents['note'][$i],
                    ];
                }
            }

            $rule->update($input);

            return back()->with('notification', ['icon' => 'success', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Berhasil mengubah aturan servis!']);
        } catch (Throwable $th) {
            Log::error($this::class . ': ' . $th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Gagal mengubah aturan servis!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, CategoryRule $rule): RedirectResponse
    {
        try {
            $rule->delete();

            return back()->with('notification', ['icon' => 'success', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Berhasil menghapus data aturan servis!']);
        } catch (Throwable $th) {
            Log::error($this::class . ': ' . $th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Aturan Servis Kategori Unit', 'message' => 'Gagal menghapus data aturan servis!']);
        }
    }

    public function rule(Request $request, Category $category): JsonResponse
    {
        $hourMeter = (int) ($request->query('hm') ?? 0);
        $rules = $category->rules()->orderBy('min_value', 'asc')->get();

        foreach ($rules as $rule) {
            if ($hourMeter >= (int) $rule->min_value && $hourMeter <= (int) $rule->max_value) {
                return response()->json($rule);
            }
        }

        return response()->json([
            'service_plan' => '',
            'content' => [],
        ]);
    }
}
