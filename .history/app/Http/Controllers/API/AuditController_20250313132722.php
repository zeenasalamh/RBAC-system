<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    
    public function index(Request $request)
    {
        $query = AuditLog::with('user');
        if ($request->has('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        
        if ($request->has('entity_id')) {
            $query->where('entity_id', $request->entity_id);
        }
        
        if ($request->has('action')) {
            $query->where('action', $request->action);
        }
        
        return response()->json($query->latest()->paginate(15));
    }
    
    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog->load('user'));
    }
}