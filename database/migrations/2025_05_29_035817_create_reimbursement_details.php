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
        Schema::create('reimbursement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reimbursement_id');
            $table->date('date');
            $table->string('description');
            $table->integer('money');
            $table->timestamps();

            $table->foreign('reimbursement_id')->references('id')->on('reimbursements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement_details');
    }
};
