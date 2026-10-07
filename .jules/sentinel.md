## 2024-07-15 - Parameter Validation and IDOR Prevention in Override Form
**Vulnerability:** In `override.php`, request parameters `pid` (`$peerworkid`), `gid` (`$groupid`), and `uid` (`$gradedbyid`) were used directly without verifying that `pid` matches the course module's instance ID, `gid` belongs to the current course, and `uid` is a member of that group.
**Learning:** Checking module-level capability alone (`require_capability('mod/peerwork:grade', $context)`) does not ensure that all user-supplied IDs in query/form parameters belong to the context being accessed.
**Prevention:** Always explicitly validate activity instance IDs against `$cm->instance`, check group ownership against `$course->id` using `$DB->record_exists()`, and verify target user membership in the group.
