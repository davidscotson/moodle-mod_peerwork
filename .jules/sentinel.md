# Sentinel Journal

## 2024-05-20 - Systemic IDOR in Teacher-Facing Endpoints
**Vulnerability:** IDOR vulnerabilities identified across `details.php`, `override.php`, `clearsubmissions.php`, `export.php`, `release.php`, and `classes/external/unlock_graders.php`. Users with teacher-level capabilities in one course could potentially access or modify data in other courses by manipulating `groupid`, `peerworkid`, or `userid` parameters.
**Learning:** `require_login($course)` and `require_capability` are insufficient if they are called after database lookups that use unvalidated request parameters. Furthermore, Moodle's `$DB->get_record` does not automatically enforce course context unless explicitly queried.
**Prevention:** Always call `require_login` as early as possible. Explicitly validate that all user-provided IDs (groups, users, instances) belong to the authenticated course context before performing any data operations.
