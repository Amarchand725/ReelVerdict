<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Start a transaction to ensure all operations succeed or fail together
        DB::transaction(function () {

            $roles = [
                //GeneralRoles
                [ 'name' => 'Admin', 'guard_name' => 'user'],
            ];
            
            collect($roles)->each(function ($role) {
                Role::firstOrCreate($role);
            });

            $adminRole = Role::where('name','Admin')->first();

            // Define permissions by module
            $permissions = $this->getPermissions('user');

            // Create permissions if they don't exist
            foreach ($permissions as $permission) {
                $underscoreSeparated = explode('-', $permission);
                $label = str_replace('_', ' ', $underscoreSeparated[0]);
                $exists = DB::table('permissions')
                    ->where('label', $label)
                    ->where('name', $permission)
                    ->exists();

                if ($exists) {
                    continue;
                }
                Permission::create([
                    'label' => $label,
                    'name' => $permission,
                    'guard_name' => 'user',
                ]);
            }

            $adminRole->syncPermissions(Permission::where('guard_name', 'user')->get());

            // Roles
            // $leadRole = Role::where('name', 'Lead')->first();
            // $agentRole = Role::where('name', 'Agent')->first();

            // // Permissions to assign to Lead & Agent
            // $limitedPermissions = [
            //     'lead-list', 
            //     'lead-view', 
            //     'lead-status',
            //     'lead-note',
            //     'notification-list', 
            //     'notification-view', 
            //     'meeting-list', 
            //     'meeting-view', 
            //     'meeting-status',
            //     'meeting-create',
            //     'meeting-edit',
            //     'meeting-reschedule',
            // ];

            // // Assign only these permissions to Lead & Agent
            // $leadRole->syncPermissions($limitedPermissions);
            // $agentRole->syncPermissions($limitedPermissions);

            $this->command->info('admin role created and permissions assigned successfully!');
        });
    }

    /**
     * Get all permissions for the system
     *
     * @return array
     */
    private function getPermissions($guard = 'user'): array
    {
        $generalPermissions = [
            // Role management
            'role-list',
            'role-create',
            'role-view',
            'role-edit',
            'role-delete',
            'role-restore',

            // User management
            'user-list',
            'user-create',
            'user-view',
            'user-edit',
            'user-delete',
            'user-restore',
            'user-status',
            'user-direct_permission',
            // 'user-impersonate',
            // 'user-change_password',

            // Permission management
            'permission-list',
            'permission-view',
            'permission-delete',

            // Status management
            'status-list',
            'status-create',
            'status-view',
            'status-edit',
            'status-delete',
            'status-restore',

            // Country management
            'country-list',
            'country-view',
            'country-delete',
            'country-restore',

            // State management
            'state-list',
            'state-view',
            'state-delete',
            'state-restore',

            // Attachment management
            'attachment-list',
            'attachment-create',
            'attachment-view',
            'attachment-edit',
            'attachment-delete',
            'attachment-restore',
            'attachment-download',

            //Faq management
            'faq-list',
            'faq-create',
            'faq-view',
            'faq-edit',
            'faq-delete',
            'faq-restore',
            'faq-status',

            //Notification management
            'notification-list',
            'notification-view',
            'notification-delete',

            //activity log management
            'activity_log-list',
            'activity_log-view',
            'activity_log-delete',
            'activity_log-restore',
        ];

        return $generalPermissions;
    }
}
