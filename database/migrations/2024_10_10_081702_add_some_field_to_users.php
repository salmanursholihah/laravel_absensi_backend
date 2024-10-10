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
        Schema::table('users', function (Blueprint $table) {
            // position
            $table->string('position')->nullable();
            // departement 
            $table->string('department')->nullable();
            // face embedding 
            $table->string('face_embedding')->nullable();
            // image url 
            $table->string('image_url')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('position');
            $table->dropColumn('department');
            $table->dropColumn('face_embedding');
            $table->dropColumn('image_url');
        });
    }
};
