# Rimba Auth JavaScript

Register JavaScript as a public PKCE client. Never place a client secret in browser code. Add Login with Rimba and callback pages, retain state and PKCE verifier safely for the redirect, exchange the code, call `/api/idp/user`, and keep authorization decisions aligned with API-side enforcement.

## Rimba endpoints

```text
GET /api/idp/user
GET /api/idp/users
GET /api/idp/roles
GET /api/idp/permissions
```

The application redirects the browser to Passport `/oauth/authorize`, handles the callback, exchanges the authorization code at `/oauth/token`, then calls `/api/idp/user`. Directory endpoints require both the matching scope and the corresponding client API flag.
