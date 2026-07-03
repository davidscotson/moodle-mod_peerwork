# Sentinel Journal

## 2025-05-15 - Systemic IDOR across multiple endpoints
**Vulnerability:** Multiple PHP endpoints (details.php, override.php, clearsubmissions.php, export.php, release.php) and the `unlock_graders` external function accepted ID parameters (`groupid`, `peerworkid`, `userid`) without verifying their association with the authenticated course or module context.
**Learning:** `require_login($course)` and `require_capability(...)` are insufficient if individual object IDs (like `groupid`) are not validated against the course context after retrieval.
**Prevention:** Always explicitly validate that any object retrieved via a user-provided ID belongs to the current course and/or activity context before performing operations or displaying data.
