<?php

declare(strict_types=1);

it('publishes OAuth discovery metadata without claiming complete OIDC', function (): void {
    $this->getJson('/.well-known/openid-configuration')
        ->assertOk()->assertJsonPath('response_types_supported.0', 'code')
        ->assertJsonPath('rimba_oidc_complete', false);
});

it('publishes an RSA JWKS document', function (): void {
    $this->getJson('/idp/jwks')->assertOk()->assertJsonStructure(['keys']);
});

it('requires a bearer token for userinfo', function (): void {
    $this->getJson('/api/idp/userinfo')->assertUnauthorized();
});
