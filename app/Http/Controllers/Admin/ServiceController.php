<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:1',
            'image'       => 'nullable|image|max:2048',
            'active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['active'] = $request->has('active') ? true : false;
        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Jasa berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:1',
            'image'       => 'nullable|image|max:2048',
            'active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['active'] = $request->has('active') ? true : false;
        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Jasa berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Jasa berhasil dihapus!');
    }

    public function toggleActive(Service $service)
    {
        $service->update(['active' => !$service->active]);
        return response()->json(['active' => $service->active, 'message' => 'Status jasa diperbarui.']);
    }
}
