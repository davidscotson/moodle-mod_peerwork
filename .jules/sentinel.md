# Sentinel Security Journal

This journal tracks critical security learnings, vulnerability patterns, and prevention strategies specific to this codebase.

## 2026-08-12 - Course-Level Authorization and login bypass in mod_peerwork grade.php
**Vulnerability:** The endpoint `grade.php` was calling `require_login()` without specifying any course or course-module context. This permitted unauthenticated or course-enrolment-lacking users to bypass authorization checks at the plugin's entry point, which redirected to `view.php` and relied on down-the-line checks, introducing a potential information leakage or authorization bypass vector.
**Learning:** In Moodle, calling `require_login()` parameterless only performs system-level authentication check. For specific activities and course modules, course-level context must be explicitly passed.
**Prevention:** Always retrieve course and cm context using helper functions like `get_course_and_cm_from_cmid` and validate using `require_login($course, true, $cm)` followed by specific capability checks using `require_capability('mod/peerwork:view', $context)` at the start of any plugin endpoint.
