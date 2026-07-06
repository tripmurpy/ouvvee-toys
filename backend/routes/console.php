<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:ouvvee', function (): void {
    $this->info('Ouvvee Toys Laravel app');
});
