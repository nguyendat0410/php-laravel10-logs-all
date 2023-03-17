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
        Schema::create("logs_call", function (Blueprint $table) {
            $table->id()->unsigned()->autoIncrement();
            $table->uuid()->comment('UUID example')->nullable();
            $table->string('call_id')->unique()->comment('Id của tổng đài');
            $table->string('phone')->comment('Số điện thoại');
            $table->string('extension')->comment('Số máy lẻ');
            $table->dateTime('time')->comment('Thời gian thực hiện cuộc gọi');
            $table->integer('duration')->comment('Số giây nghe máy');
            $table->string('status')-> comment('Trạng thái cuộc gọi');
            $table->string('type')->comment('Cuộc gọi vào (in), Cuộc gọi ra (out)');
            $table->string('recording_file')->comment('Đường dẫn file ghi âm');
            $table->text('json_attributes')->nullable()->comment('Trường JSON');
            $table->timestamps();

            $table->index('time');
            $table->index('call_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_call');
    }
};
