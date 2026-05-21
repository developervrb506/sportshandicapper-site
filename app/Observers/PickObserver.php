<?php

namespace App\Observers;

use App\Models\Pick;
use App\Models\UserPackage;

class PickObserver
{
    public function updated(Pick $pick): void
    {
        // Only trigger when result changes from pending to a graded result
        if (!$pick->wasChanged('result')) return;
        if ($pick->getOriginal('result') !== 'pending') return;
        if (!in_array($pick->result, ['win', 'loss', 'push'])) return;
        if ($pick->units_result === null) return;

        // Update units_total for all active subscriptions that started on or before pick's game date
        UserPackage::where('is_active', true)
            ->where('starts_at', '<=', $pick->game_date)
            ->increment('units_total', (float) $pick->units_result);
    }
}
