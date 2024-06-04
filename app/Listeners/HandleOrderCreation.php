<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleOrderCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $event->orderIngredients->each(function($ingredient){
            $notified = $ingredient->notified;
            switch ($ingredient->minimum_stock_unit) {
                case 'percentage':
                    $reachedLimitAndNotNotified = ($ingredient->stock/$ingredient->maximum_stock) * 100 <= $ingredient->minimum_stock && !$notified;
                break;

                case 'fixed':
                    $reachedLimitAndNotNotified = $ingredient->stock <= $ingredient->maximum_stock && !$notified;
                break;
            }
            if ($reachedLimitAndNotNotified) {
                // send email
                $ingredient->notified = true;
                $ingredient->save();
            }
        });

        // could implement shouldBeQueued method to determine if the event should be queued
    }
}
