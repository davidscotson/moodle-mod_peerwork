# Sentinel Security Journal

## 2024-06-12 - Systemic IDOR Remediation
**Vulnerability:** Systemic IDOR vulnerability in multiple teacher-facing endpoints (`details.php`, `override.php`, `clearsubmissions.php`, `export.php`, `release.php`, and `classes/external/unlock_graders.php`) where the context was not properly validated or users could pass arbitrary IDs.
**Learning:** Checking credentials on the course level without verifying that the targeted records (groups/users/submissions) belong to that course allows IDOR / information disclosure or unauthorized modifications.
**Prevention:** Always validate parameters (`groupid`, `userid`, `peerworkid`) against the retrieved course context before performing queries or updates. Call `require_login` as early as possible.
