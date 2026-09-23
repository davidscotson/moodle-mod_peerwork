## 2024-09-23 - Move Authentication Checks Before Database Lookups and Scope Group Lookups

**Vulnerability:** In `details.php` and `override.php`, database queries using user-controlled parameters (`$groupid`, `$gradedbyid`) were executed before `require_login()` and capability checks, creating an unauthenticated information leakage oracle and IDOR vulnerabilities.

**Learning:** When database lookups or exception-throwing functions execute before `require_login()`, unauthenticated attackers can detect whether entities (e.g., group IDs) exist based on database exception responses before being challenged for credentials. Additionally, omitting `courseid` from group lookups allowed cross-course IDOR access.

**Prevention:** Always place `require_login()` and capability checks immediately after course/module retrieval, and always scope group lookups with `['id' => $groupid, 'courseid' => $course->id]`.
