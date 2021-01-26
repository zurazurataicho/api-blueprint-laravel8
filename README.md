## WebAPI skelton by Laravel8

### Implementation

- Using both the users and the admins account tables for SPA authentications with session management by the personal_access_tokens table.
- Also using "application" token table for API tokens without session.
- Separate endpoints like POST /login endpoint for users and POST /admin/login endpoint for admins.
- Timed out SPA sessions to be able to specify parameters on config/sanctum.php
- No adding, modifying and deleting any codes with Laravel relative packages, just only touch inside of app, routes, config and database directories.
- You can find differences to compare between a Laravel new project and this repository.
