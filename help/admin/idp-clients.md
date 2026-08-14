# IDP Clients Administration Guide

## Overview

IDP Clients represent applications that authenticate users through Rimba.

Examples:

- Weaver
- ATM Intranet
- MES
- SCOPS
- GWMS
- eCIM
- LMS
- DMS

A registered client can:

- Redirect users to Rimba Login
- Receive an OAuth Authorization Code
- Exchange the code for an Access Token
- Retrieve user profile information
- Retrieve user roles
- Retrieve user permissions
- Optionally access Users, Roles and Permissions APIs

---

# Navigation

```text
Administration
└── IDP Clients
```

Click:

```text
Register Client
```

---

# Field Reference

## Code

Unique application identifier.

Examples:

```text
weaver
atm-intranet
mes
gwms
scops
ecim
```

Guidelines:

- Must be unique
- Use lowercase
- Do not change after applications are integrated

---

## Name

Human readable application name.

Examples:

```text
Weaver
ATM Intranet
MES
```

---

## Description

Optional explanation of the application.

Example:

```text
Manufacturing Workflow System
```

---

## Redirect URIs

After successful authentication, Rimba redirects the user back to one of these URLs.

Example:

```text
https://weaver.company.com/auth/callback
```

Multiple URIs may be configured.

Example:

```text
https://weaver.company.com/auth/callback
https://uat-weaver.company.com/auth/callback
```

Only configured URIs are allowed.

---

## Allowed Scopes

Select the information that the application can request.

### profile

Allows:

```json
{
  "sub": "123",
  "name": "User Name",
  "email": "user@example.com",
  "staff_no": "000123"
}
```

### roles

Allows:

```json
{
  "roles": [
    "department.it",
    "application.weaver.admin"
  ]
}
```

### permissions

Allows:

```json
{
  "permissions": [
    "workflow.create",
    "workflow.approve"
  ]
}
```

### users.read

Allows access to:

```http
GET /api/idp/users
```

### roles.read

Allows access to:

```http
GET /api/idp/roles
```

### permissions.read

Allows access to:

```http
GET /api/idp/permissions
```

---

## Public Client

Enable for:

- React
- Vue
- Angular
- JavaScript SPA
- Mobile Applications

These clients use:

```text
Authorization Code + PKCE
```

No client secret should be embedded in browser code.

---

## Allow Users API

When enabled, the client may call:

```http
GET /api/idp/users
```

Provided that the client also has:

```text
users.read
```

scope assigned.

---

## Allow Roles API

Allows:

```http
GET /api/idp/roles
```

Requires:

```text
roles.read
```

scope.

---

## Allow Permissions API

Allows:

```http
GET /api/idp/permissions
```

Requires:

```text
permissions.read
```

scope.

---

# Registering A Client

1. Open IDP Clients.
2. Click Register Client.
3. Enter Code.
4. Enter Name.
5. Enter Description (optional).
6. Add one or more Redirect URIs.
7. Select Allowed Scopes.
8. Enable Public Client if required.
9. Enable API access flags if required.
10. Submit the form.

Rimba will:

```text
1. Create Passport Client
2. Create IDP Client record
3. Store Redirect URIs
4. Store Allowed Scopes
5. Store API access configuration
```

---

# Registration Result

A success notification will appear.

Example:

```text
Client registered

Client ID: 12
Client Secret: xxxxxxxxxxxxxxxxx
```

Record the Client ID and Client Secret immediately and provide them to the application team.

---

# Information Required By Application Team

Provide:

```text
Client ID
Client Secret
Redirect URI
Allowed Scopes
```

Example:

```text
Client ID: 12
Client Secret: xxxxxxxxxxxxx
Redirect URI: https://weaver.company.com/auth/callback
Scopes: profile, roles, permissions
```

---

# User Information Endpoint

After authentication, applications may call:

```http
GET /api/idp/user
```

Example response:

```json
{
  "sub": "123",
  "name": "Faros Othman",
  "email": "faros@example.com",
  "auth_identifier": "faros",
  "staff_no": "000123",
  "roles": ["department.it"],
  "permissions": ["workflow.create","workflow.approve"]
}
```

---

# Recommended Scope Sets

## Standard Business Application

```text
profile
roles
permissions
```

## Administration Application

```text
profile
roles
permissions
users.read
roles.read
permissions.read
```

Enable:

```text
Allow Users API
Allow Roles API
Allow Permissions API
```
