# Sentinel's Journal - Critical Learnings

## 2024-10-15 - Missing Contextual Login and Capability Verification in Routing Endpoints
**Vulnerability:** In `grade.php`, the script accepted a course module ID `$id` and only performed a bare `require_login()` without checking the course/activity context or user capabilities before redirecting to `view.php`.
**Learning:** Redirect/routing entry points that interface with Moodle gradebook or activity links must validate the course and course module via `get_course_and_cm_from_cmid`, enforce context-specific login via `require_login($course, true, $cm)`, and verify capabilities (`mod/peerwork:view`) to avoid context bypass or unauthorized redirection.
**Prevention:** Always pass `$course` and `$cm` to `require_login($course, true, $cm)` and enforce relevant module capabilities on all entry points, even when they only perform redirects.
