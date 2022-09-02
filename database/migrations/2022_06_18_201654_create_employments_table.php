<?php

use App\Models\Employment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empl_occupations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
        });

        Schema::create('account_empl_occupation', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('occupation_id');

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('occupation_id')->references('id')->on('empl_occupations')->nullOnDelete();
        });

        Schema::create('empl_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->unsignedInteger('level')->default(0);
        });

        Schema::create('account_empl_hierarchy', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('hierarchy_id');

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('hierarchy_id')->references('id')->on('empl_hierarchies')->nullOnDelete();
        });

        Schema::create('empl_directories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('hierarchy_id');
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('hierarchy_id')->references('id')->on('empl_hierarchies')->nullOnDelete();
            $table->foreign('parent_id')->references('id')->on('empl_directories')->nullOnDelete();
        });

        Schema::create('empl_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            // $table->enum('type', array_column(Employment\StatusType::cases(), 'value'))->nullable();
            $table->text('description')->default(0);
        });

        Schema::create('account_empl_status', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('status_id');

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('status_id')->references('id')->on('empl_statuses')->nullOnDelete();
        });

        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('directory_id');
            $table->foreignId('location_id');
            $table->foreignId('occupation_id');
            $table->foreignId('status_id');
            $table->foreignId('marital_status_id');
            $table->foreignId('tax_status_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('directory_id')->references('id')->on('empl_directories')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('account_contacts')->nullOnDelete();
            $table->foreign('occupation_id')->references('id')->on('empl_occupations')->nullOnDelete();
            $table->foreign('status_id')->references('id')->on('empl_statuses')->nullOnDelete();
            $table->foreign('marital_status_id')->references('id')->on('empl_statuses')->nullOnDelete();
            $table->foreign('tax_status_id')->references('id')->on('empl_statuses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employments');
        Schema::dropIfExists('account_empl_status');
        Schema::dropIfExists('empl_statuses');
        Schema::dropIfExists('empl_directories');
        Schema::dropIfExists('account_empl_hierarchy');
        Schema::dropIfExists('empl_hierarchies');
        Schema::dropIfExists('account_empl_occupation');
        Schema::dropIfExists('empl_occupations');
    }
};
