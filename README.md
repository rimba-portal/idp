# Rimba IdP

A deliberately simple Laravel Passport IdP package for Rimba v1.

## Included

1. Client application redirects to Rimba/Who authentication through Passport authorization-code flow.
2. On success, client exchanges the code, calls `/api/idp/user`, and receives profile, Staff roles and Staff permissions according to granted scopes.
3. Filament admin registration creates a Passport client and pairs with `idp_clients` metadata.
4. Each client may be allowed to call users, roles and permissions directory APIs.
5. Platform integration notes are included for .NET, Java, JavaScript, PHP and Python.

## Data ownership

- Passport owns OAuth clients, codes and tokens.
- `rimba/siapa` owns authentication orchestration.
- `User` remains the authentication identity.
- Linked `Staff` remains the business identity and owns roles/permissions.
- `rimba/idp` owns only client integration metadata and API access flags.

## Installation

```bash
composer require rimba/idp
php artisan vendor:publish --tag=idp-config
php artisan migrate
php artisan passport:keys
php artisan idp:diagnose
```

The host User must support Passport `HasApiTokens`. Register the package's Filament client resource in the host panel or package discovery convention used by the Rimba installation.

## Client scopes

```text
profile
roles
permissions
users.read
roles.read
permissions.read
```

## Important

This v1 is OAuth2 plus UserInfo. It does not claim OpenID Connect compliance and does not implement SLO, SAML, SCIM, federation or device login.

## Admin resource

Register `Rimba\Idp\Http\UI\Admin\Resources\IdpClientResource` in the Rimba Filament panel if the base package does not auto-discover package resources. The registration notification displays Passport command output so the generated client credentials can be copied immediately.
