# Rimba Auth Java

## Purpose

Java web applications, with Spring Boot/Spring Security as the first supported adapter.

## Target Package

`com.rimba:rimba-auth-java`

## Integration

1. Register the Java application.
2. Add the Maven/Gradle starter.
3. Configure issuer, client ID, secret, callback and scopes.
4. Enable supplied login/callback/logout routes.
5. Validate metadata, signature, state and nonce.
6. Convert approved roles/attributes into Spring authorities.

```text
@EnableRimbaAuthentication
RimbaClaimMapper
RimbaLogoutHandler
```

Deliver: Spring Boot auto-configuration, claim mapper, templates and integration tests.

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
