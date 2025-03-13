<?PHP
namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;  // Add this line to import Auth facade
use Illuminate\Foundation\Auth\Access\Authorizable;

class AuditService
{
    use Authorizable; // This trait provides the can method

    public function log($action, $entityType, $entityId = null, $beforeState = null, $afterState = null)
    {
        // Use the Auth facade to get the authenticated user
        $user = Auth::user();
        
        // Call the AuditLog model to create a new record
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
