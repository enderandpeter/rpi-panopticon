<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasColumn('alarms', 'arming_duration')){
            Schema::table('alarms', function (Blueprint $table) {
                $table->integer('arming_duration')->default(5);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('alarms', 'arming_duration')){
            Schema::dropColumns('alarms', 'arming_duration');
        }
    }
};
