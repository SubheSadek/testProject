<?php

namespace App\Listeners;

use App\Events\ImportExel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ImportExelListen
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ImportExel $event)
    {
        sleep(10);
        \Log::info('ImportExelListen:');
    }
}
