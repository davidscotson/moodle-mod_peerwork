## 2025-05-14 - IDOR Vulnerabilities in mod_peerwork

**Vulnerability:** Multiple Insecure Direct Object Reference (IDOR) vulnerabilities were found across `details.php`, `override.php`, `clearsubmissions.php`, `export.php`, `release.php`, and `classes/external/unlock_graders.php`. These scripts accepted `groupid`, `userid` (as `uid`), or `graderid` parameters without verifying that they belonged to the course and activity instance context.

**Learning:** `require_login($course, true, $cm)` and `require_capability(...)` ensure that the current user has access to the course and activity, but they do NOT automatically validate that other object IDs passed in the request (like a group ID) actually belong to that course. An authorized teacher in one course could potentially access or modify data in another course by changing these IDs.

**Prevention:** Always validate that any object IDs provided in request parameters (e.g., `groupid`, `userid`) are consistent with the validated course and activity context. For groups, check `$group->courseid == $course->id`. For users, use `is_enrolled($context, $userid)`.
