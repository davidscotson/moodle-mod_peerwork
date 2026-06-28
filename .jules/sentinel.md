# Sentinel Journal

## 2024-05-14 - IDOR vulnerabilities in assessment endpoints
**Vulnerability:** IDOR (Insecure Direct Object Reference) vulnerabilities were identified in several endpoints (`details.php`, `override.php`, `export.php`, `release.php`, and `clearsubmissions.php`) where request parameters like `groupid` and `peerworkid` were used to fetch records without validating their consistency with the authenticated course and activity context.
**Learning:** `require_login($course)` and `require_capability` only ensure that the user has access to the course and the necessary permissions, but they do not automatically prevent a user from manipulating parameters to access data belonging to other groups or even other activities in different courses if the code doesn't explicitly check the context of those objects.
**Prevention:** Always validate that any object retrieved via a user-provided ID parameter belongs to the current course and activity context. For example, when fetching a group, include `courseid` in the query: `$DB->get_record('groups', ['id' => $groupid, 'courseid' => $course->id], '*', MUST_EXIST)`.

## 2024-05-14 - Authorization bypass in external functions
**Vulnerability:** The external function `unlock_graders` was missing a check to verify that the `graderid` actually belongs to the course module context.
**Learning:** While `validate_context($context)` and `require_capability` ensure that the *caller* has permission, they don't automatically validate that the *target* object (in this case, a user) is relevant to that context.
**Prevention:** When an external function performs an action on a user within a specific context, always verify the target user's relationship to that context using functions like `is_enrolled($context, $userid)`.
