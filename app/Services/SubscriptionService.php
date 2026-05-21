<?php

namespace App\Services;

use App\Models\User;

class SubscriptionService
{
    /**
     * Check subscription status and apply unit-based renewal logic.
     * Returns: 'active' | 'extended' | 'expired' | 'none'
     */
    public function checkAndUpdateSubscription(User $user): string
    {
        $sub = $user->activeSubscription();

        if (!$sub) return 'none';

        // Not expired — nothing to do
        if (!$sub->isExpired()) return 'active';

        // Expired with NEGATIVE units → extend free until units go positive
        if ($sub->shouldExtend()) {
            $sub->update(['status_note' => 'extended']);
            return 'extended';
        }

        // Expired with ZERO or POSITIVE units → terminate access
        if ($sub->shouldTerminate()) {
            $sub->update(['is_active' => false, 'status_note' => 'expired']);
            return 'expired';
        }

        return 'active';
    }
}
