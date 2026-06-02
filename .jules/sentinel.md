## 2026-06-02 - Output Escaping for XSS Prevention
**Vulnerability:** Persistent XSS in criterion descriptions and feedback filenames.
**Learning:** Criterion descriptions and filenames were rendered directly in HTML without escaping or formatting, allowing for script execution. While Moodle provides `format_text()`, `s()` is a robust alternative for plain text contexts.
**Prevention:** Always use `s()` or `format_text()` when rendering user-provided strings in Moodle plugins.

## 2026-06-02 - IDOR via Missing Course-Group Validation
**Vulnerability:** IDOR in `release.php` allows users with the `grade` capability to release grades for any group ID by providing it as a parameter, as it wasn't validated against the course context.
**Learning:** Checking for user login and capability is insufficient; request parameters like `groupid` must be explicitly verified to belong to the current course.
**Prevention:** Always validate that record-identifying parameters (e.g., `groupid`, `userid`) belong to the expected course/context before performing sensitive operations.
