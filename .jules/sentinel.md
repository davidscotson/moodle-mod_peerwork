# Sentinel Security Journal

## 2024-10-24 - Authorization and Context Validation in Grade Redirection Endpoint
**Vulnerability:** In `grade.php`, only `require_login()` was invoked without passing `$course` or `$cm`, and the redirect was performed with a raw string parameter without verifying module existence, module context, course enrollment, or the `mod/peerwork:view` capability.
**Learning:** Legacy gradebook redirect entrypoints in Moodle plugins often overlook course and activity context authentication checks, relying solely on the target page (`view.php`). However, defense-in-depth requires validating the course module and checking viewer capabilities directly at the entry point before redirection.
**Prevention:** Always use `get_course_and_cm_from_cmid($id, 'peerwork')`, pass `$course, true, $cm` to `require_login()`, verify `require_capability('mod/peerwork:view', $context)`, and construct redirects using `moodle_url`.
