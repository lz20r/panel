<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogEntry;

class LogEntryController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogEntry::with('user')
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($logs);
    }

    public function store(Request $request)
    {
        /** @id */
        $request->validate([
            'type' => 'required|string',
            'message' => 'required|string',
            'metadata' => 'nullable|array',
        ]);
        $log = LogEntry::create([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'message' => $request->message,
            'metadata' => $request->metadata,
            'url' => $request->url(),
        ]);

        

        return response()->json($log, 201);
    }
}
