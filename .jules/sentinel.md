## 2026-06-15 - Systemic IDOR via Missing Context Validation

**Vulnerability:** Systemic Insecure Direct Object Reference (IDOR) vulnerabilities across multiple endpoints (`details.php`, `export.php`, `clearsubmissions.php`, `release.php`, `override.php`, and `unlock_graders.php`).

**Learning:** Relying solely on `require_login($course)` and `require_capability(...)` is insufficient in Moodle plugins when scripts accept database IDs (like `groupid`, `userid`, or `peerworkid`) as parameters. These IDs must be explicitly validated against the authenticated context (the course or activity instance) to prevent cross-activity or cross-course data access and manipulation.

**Prevention:** Always use the authenticated context to bound database lookups for user-provided IDs. For example, use `$DB->get_record('groups', ['id' => $groupid, 'courseid' => $course->id], '*', MUST_EXIST)` instead of just fetching by `id`. For user IDs, use `is_enrolled($context, $userid)` or `groups_is_member($groupid, $userid)`. When validating a provided activity ID against a course module, use explicit equality checks rather than multiple keys in a query array to avoid PHP key-overwriting bugs.
