## 2025-05-14 - [IDOR in override.php]
**Vulnerability:** Insecure Direct Object Reference (IDOR) and lack of cross-parameter validation in `override.php`.
**Learning:** Even if `require_login` and `require_capability` are called, Moodle does not automatically ensure that all user-provided IDs (like group IDs or peer IDs) belong to the current course or activity context.
**Prevention:** Always validate that provided IDs (pid, gid, uid) are consistent with the established course module and course context. Use `MUST_EXIST` with `$DB->get_record` including the `courseid` in the criteria, and verify group membership for user IDs passed in group contexts.
