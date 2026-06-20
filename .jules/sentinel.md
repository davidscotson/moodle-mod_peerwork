# Sentinel Journal

## 2025-05-14 - Systemic IDOR Vulnerabilities in Group Activity Endpoints
**Vulnerability:** Multiple Insecure Direct Object Reference (IDOR) vulnerabilities were identified across `details.php`, `override.php`, `clearsubmissions.php`, `export.php`, `release.php`, and the external function `unlock_graders`. Request parameters like `groupid`, `userid`, and `peerworkid` were used to perform actions or display data without verifying that these objects belonged to the authenticated course and activity context.

**Learning:** `require_login($course)` ensures the user has access to the course, but it does not automatically validate that subsequent parameters provided in the request (like a `groupid`) actually belong to that course. An attacker could potentially access or manipulate data from groups in other courses by simply changing the `groupid` parameter if it wasn't explicitly checked against `$course->id`.

**Prevention:** Always explicitly validate that all request parameters (IDs for groups, users, etc.) are consistent with the established course and activity module context. Perform these checks immediately after `require_login` and before using the parameters in any database operations or logic. Standardize error reporting with clear, security-focused language strings.
