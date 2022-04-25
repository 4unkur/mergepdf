<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['one', 'two', 'three'] as $name) {
            \App\Models\Certificate::query()
                ->create(['name' => $name])
                ->addMedia(storage_path('sample.pdf'))
                ->preservingOriginal()
                ->toMediaCollection('pdf');
        }
    }
};
