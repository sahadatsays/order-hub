<?php

namespace App\Services\Notification;

use App\Models\User;

class RecipientResolver
{
    /**
     * Resolve recipients for a given set of targets and context.
     *
     * Returns an array of normalized recipient records:
     * [['type' => 'user', 'id' => 1, 'name' => 'X', 'email' => 'x@example.com', 'phone' => '123'], ...]
     */
    public function resolve(array $targets, array $context): array
    {
        $recipients = [];

        foreach ($targets as $target) {
            $resolved = match ($target) {
                'customer'       => $this->resolveCustomer($context),
                'assigned_staff' => $this->resolveAssignedStaff($context),
                'admins'         => $this->resolveAdmins($context),
                'owner'          => $this->resolveOwner($context),
                default          => [],
            };

            foreach ($resolved as $r) {
                $key = ($r['type'] ?? '') . ':' . ($r['id'] ?? $r['email'] ?? $r['phone'] ?? '');
                $recipients[$key] = $r;
            }
        }

        return array_values($recipients);
    }

    private function resolveCustomer(array $context): array
    {
        $name = $context['customer_name'] ?? null;
        $email = $context['customer_email'] ?? null;
        $phone = $context['customer_phone'] ?? null;

        if (!$email && !$phone) {
            return [];
        }

        return [[
            'type'  => 'customer',
            'id'    => $context['customer_id'] ?? null,
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ]];
    }

    private function resolveAssignedStaff(array $context): array
    {
        $staffId = $context['assigned_to'] ?? $context['created_by'] ?? null;
        if (!$staffId) {
            return [];
        }

        $user = User::find($staffId);
        if (!$user) {
            return [];
        }

        return [[
            'type'  => 'user',
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'phone' => null,
        ]];
    }

    private function resolveAdmins(array $context): array
    {
        $tenantId = $context['tenant_id'] ?? null;
        if (!$tenantId) {
            return [];
        }

        return User::where('tenant_id', $tenantId)
            ->whereIn('role', ['owner', 'admin'])
            ->where('is_active', true)
            ->get()
            ->map(fn (User $u) => [
                'type'  => 'user',
                'id'    => $u->id,
                'name'  => $u->name,
                'email' => $u->email,
                'phone' => null,
            ])
            ->toArray();
    }

    private function resolveOwner(array $context): array
    {
        $tenantId = $context['tenant_id'] ?? null;
        if (!$tenantId) {
            return [];
        }

        $owner = User::where('tenant_id', $tenantId)
            ->where('role', 'owner')
            ->where('is_active', true)
            ->first();

        if (!$owner) {
            return [];
        }

        return [[
            'type'  => 'user',
            'id'    => $owner->id,
            'name'  => $owner->name,
            'email' => $owner->email,
            'phone' => null,
        ]];
    }
}
