## 2024-05-15 - [IDOR in Moodle activity parameters]
**Vulnerability:** Insecure Direct Object Reference (IDOR) through group and user IDs in activity-specific scripts.
**Learning:** `require_login()` and `require_capability()` ensure the user is authenticated and has the general permission (e.g., `mod/peerwork:grade`) but do not automatically validate that provided parameters (like `groupid` or `userid`) belong to the current course context.
**Prevention:** Always validate user-provided IDs against the course context using `$DB->record_exists('groups', ['id' => $groupid, 'courseid' => $course->id])` or `is_enrolled($context, $userid)` before processing sensitive actions or displaying data.
