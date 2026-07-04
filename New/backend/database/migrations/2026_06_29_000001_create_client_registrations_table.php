<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('client_registrations')) {
            return;
        }

        Schema::create('client_registrations', function (Blueprint $table): void {
            $table->id();
            $table->string('uid_no')->unique();
            $table->date('received_date')->index();
            $table->string('agency_name');
            $table->string('reporting_address');
            $table->string('mobile_no', 50);
            $table->text('name_of_work');
            $table->text('sample_details');
            $table->decimal('total_payment', 12, 2)->default(0);
            $table->decimal('advance_payment', 12, 2)->default(0);
            $table->decimal('balance_dues', 12, 2)->default(0);
            $table->string('payment_followup')->nullable();
            $table->text('remark')->nullable();
            $table->string('qty')->nullable();
            $table->string('scan_copy')->nullable();
            $table->string('scan_copy_1')->nullable();
            $table->string('scan_copy_2')->nullable();
            $table->string('scan_copy_3')->nullable();
            $table->string('scan_copy_4')->nullable();
            $table->string('report_copy')->nullable();
            $table->string('assign_to')->default('lab');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_registrations');
    }
};