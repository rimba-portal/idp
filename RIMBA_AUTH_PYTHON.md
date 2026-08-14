# Rimba Auth Python

## Purpose

Python web applications. Batch programs use Client Credentials and do not display a human login page.

## Target Package

`rimba-auth`

## Integration

1. Register web or service client.
2. Install core plus one framework adapter.
3. Configure authority and callback.
4. Add login/callback/logout routes.
5. Store state, nonce and PKCE verifier in a secure server-side session.
6. Validate tokens, create local session and protect routes.

```text
rimba_auth.core
rimba_auth.flask
rimba_auth.fastapi
rimba_auth.django
```

Deliver: neutral verifier, separate framework adapters, claim model and tests.

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
