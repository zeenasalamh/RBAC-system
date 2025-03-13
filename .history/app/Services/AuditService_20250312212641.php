<?PHP

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\AuditLog;

class AuditService
{

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
