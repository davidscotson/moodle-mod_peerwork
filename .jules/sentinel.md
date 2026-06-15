# Sentinel Journal

## 2025-05-14 - Multiple IDOR vulnerabilities in request parameters
**Vulnerability:** Multiple endpoints (details.php, override.php, clearsubmissions.php, export.php, release.php, and external functions) were using request parameters like `groupid`, `userid`, and `peerworkid` without verifying they belong to the authenticated course and activity context.
**Learning:** Calling `require_login($course)` or `require_capability(...)` ensures the user has general access to the course or activity, but it doesn't automatically validate that specific IDs provided in the request are consistent with that context. An attacker could potentially access or modify data from other courses or groups by manipulating these IDs.
**Prevention:** Always explicitly validate that all object IDs (groups, users, instances) provided in request parameters belong to the context being accessed. For groups, check `$group->courseid`. For users, use `is_enrolled($context, $userid)`. For activity instances, verify against the `$cm->instance`.
