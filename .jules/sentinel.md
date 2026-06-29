# Sentinel Journal

## 2026-06-24 - Systemic IDOR and XSS Regressions
**Vulnerability:** Systemic Insecure Direct Object Reference (IDOR) vulnerabilities were found across multiple endpoints (`details.php`, `export.php`, `clearsubmissions.php`, `release.php`, `override.php`, and `unlock_graders.php`) where user-provided IDs (`groupid`, `userid`, `peerworkid`) were not validated against the authenticated course context. Additionally, Cross-Site Scripting (XSS) vulnerabilities were found in `locallib.php` (unescaped file URLs and names) and `renderer.php` (unescaped criteria descriptions).
**Learning:** `require_login($course)` only ensures the user has access to the course; it does not automatically validate that other parameters in the request actually belong to that course. Historical fixes for these issues were missing or incomplete in the current codebase.
**Prevention:** Always explicitly validate that all user-provided IDs belong to the authenticated context. Use `s()` for escaping URLs and plain text in HTML attributes, and `format_text()` for rich text content with proper context.
