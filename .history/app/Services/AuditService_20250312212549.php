<?PHP

namespace App\Http\Middleware;

use Closure;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{

/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Logs an audit event to the audit log table.
     * 
     * @param string $action The action that was performed. e.g. 'created', 'updated', 'deleted'
     * @param string $entityType The type of entity that was operated on. e.g. 'App\Models\User', 'App\Models\Role'
     * @param int $entityId The ID of the entity that was operated on. Can be null if no entity was operated on.
     * @param array $beforeState The state of the entity before it was operated on. Can be null if the entity was created.
     * @param array $afterState The state of the entity after it was operated on. Can be null if the entity was deleted.
     * @return \App\Models\AuditLog The created audit log entry.
     */
/******  1c11d585-9ea7-400d-93b9-d48514168a70  *******/
    public function log($action, $entityType, $entityId = null, $beforeState = null, $afterState = null)
    {
        $user = auth()->User();
        
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
