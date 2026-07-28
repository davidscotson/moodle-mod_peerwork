# Sentinel Security Journal

## 2024-06-12 - Systemic IDOR in Teacher-Facing Endpoints
**Vulnerability:** Systemic IDOR was identified in teacher-facing endpoints (details.php, override.php, clearsubmissions.php, export.php, and release.php).
**Learning:** Checking credentials only or failing to validate that a given ID matches the expected course/activity context allowed unauthorized parameter-based database lookups and manipulation.
**Prevention:** Always place `require_login` immediately after course/module retrieval but before any request-parameter-based database lookups.

## 2024-07-15 - Additional IDOR and Course Context Validation
**Vulnerability:** IDOR was found across details.php, override.php, clearsubmissions.php, export.php, release.php, and classes/external/unlock_graders.php.
**Learning:** Course module contexts and activity instances must be explicitly validated against each other.
**Prevention:** Validate all ID parameters (such as groupid, gradedbyid, peerworkid) against the course and activity context. For example, verify group IDs belong to the current course and user IDs belong to that group.
