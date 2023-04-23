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
        if(!Schema::hasColumn('alarms', 'pending_status')){
            Schema::table('alarms', function(Blueprint $table){
                $table->boolean('pending_status')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('alarms', 'pending_status')){
            Schema::dropColumns('alarms', 'pending_status');
        }
    }
};
