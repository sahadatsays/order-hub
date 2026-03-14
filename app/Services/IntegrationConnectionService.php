<?php

namespace App\Services;

use App\Models\Integration;
use App\Models\IntegrationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class IntegrationConnectionService
{
    /**
     * Test connection to an integration provider.
     *
     * @return array{success: bool, message: string}
     */
    public function testConnection(Integration $integration): array
    {
        $method = 'test' . Str::studly($integration->type) . 'Connection';

        if (method_exists($this, $method)) {
            return $this->{$method}($integration);
        }

        return ['success' => false, 'message' => 'Connection test not available for this integration type.'];
    }

    /**
     * Trigger a manual sync for the integration.
     *
     * @return array{success: bool, message: string}
     */
    public function triggerSync(Integration $integration, int $tenantId): array
    {
        if (!$integration->is_active) {
            return ['success' => false, 'message' => 'Integration is not active.'];
        }

        $integration->update(['sync_status' => 'syncing', 'sync_error' => null]);

        $log = IntegrationLog::create([
            'integration_id' => $integration->id,
            'tenant_id' => $tenantId,
            'action' => 'manual_sync',
            'status' => 'started',
            'started_at' => now(),
        ]);

        try {
            $result = $this->performSync($integration);
            $log->markCompleted($result['processed'] ?? 0, $result['failed'] ?? 0);
            $integration->update([
                'sync_status' => 'idle',
                'last_synced_at' => now(),
            ]);

            return ['success' => true, 'message' => "Sync completed. {$result['processed']} records processed."];
        } catch (\Throwable $e) {
            $log->markFailed($e->getMessage());
            $integration->update([
                'sync_status' => 'error',
                'sync_error' => $e->getMessage(),
            ]);

            return ['success' => false, 'message' => 'Sync failed: ' . $e->getMessage()];
        }
    }

    /**
     * Generate a webhook secret for the integration.
     */
    public function generateWebhookSecret(): string
    {
        return Str::random(40);
    }

    protected function testWoocommerceConnection(Integration $integration): array
    {
        $creds = $integration->credentials ?? [];

        if (empty($creds['store_url']) || empty($creds['consumer_key']) || empty($creds['consumer_secret'])) {
            return ['success' => false, 'message' => 'Missing required credentials: Store URL, Consumer Key, and Consumer Secret are required.'];
        }

        try {
            $response = Http::withBasicAuth($creds['consumer_key'], $creds['consumer_secret'])
                ->timeout(10)
                ->get(rtrim($creds['store_url'], '/') . '/wp-json/wc/v3/system_status');

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Successfully connected to WooCommerce store.'];
            }

            return ['success' => false, 'message' => 'Connection failed: ' . ($response->json('message') ?? 'HTTP ' . $response->status())];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    protected function testPathaoConnection(Integration $integration): array
    {
        $creds = $integration->credentials ?? [];

        $required = ['base_url', 'client_id', 'client_secret', 'username', 'password'];
        $missing = array_filter($required, fn ($field) => empty($creds[$field]));

        if (!empty($missing)) {
            return ['success' => false, 'message' => 'Missing required credentials: ' . implode(', ', $missing)];
        }

        try {
            $response = Http::timeout(10)->post(rtrim($creds['base_url'], '/') . '/aladdin/api/v1/issue-token', [
                'client_id' => $creds['client_id'],
                'client_secret' => $creds['client_secret'],
                'username' => $creds['username'],
                'password' => $creds['password'],
                'grant_type' => 'password',
            ]);

            if ($response->successful() && $response->json('access_token')) {
                return ['success' => true, 'message' => 'Successfully connected to Pathao API.'];
            }

            return ['success' => false, 'message' => 'Connection failed: ' . ($response->json('message') ?? 'HTTP ' . $response->status())];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    protected function performSync(Integration $integration): array
    {
        // This is a placeholder for the actual sync implementation.
        // In production, this would dispatch a queued job per integration type.
        return ['processed' => 0, 'failed' => 0];
    }
}
