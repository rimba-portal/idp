# Rimba Auth .NET

Use ASP.NET Core cookie authentication plus an OAuth authorization-code client. Add a Login with Rimba action, callback endpoint and logout action. Store client secret only in server configuration. After token exchange call `/api/idp/user`, map returned roles and permissions to local claims, then create the application cookie session.

## Rimba endpoints

```text
GET /api/idp/user
GET /api/idp/users
GET /api/idp/roles
GET /api/idp/permissions
```

The application redirects the browser to Passport `/oauth/authorize`, handles the callback, exchanges the authorization code at `/oauth/token`, then calls `/api/idp/user`. Directory endpoints require both the matching scope and the corresponding client API flag.
