# Rimba Auth JavaScript

## Purpose

React, Vue, Angular and framework-neutral browser clients. Browser clients cannot protect a secret.

## Target Package

`@rimba/auth`

## Integration

1. Register a public PKCE client.
2. Install the TypeScript-first SDK.
3. Configure authority, client ID, callback and scopes.
4. Mount provider/plugin and call `login()`.
5. Process callback, validate state/nonce and remove tokens from the URL.
6. Prefer in-memory tokens or a BFF for higher-risk applications.
7. Protect routes and call APIs with bearer tokens.

```javascript
const auth = createRimbaAuth(config);
await auth.login();
await auth.handleCallback();
await auth.logout();
```

Deliver: core SDK, React hook/provider, Vue plugin, Angular service/guard and PKCE tests.

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
