<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $majors = Major::query()
            ->when($q, function ($query) use ($q) {
                $query->where('code', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('majors.index', compact('majors', 'q'));
    }

    public function create()
    {
        return view('majors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:majors,code'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            Major::create([
                'code' => strtoupper(trim($data['code'])),
                'name' => trim($data['name']),
            ]);
        });

        return redirect()
            ->route('majors.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Major $major)
    {
        return view('majors.edit', compact('major'));
    }

    public function update(Request $request, Major $major)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:majors,code,' . $major->id],
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($data, $major) {
            $major->update([
                'code' => strtoupper(trim($data['code'])),
                'name' => trim($data['name']),
            ]);
        });

        return redirect()
            ->route('majors.index')
            ->with('success', 'Jurusan berhasil diupdate.');
    }

    public function destroy(Major $major)
    {
        DB::transaction(function () use ($major) {
            $major->delete();
        });

        return back()->with('success', 'Jurusan berhasil dihapus.');
    }
}
