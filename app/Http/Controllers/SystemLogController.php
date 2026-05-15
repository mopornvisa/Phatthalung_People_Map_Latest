<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemLog;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->get('keyword', ''));
        $action  = trim((string) $request->get('action', ''));
        $date    = trim((string) $request->get('date', ''));

        $query = SystemLog::query();

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('username', 'like', "%{$keyword}%")
                  ->orWhere('role', 'like', "%{$keyword}%")
                  ->orWhere('agency', 'like', "%{$keyword}%")
                  ->orWhere('action', 'like', "%{$keyword}%")
                  ->orWhere('detail', 'like', "%{$keyword}%")
                  ->orWhere('ip_address', 'like', "%{$keyword}%");
            });
        }

        if ($action !== '') {
            $query->where('action', $action);
        }

        if ($date !== '') {
            $query->whereDate('created_at', $date);
        }

        $actions = SystemLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $logs = $query
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('system_logs.index', compact(
            'logs',
            'keyword',
            'action',
            'date',
            'actions'
        ));
    }
}