# Rimba Auth PHP

## Purpose

Framework-neutral PHP plus a Laravel adapter. This is the first reference client for IdP validation.

## Target Package

`rimba/auth-php` and `rimba/auth-laravel`

## Integration

1. Register the PHP client.
2. Install the core and optional Laravel adapter.
3. Publish configuration and routes.
4. Generate state, nonce and PKCE values.
5. Exchange code server-side and validate tokens.
6. Load permitted UserInfo and key local identity by immutable `sub`.
7. Create local session and apply local authorization.

```php
RimbaAuth::routes();
Route::middleware('rimba.auth')->group(function (): void {
    // protected routes
});
```

The package must not depend on the IdP's internal Staff model. Deliver middleware, controllers/actions, DTO, Blade login component and tests.

## Shared Protocol Contract

- Authorization Code flow with PKCE S256
- `state` for correlation; `nonce` for OIDC
- HTTPS, exact redirect URIs, secure cookies and least-privilege scopes
- Web apps create a local session after callback
- SPAs are public clients and never contain a client secret
- Services use Client Credentials and receive no human claims

### Configuration
```text
RIMBA_AUTHORITY=
RIMBA_CLIENT_ID=
RIMBA_CLIENT_SECRET=
RIMBA_REDIRECT_URI=
RIMBA_SCOPES="openid profile email roles attributes"
RIMBA_POST_LOGOUT_REDIRECT_URI=
```

### Endpoints
```text
/.well-known/openid-configuration
/oauth/authorize
/oauth/token
/oauth/userinfo
/oauth/jwks
/oauth/revoke
/logout
```

> Laravel Passport supplies OAuth2. Before advertising Rimba as OIDC, Rimba must implement and test discovery, the `openid` scope, ID tokens, UserInfo, JWKS, issuer, audience, nonce and logout behavior.
