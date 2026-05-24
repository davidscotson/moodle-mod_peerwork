## 2025-05-15 - IDOR in Activity Contexts
**Vulnerability:** Insecure Direct Object Reference (IDOR) via request parameters (groupid, uid, pid).
**Learning:** `require_capability` checks the user's role in the context but doesn't verify that the specific object IDs provided in the request actually belong to that context.
**Prevention:** Always validate that user-provided IDs belong to the current course and activity instance (e.g., check `group->courseid` matches `$course->id`).

## 2025-05-15 - Moodle Core Function Context Blindness
**Vulnerability:** Potential cross-course data leak using `groups_get_members()`.
**Learning:** Core functions like `groups_get_members($groupid)` do not verify that the group belongs to the expected course.
**Prevention:** Explicitly verify the group's `courseid` before calling group membership functions with user-supplied group IDs.
