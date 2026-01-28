<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tea;
use Artisan;

class TeaController extends Controller
{
    // 1. Show all teas (scraped + manual)
    public function index()
    {
        $teas = Tea::latest()->get();
        return view('admin.teas.index', compact('teas'));
    }

    // Show only scraped teas
    public function scraped(Request $request)
    {
        $flavorFilter = $request->get('flavor', 'all');
        
        $query = Tea::where('source', 'scraped');
        
        if ($flavorFilter !== 'all') {
            $query->where('flavor', $flavorFilter);
        }
        
        $teas = $query->latest()->get();
        
        // Get available flavors for filter dropdown
        $availableFlavors = Tea::where('source', 'scraped')
            ->whereNotNull('flavor')
            ->where('flavor', '!=', '')
            ->distinct()
            ->pluck('flavor')
            ->sort()
            ->values();
        
        return view('admin.teas.scraped', compact('teas', 'availableFlavors', 'flavorFilter'));
    }

    // Show only manual teas
    public function manual()
    {
        $teas = Tea::where('source', 'manual')->latest()->get();
        return view('admin.teas.manual', compact('teas'));
    }

    public function create()
    {
        return view('admin.teas.create');
    }

    public function edit($id)
    {
        $tea = Tea::findOrFail($id);
        return view('admin.teas.edit', compact('tea'));
    }

    // 2. Manual insert (admin add tea)
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'flavor' => ['nullable', 'string', 'max:255'],
            'caffeine_level' => ['nullable', 'string', 'max:255'],
            'health_benefit' => ['nullable', 'string', 'max:255'],
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('teas', 'public');

        Tea::create([
            'name' => $request->name,
            'flavor' => $request->flavor,
            'caffeine_level' => $request->caffeine_level,
            'health_benefit' => $request->health_benefit,
            'image' => $path,
            'source' => 'manual'
        ]);

        return redirect()->route('admin.teas.index')->with('success', 'Tea created successfully!');
    }

    public function update(Request $request, $id)
    {
        $tea = Tea::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'flavor' => ['nullable', 'string', 'max:255'],
            'caffeine_level' => ['nullable', 'string', 'max:255'],
            'health_benefit' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
        ]);

        $tea->name = $request->name;
        $tea->flavor = $request->flavor;
        $tea->caffeine_level = $request->caffeine_level;
        $tea->health_benefit = $request->health_benefit;

        if ($request->hasFile('image')) {
            $tea->image = $request->file('image')->store('teas', 'public');
        }

        $tea->save();

        return redirect()->route('admin.teas.index')->with('success', 'Tea updated successfully!');
    }

    // 3. Trigger scraper from dashboard
    public function scrape()
    {
        Artisan::call('scrape:tea-data');
        return redirect()->route('admin.teas.index')->with('success', 'Scraping completed!');
    }

    // 4. Delete tea
    public function destroy($id)
    {
        Tea::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Tea deleted!');
    }
}
