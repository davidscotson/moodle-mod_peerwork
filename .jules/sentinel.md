## 2026-06-24 - Systemic IDOR Remediation across endpoints

**Vulnerability:** IDOR vulnerabilities were identified across multiple endpoints (`details.php`, `override.php`, `clearsubmissions.php`, `export.php`, `release.php`, and `classes/external/unlock_graders.php`). User-provided parameters like `groupid`, `userid` (as `gradedbyid` or `graderid`), and `peerworkid` (instance ID) were used in database queries or logical operations without verifying their consistency with the authenticated course and activity context.

**Learning:** `require_login($course)` ensures that a user is logged in and has access to a specific course, but it does not automatically prevent them from manipulating request parameters to access or modify data belonging to other courses or activities. Parameters must be explicitly validated against the authorized context (e.g., checking `group->courseid` against `$course->id` or using `is_enrolled($context, $userid)`).

**Prevention:** Always validate that all user-provided IDs (groups, users, instances) belong to the context established by `require_login`. Perform these validations immediately after authentication and before any sensitive operations or further database lookups.
