<?php

namespace App\Http\Controllers;

use App\Enum\Condition;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.equipment.index', [
            'equipmentAll' => Equipment::owner($request->user())->search($request->query('q'))->render(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('pages.equipment.create', [
            'categories' => Category::all(),
            'subsidiaries' => User::subsidiary()->get(),
            'brands' => Equipment::groupBy('brand')->select('brand')->pluck('brand')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        try {
            Equipment::create($request->validated());

            return redirect()->route('equipment.index')->with('notification', ['icon' => 'success', 'title' => 'Unit Peralatan', 'message' => 'Berhasil menambahkan unit peralatan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Unit Peralatan', 'message' => 'Gagal menambahkan unit peralatan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment): View
    {
        return view('pages.equipment.edit', [
            'categories' => Category::all(),
            'subsidiaries' => User::subsidiary()->get(),
            'equipment' => $equipment,
            'brands' => Equipment::groupBy('brand')->select('brand')->pluck('brand')->toArray(),
            'conditions' => Condition::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        try {
            $equipment->update($request->validated());

            return back()->with('notification', ['icon' => 'success', 'title' => 'Unit Peralatan', 'message' => 'Berhasil mengubah unit peralatan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Unit Peralatan', 'message' => 'Gagal mengubah unit peralatan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        try {
            $equipment->delete();

            return back()->with('notification', ['icon' => 'success', 'title' => 'Unit Peralatan', 'message' => 'Berhasil menghapus data unit peralatan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Unit Peralatan', 'message' => 'Gagal menghapus data unit peralatan!']);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $result = Equipment::with(['subsidiary'])->owner($request->user())->search($request->query('q'))->get();

        return response()->json($result);
    }
}
