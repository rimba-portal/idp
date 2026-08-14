# Rimba Auth PHP

Use a server-side OAuth authorization-code client. Add Login with Rimba, callback and logout routes. Keep the client secret in environment configuration, exchange the code on the server, call `/api/idp/user`, and key the local identity by the immutable `sub` value.

## Rimba endpoints

```text
GET /api/idp/user
GET /api/idp/users
GET /api/idp/roles
GET /api/idp/permissions
```

The application redirects the browser to Passport `/oauth/authorize`, handles the callback, exchanges the authorization code at `/oauth/token`, then calls `/api/idp/user`. Directory endpoints require both the matching scope and the corresponding client API flag.
