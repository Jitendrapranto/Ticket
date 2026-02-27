<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutStatistic;
use Illuminate\Http\Request;

class AboutStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = AboutStatistic::orderBy('sort_order', 'asc')->get();
        return view('admin.about.statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.about.statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        AboutStatistic::create($request->all());

        return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutStatistic $statistic)
    {
        return view('admin.about.statistics.edit', compact('statistic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutStatistic $statistic)
    {
        $request->validate([
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $statistic->update($request->all());

        return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutStatistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic deleted successfully!');
    }
}
