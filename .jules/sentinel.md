## 2025-05-14 - IDOR Vulnerabilities in Parameter Handling
**Vulnerability:** Multiple endpoints were vulnerable to Insecure Direct Object Reference (IDOR) because they accepted IDs (groupid, userid, peerworkid) without verifying they belonged to the current course or activity context.
**Learning:** In Moodle, `require_login($course)` and `require_capability(...)` only ensure the user has access to the course/module, but they do not automatically validate that other parameters in the request are consistent with that context.
**Prevention:** Always validate that user-provided IDs belong to the expected context using `$DB->record_exists` (e.g., verifying a group belongs to the course) or `is_enrolled` (verifying a user is in the course) before processing them.
