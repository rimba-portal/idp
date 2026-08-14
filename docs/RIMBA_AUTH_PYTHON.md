# Rimba Auth Python

Use the OAuth client supported by Flask, FastAPI or Django. Add Login with Rimba, callback and logout routes. Store state in the server session, exchange the code server-side, call `/api/idp/user`, map roles and permissions, then establish the local application session. Batch programs should use a separate machine-to-machine client instead of a human login page.

## Rimba endpoints

```text
GET /api/idp/user
GET /api/idp/users
GET /api/idp/roles
GET /api/idp/permissions
```

The application redirects the browser to Passport `/oauth/authorize`, handles the callback, exchanges the authorization code at `/oauth/token`, then calls `/api/idp/user`. Directory endpoints require both the matching scope and the corresponding client API flag.
