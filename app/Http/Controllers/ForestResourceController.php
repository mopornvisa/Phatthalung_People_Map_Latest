<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForestResource;
use App\Imports\ForestResourceImport;
use Maatwebsite\Excel\Facades\Excel;

class ForestResourceController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->get('keyword', ''));

        $query = ForestResource::query();

        if ($keyword !== '') {
            $query->where('forest_name', 'like', '%' . $keyword . '%');
        }

        $rows = (clone $query)
            ->orderByDesc('forest_area')
            ->paginate(10)
            ->withQueryString();

        $allRows = (clone $query)
            ->orderByDesc('forest_area')
            ->get();

        $totalForestCount = (clone $query)->sum('forest_count');
        $totalForestArea  = (clone $query)->sum('forest_area');
        $totalForestTypes = (clone $query)->count();

        $avgForestArea = $totalForestTypes > 0
            ? $totalForestArea / $totalForestTypes
            : 0;

        $chartLabels = $allRows->pluck('forest_name')->values();
        $chartCounts = $allRows->pluck('forest_count')->values();
        $chartAreas  = $allRows->pluck('forest_area')->values();

        $topForests = $allRows->take(5);

        return view('forest_resources.index', compact(
            'rows',
            'keyword',
            'totalForestCount',
            'totalForestArea',
            'totalForestTypes',
            'avgForestArea',
            'chartLabels',
            'chartCounts',
            'chartAreas',
            'topForests'
        ));
    }

   public function manage(Request $request)
    {
        $keyword = trim((string) $request->get('keyword', ''));

        $query = ForestResource::query();

        if ($keyword !== '') {
            $query->where('forest_name', 'like', '%' . $keyword . '%');
        }

        $rows = (clone $query)
            ->orderByDesc('forest_area')
            ->paginate(20)
            ->withQueryString();

        $totalForestCount = (clone $query)->sum('forest_count');
        $totalForestArea  = (clone $query)->sum('forest_area');

        return view('forest_resources.manage', compact(
            'rows',
            'keyword',
            'totalForestCount',
            'totalForestArea'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'forest_name'  => 'required|string|max:255',
            'forest_count' => 'required|numeric|min:0',
            'forest_area'  => 'required|numeric|min:0',
        ]);

        ForestResource::create([
            'forest_name'  => $request->forest_name,
            'forest_count' => $request->forest_count,
            'forest_area'  => $request->forest_area,
        ]);

        return redirect()
            ->route('forest.resources.manage')
            ->with('success', 'บันทึกข้อมูลป่าไม้สำเร็จ');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        ForestResource::truncate();

        Excel::import(
            new ForestResourceImport,
            $request->file('excel_file')
        );

        return redirect()
            ->route('forest.resources.manage')
            ->with('success', 'นำเข้าข้อมูลสำเร็จ');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'forest_name'  => 'required|string|max:255',
            'forest_count' => 'required|numeric|min:0',
            'forest_area'  => 'required|numeric|min:0',
        ]);

        $row = ForestResource::findOrFail($id);

        $row->update([
            'forest_name'  => $request->forest_name,
            'forest_count' => $request->forest_count,
            'forest_area'  => $request->forest_area,
        ]);

        return redirect()
            ->route('forest.resources.manage')
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        ForestResource::findOrFail($id)->delete();

        return redirect()
            ->route('forest.resources.manage')
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = collect(explode(',', $request->ids))
            ->filter()
            ->map(fn($id) => (int) $id)
            ->values();

        ForestResource::whereIn('id', $ids)->delete();

        return redirect()
            ->route('forest.resources.manage')
            ->with('success', 'ลบรายการที่เลือกสำเร็จ');
    }
}