# Rimba Auth Java

Use a server-side OAuth authorization-code client, such as the application's existing Spring Security OAuth client support. Add Login with Rimba, callback and logout routes. Exchange the code server-side, call `/api/idp/user`, map roles and permissions to application authorities, then create the local session.

## Rimba endpoints

```text
GET /api/idp/user
GET /api/idp/users
GET /api/idp/roles
GET /api/idp/permissions
```

The application redirects the browser to Passport `/oauth/authorize`, handles the callback, exchanges the authorization code at `/oauth/token`, then calls `/api/idp/user`. Directory endpoints require both the matching scope and the corresponding client API flag.
