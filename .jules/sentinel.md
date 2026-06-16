# Sentinel Journal

## 2026-06-18 - Systemic IDOR Vulnerabilities in Request Parameters
**Vulnerability:** Insecure Direct Object Reference (IDOR) vulnerabilities were identified across multiple endpoints including `details.php`, `export.php`, `clearsubmissions.php`, `override.php`, `release.php`, and `classes/external/unlock_graders.php`.
**Learning:** Authenticating the user to a course via `require_login($course)` ensures the user has access to the course, but it does not automatically validate that subsequent request parameters (like `groupid` or `userid`) belong to that specific course or activity instance. An attacker could potentially manipulate these IDs to access or modify data in other courses where they are not enrolled or don't have permissions.
**Prevention:** For every request parameter that identifies a record (e.g., `groupid`, `userid`, `pid`), implement explicit validation checks to ensure the object belongs to the currently authenticated course and activity context before performing any operations or displaying data.
