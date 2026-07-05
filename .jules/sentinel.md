## 2026-06-24 - Systemic IDOR Prevention in mod_peerwork
**Vulnerability:** Systemic IDOR vulnerabilities across multiple endpoints (details.php, export.php, clearsubmissions.php, override.php, release.php, and unlock_graders.php) allowed unauthorized access to group and user data across different courses by manipulating `groupid`, `peerworkid`, and `userid` parameters.
**Learning:** `require_login($course)` only verifies that the user is logged into the course; it does not automatically validate that other ID parameters in the request belong to that course context. Early validation of all request parameters against the authenticated course context is essential.
**Prevention:** Always validate that `groupid` and other entity IDs belong to the current course context immediately after `require_login` and before performing any database operations or data processing using those IDs.

## 2026-06-26 - Behat Cross-Version Compatibility for Activity Completion and Gradebook
**Vulnerability:** Not a direct security vulnerability, but CI failures in security-related tests due to fragile UI locators.
**Learning:** Moodle 4.x UI for activity completion and gradebook setup varies across versions. Labels like "Add requirements" are unreliable. Using internal field names (e.g., `completion`) and a save-and-re-navigate pattern is necessary for stable tests. Custom steps for gradebook settings can become undefined across versions; standard action menu patterns are more robust.
**Prevention:** Use internal field names for completion tracking. Implement save and re-navigate when enabling conditional fields. Use standard action menu steps (`I open the action menu in...`, `I choose "Edit settings" in the open action menu`) for gradebook setup interactions.
