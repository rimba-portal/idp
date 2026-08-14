<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idp_clients', function (Blueprint $table): void {
            $table->id();
            $table->string('passport_client_id', 100)->unique();
            $table->string('code', 100)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('redirect_uris');
            $table->json('allowed_scopes')->nullable();
            $table->boolean('allow_users_api')->default(false);
            $table->boolean('allow_roles_api')->default(false);
            $table->boolean('allow_permissions_api')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idp_clients');
    }
};
