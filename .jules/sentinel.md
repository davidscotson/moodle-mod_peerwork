# Sentinel Journal

## 2026-06-24 - Systemic IDOR and XSS Remediation
**Vulnerability:** Multiple Insecure Direct Object Reference (IDOR) vulnerabilities and Cross-Site Scripting (XSS) risks. IDOR occurred because request parameters (`groupid`, `userid`, `peerworkid`) were used in database queries without verifying they belonged to the authenticated course context. XSS occurred due to unescaped file URLs, filenames, and rich text fields (criteria descriptions, feedback).

**Learning:** `require_login($course)` only ensures the user has access to the course, but does not implicitly validate that arbitrary IDs passed in the request are valid for that course. Rich text fields in Moodle must be rendered with `format_text()` using the correct context to ensure both security and proper formatting.

**Prevention:** Always validate that any user-provided ID (`groupid`, `userid`, etc.) is consistent with the authenticated course/activity context. Use `format_text()` for all rich text fields and `s()` for plain text or URLs in HTML attributes. Call `require_login()` as early as possible, before using request parameters for database lookups.
