## 2026-02-12 - Moodle IDOR Prevention Pattern
**Vulnerability:** Insecure Direct Object Reference (IDOR) via `groupid` and `userid` parameters.
**Learning:** `require_login($course, true, $cm)` and `require_capability('mod/peerwork:grade', $context)` ensure the current user has the right permissions in the current course/module, but they do NOT automatically validate that arbitrary IDs passed in the request (like `groupid`) actually belong to that course context.
**Prevention:** Always explicitly cross-validate object IDs against the verified course context (e.g., `$DB->record_exists('groups', ['id' => $groupid, 'courseid' => $course->id])`) and check target user enrollment (`is_enrolled($context, $userid)`).
