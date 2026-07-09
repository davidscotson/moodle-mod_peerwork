## 2024-06-07 - Systemic IDOR in Teacher-Facing Endpoints
**Vulnerability:** Insecure Direct Object Reference (IDOR) across multiple scripts (details.php, override.php, etc.) where group and user IDs were not validated against the course context.
**Learning:** Teacher-facing scripts often relied on implicit trust or only checked the course module ID, failing to verify that secondary parameters like 'groupid' or 'uid' actually belonged to the course being accessed.
**Prevention:** Always validate every request-parameter-based ID against the authenticated context (e.g., $DB->record_exists('groups', ['id' => $groupid, 'courseid' => $course->id])) immediately after require_login.
