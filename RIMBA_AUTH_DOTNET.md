# Rimba Auth .NET

## Purpose

ASP.NET Core applications in C# or VB.NET. Older .NET Framework and Classic ASP require separate compatibility adapters.

## Target Package

`Rimba.Auth.DotNet`

## Integration

1. Register client and exact callback URI.
2. Add the NuGet package.
3. Configure cookie authentication as local session and OIDC as challenge scheme.
4. Add login, callback and logout endpoints/UI.
5. Validate metadata, issuer, audience, signature, lifetime, state and nonce.
6. Map approved claims into .NET claims and authorization policies.

```csharp
services.AddRimbaAuthentication(configuration);
app.UseAuthentication();
app.UseAuthorization();
```

Deliver: options validation, claim mapper, policy helpers, UI partials and integration tests.

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
