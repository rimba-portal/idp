# Rimba IdP

## Purpose

`rimba/idp` is the OAuth2/OIDC provider for Rimba and ATM applications. It issues protocol tokens but does not own authentication or business authorization.

## Ownership and Dependencies

- `rimba/siapa`: authentication orchestration
- `rimba/ldap`: AD/LDAP authentication
- `rimba/orang`: Staff business identity
- `rimba/boleh`: roles, permissions and policy
- `rimba/sifat`: dynamic ABAC attributes
- `rimba/citra`: branding
- `rimba/jejak`: audit trail
- `laravel/passport`: OAuth2 server foundation

## Source of Truth

`User` is the authentication identity. `Staff` is the business identity. Claims are resolved through `user -> staff -> roles/attributes`. Passport owns OAuth clients, codes and tokens.

## Critical Boundary

Passport is an OAuth2 server, not a complete OIDC provider by itself. Rimba must add discovery metadata, signed ID tokens, standard claims, UserInfo, JWKS and OIDC validation.

## Supported Clients

1. Confidential web: Authorization Code + PKCE + client authentication
2. Public SPA/native: Authorization Code + PKCE, no secret
3. Service: Client Credentials
4. Device clients: Device Authorization Grant only when required

Password and implicit grants are excluded from the target design.

## Scopes
```text
openid profile email staff roles permissions attributes offline_access
```

## Canonical Claim Shape
```json
{
  "iss": "https://iam.example.internal",
  "sub": "stable-subject",
  "aud": "client-id",
  "name": "Display Name",
  "email": "user@example.internal",
  "preferred_username": "login",
  "staff_no": "000000",
  "roles": ["department.it"],
  "permissions": ["application.read"],
  "attributes": {"department": "IT"}
}
```
Only client-approved claims are released. Sensitive HR attributes are denied by default.

## Login Flow

1. Client creates state, nonce, verifier and S256 challenge.
2. Client redirects to `/oauth/authorize`.
3. `rimba/siapa` authenticates through LDAP or local source.
4. IdP validates client, redirect URI and scopes.
5. Consent is recorded or skipped only by trusted-client policy.
6. One-time code returns to the client.
7. Client exchanges code and verifier.
8. Client validates tokens and creates its local session.

## Admin Experience

- Register public/confidential clients
- Maintain exact redirect/logout URIs
- Assign allowed scopes and claim release policy
- Rotate secrets without revealing stored values
- Revoke clients and tokens
- Review consent and security events

## Audit Events
```text
ClientRegistered ClientSecretRotated AuthorizationApproved AuthorizationDenied
TokenIssued TokenRefreshed TokenRevoked ProtocolValidationFailed
```

## Recommended Compact Structure
```text
rimba/idp
├── IDP.md
├── config/idp.php
├── database/migrations/create_idp_extension_tables.php
├── src/IdpServiceProvider.php
├── src/Actions/IdpActions.php
├── src/Services/IdpServices.php
├── src/Events/IdpEvents.php
├── src/Listeners/IdpListeners.php
├── src/Http/API/Controllers/IdpControllers.php
├── src/Http/API/Resources/IdpResources.php
├── src/Http/UI/Admin/Resources/IdpResources.php
├── resources/views/oauth/authorize.blade.php
├── routes/web.php
├── routes/api.php
└── tests/Feature/IdpProtocolTest.php
```
Do not duplicate Passport OAuth tables unless the installed Passport version expressly requires published migrations. Add only Rimba-owned extensions such as claim policies, trusted-client rules and consent evidence.

## First Build Slice

1. Clean provider/configuration
2. One confidential PHP test client
3. Authorization Code + PKCE end to end
4. OAuth-compatible UserInfo
5. OIDC discovery, JWKS and ID tokens
6. Claim resolver through Staff
7. Client scope/claim policy
8. Logout, revocation and protocol tests

## Acceptance Criteria

- Reject unregistered redirect URIs
- Reject reused codes and invalid PKCE verifiers
- Validate ID-token signature, issuer, audience, expiry and nonce
- Block disabled users and revoked clients
- Return only approved scopes and claims
- Produce the same canonical subject for LDAP and local authentication
- Keep human claims out of client-credentials tokens

## Required Corrections to `quick_idp.md`

- Align schema with the installed Passport version instead of hand-maintaining OAuth tables
- Fix rollback order and device-code cleanup
- Remove CRUD creation/editing for authorization codes and tokens
- Never display or edit stored client secrets as plain text
- Resolve roles from `user->staff->roles`
- Remove dependency on the host `App\Http\Controllers\Controller`
- Normalize all namespaces under `Rimba\Idp`
- Remove timed automatic consent submission
- Configure the key path instead of hard-coding it
- Register scopes once

## Final Recommendation

Finalize this design first. Then generate the IdP package and use `rimba-auth-php` as the reference client before implementing the other platform adapters.
