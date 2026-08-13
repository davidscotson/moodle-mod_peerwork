# Sentinel Journal

## 2024-07-15 - Systemic IDOR Remediation
**Vulnerability:** Systemic IDOR across teacher-facing endpoints (details.php, override.php, clearsubmissions.php, export.php, release.php, and classes/external/unlock_graders.php) due to missing validation of group or user context against activity/course context.
**Learning:** Checking credentials or using `require_login` is not sufficient if the endpoint allows arbitrary IDs (like group ID or user ID) without checking if those IDs belong to the current course/activity context.
**Prevention:** Always validate all ID parameters against the course and activity contexts. Ensure `require_login` is placed immediately after course/module retrieval and before request-parameter-based database lookups to prevent unauthenticated information leakage.
