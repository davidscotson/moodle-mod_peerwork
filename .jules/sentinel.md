# Sentinel Security Journal

## 2024-11-06 - Authorization and Course Context Bypass in grade.php
**Vulnerability:** `grade.php` called bare `require_login()` without passing `$course` or `$cm`, and omitted capability checks before redirecting to `view.php?id=$id`. This allowed authenticated users not enrolled in the course (or lacking view capability) to access the endpoint without course-level access control enforcement.
**Learning:** In Moodle activity modules, endpoints receiving a course module ID (`$id`) must obtain the course and course module records via `get_course_and_cm_from_cmid($id, 'peerwork')`, pass them to `require_login($course, true, $cm)`, and explicitly enforce capability checks (e.g. `mod/peerwork:view`).
**Prevention:** Avoid bare `require_login()` in activity module entry points; always establish the course/cm context and verify appropriate module capabilities.
