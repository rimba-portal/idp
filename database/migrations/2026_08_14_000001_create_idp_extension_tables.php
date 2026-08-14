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
            $table->string('system_name');
            $table->string('application_type', 30)->default('confidential_web');
            $table->string('trust_level', 30)->default('standard');
            $table->string('status', 30)->default('active');
            $table->string('owner_team')->nullable();
            $table->string('owner_staff_no')->nullable();
            $table->json('allowed_scopes')->nullable();
            $table->json('redirect_uris')->nullable();
            $table->json('post_logout_redirect_uris')->nullable();
            $table->timestamp('secret_rotated_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'application_type']);
        });

        Schema::create('idp_client_claims', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('idp_client_id')->constrained('idp_clients')->cascadeOnDelete();
            $table->string('claim');
            $table->string('source_path');
            $table->string('scope')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('enabled')->default(true);
            $table->json('transform')->nullable();
            $table->timestamps();
            $table->unique(['idp_client_id', 'claim']);
        });

        Schema::create('idp_consents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('idp_client_id')->constrained('idp_clients')->cascadeOnDelete();
            $table->string('user_id', 100);
            $table->json('scopes');
            $table->timestamp('granted_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'revoked_at']);
        });

        Schema::create('idp_security_events', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('idp_client_id')->nullable()->constrained('idp_clients')->nullOnDelete();
            $table->string('user_id', 100)->nullable();
            $table->string('event_type', 100);
            $table->string('result', 30)->default('success');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->index(['event_type', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idp_security_events');
        Schema::dropIfExists('idp_consents');
        Schema::dropIfExists('idp_client_claims');
        Schema::dropIfExists('idp_clients');
    }
};
