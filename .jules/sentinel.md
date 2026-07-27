# Sentinel Journal

## 2024-07-15 - Systemic IDOR Remediation
**Vulnerability:** Systemic IDOR in details.php, override.php, clearsubmissions.php, export.php, release.php, and classes/external/unlock_graders.php.
**Learning:** These endpoints accepted ID parameters (like groupid, peerworkid, gradedbyid) but did not validate them against the current course module/activity context. An attacker could bypass course bounds by specifying valid IDs belonging to other courses.
**Prevention:**
1. Call `require_login` as early as possible, ideally immediately after course/module retrieval, and prior to any database queries using request parameters.
2. Validate user-provided parameters (such as `groupid` and `peerworkid`) against the active course context. Ensure that the specified `peerworkid` matches the current CM instance (`$peerworkid == $cm->instance`) and that the specified `groupid` belongs to the authenticated course context.
