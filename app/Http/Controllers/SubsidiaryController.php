<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubsidiaryRequest;
use App\Http\Requests\UpdateSubsidiaryRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubsidiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.subsidiary.index', [
            'subsidiaries' => User::subsidiary()->search($request->query('q'))->render(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.subsidiary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubsidiaryRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt('password');

            User::create($data);

            return redirect()->route('subsidiary.index')->with('notification', ['icon' => 'success', 'title' => 'Anak Perusahaan', 'message' => 'Berhasil menambahkan anak perusahaan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Anak Perusahaan', 'message' => 'Gagal menambahkan anak perusahaan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $subsidiary): View
    {
        return view('pages.subsidiary.edit', [
            'subsidiary' => $subsidiary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubsidiaryRequest $request, User $subsidiary): RedirectResponse
    {
        try {
            $subsidiary->update($request->validated());

            return back()->with('notification', ['icon' => 'success', 'title' => 'Anak Perusahaan', 'message' => 'Berhasil mengubah anak perusahaan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Anak Perusahaan', 'message' => 'Gagal mengubah anak perusahaan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $subsidiary): RedirectResponse
    {
        try {
            $subsidiary->delete();

            return back()->with('notification', ['icon' => 'success', 'title' => 'Anak Perusahaan', 'message' => 'Berhasil menghapus data anak perusahaan!']);
        } catch (Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Anak Perusahaan', 'message' => 'Gagal menghapus data anak perusahaan!']);
        }
    }
}
