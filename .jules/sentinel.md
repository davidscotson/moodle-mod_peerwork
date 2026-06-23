# Sentinel Journal - mod_peerwork

This journal tracks critical security learnings, vulnerability patterns, and reusable security solutions for the `mod_peerwork` Moodle plugin.

## 2026-06-11 - IDOR Prevention in mod_peerwork
**Vulnerability:** Insecure Direct Object Reference (IDOR) in `details.php`.
**Learning:** The application was fetching a group record using a user-provided `groupid` parameter without verifying that the group actually belonged to the authenticated course context. While `require_login($course)` ensures the user has access to the course, it doesn't automatically validate that all other parameters (like `groupid`) are consistent with that course.
**Prevention:** Always validate that any user-provided IDs for related objects (groups, users, other activities) belong to the current course and/or activity context before performing operations or displaying data.
