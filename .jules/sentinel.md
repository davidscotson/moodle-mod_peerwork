## 2024-10-10 - Course Context and Authorization in Entry Point Redirectors

**Vulnerability:** In `grade.php`, only parameterless `require_login()` was invoked before redirecting to `view.php`. The user-supplied `$id` parameter was neither checked against the database nor validated against course or module access constraints, bypassing course access controls and capability checks.

**Learning:** Redirector endpoints such as `grade.php` that link from core interfaces (like the Gradebook) must still validate that the target activity belongs to the expected module and that the authenticated user possesses access to the specific course module and context before performing actions or redirection.

**Prevention:** Always use `get_course_and_cm_from_cmid($id, 'peerwork')`, pass `$course` and `$cm` into `require_login($course, true, $cm)`, and explicitly enforce required capabilities (`require_capability('mod/peerwork:view', $context)`) on all module entry points.
