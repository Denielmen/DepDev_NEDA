<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReadOnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and is an admin with read-only restrictions
        if (auth()->check() && $this->isReadOnlyAdmin(auth()->user())) {
            // Block non-GET requests (POST, PUT, PATCH, DELETE)
            if (!$request->isMethod('GET')) {
                return redirect()->back()->with('error', 'You have read-only access. Modifications are not allowed.');
            }

            // Block specific actions that might modify data even with GET requests
            $restrictedActions = [
                'delete',
                'destroy',
                'edit',
                'update',
                'create',
                'store',
                'export', // Block exports as they might be resource intensive
            ];

            $currentAction = $request->route() ? $request->route()->getActionName() : '';
            
            foreach ($restrictedActions as $action) {
                if (str_contains(strtolower($currentAction), $action)) {
                    return redirect()->back()->with('error', 'You have read-only access. This action is not allowed.');
                }
            }
        }

        return $next($request);
    }

    /**
     * Check if the user is a read-only admin
     */
    private function isReadOnlyAdmin($user): bool
    {
        // Only Admin_Jennifer and Admin_Evelyn are read-only
        // Casey, Maria, Larhisse, and Cherilyn have full admin privileges
        $readOnlyAdmins = ['Admin_Jennifer', 'Admin_Evelyn'];
        return in_array($user->user_id ?? '', $readOnlyAdmins);
    }
}
