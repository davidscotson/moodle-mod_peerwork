## 2024-05-20 - Systemic IDOR in Teacher-Facing Endpoints
**Vulnerability:** IDOR vulnerabilities were identified in `details.php` and `override.php` where `groupid`, `peerworkid`, and `userid` parameters were used in database lookups without verifying they belonged to the authenticated course context.
**Learning:** Teacher-level authorization (`require_capability('mod/peerwork:grade', $context)`) is not sufficient if the specific object IDs provided in the request are not validated against the course context.
**Prevention:** Always call `require_login` as early as possible and explicitly validate that all request parameters (IDs) belong to the course/module context before any database operations.
