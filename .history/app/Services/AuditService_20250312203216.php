<?PHP 
class AuditService
{
    public function log($action, $entityType, $entityId = null, $beforeState = null, $afterState = null)
    {
        $user = auth()->user();
        
        return AuditLog::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'before_state' => $beforeState,
            'after_state' => $afterState,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}