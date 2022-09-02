<?php

use App\Models\Account;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignUuid('photo_id')->nullable();
            $table->string('name');
            $table->string('display')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            // $table->enum('type', array_column(Account\Type::cases(), 'value'))->nullable();
            // $table->enum('gender', array_column(Account\Gender::cases(), 'value'))->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('photo_id')->references('id')->on('files_uploaded')->nullOnDelete();
        });

        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            // $table->enum('type', array_column(Account\MetaType::cases(), 'value'))->nullable();
            $table->string('key');
            $table->string('cast')->nullable();
            $table->json('payload')->nullable();
        });

        Schema::create('account_meta', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('metadata_id');

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('metadata_id')->references('id')->on('metadata')->nullOnDelete();
        });

        Schema::create('account_relation', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('related_id');
            $table->foreignId('relation_id');
            $table->text('notes')->nullable();

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('related_id')->references('id')->on('metadata')->nullOnDelete();
            $table->foreign('relation_id')->references('id')->on('metadata')->nullOnDelete();
        });

        Schema::create('account_setting', function (Blueprint $table) {
            $table->foreignId('account_id');
            $table->foreignId('setting_id');
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('setting_id')->references('id')->on('metadata')->nullOnDelete();
        });

        Schema::create('account_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('field_id');
            $table->json('payload')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('field_id')->references('id')->on('metadata')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_contacts');
        Schema::dropIfExists('account_setting');
        Schema::dropIfExists('account_relation');
        Schema::dropIfExists('account_meta');
        Schema::dropIfExists('metadata');
        Schema::dropIfExists('accounts');
    }
};
