## 2024-10-09 - Authorization bypass in grade.php
**Vulnerability:** `grade.php` previously called `require_login()` without course/module parameters and without capability checks before redirecting to `view.php`.
**Learning:** Calling `require_login()` without parameters only verifies global authentication, missing course-level access and capability restrictions (`mod/peerwork:view`).
**Prevention:** Always use `get_course_and_cm_from_cmid($id, 'peerwork')`, pass `$course` and `$cm` to `require_login()`, and enforce capability checks (`require_capability`) on module entry points.
