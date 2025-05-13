<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

require_once base_path('database/seeders/DatabaseSeeder.php');
dump(class_exists('Database\\Seeders\\DatabaseSeeder'));
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
