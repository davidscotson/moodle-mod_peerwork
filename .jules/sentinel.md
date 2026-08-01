# Sentinel Security Journal - mod_peerwork

## 2024-06-12 - Systemic IDOR Prevention in mod_peerwork Endpoints
**Vulnerability:** Systemic Insecure Direct Object References (IDOR) were found across details.php, override.php, clearsubmissions.php, export.php, release.php, and unlock_graders.php due to missing validation of parameters like peerworkid, groupid, and gradedbyid against course and activity contexts.
**Learning:** Checking require_login only with cmid is insufficient if the script goes on to fetch and process other entities (such as groups, user submissions, or other peerwork instances) based purely on user-supplied request parameters.
**Prevention:** Always validate that all input entities exist, belong to the correct course/activity context, and that the actor has permission to perform operations on them. Always perform require_login before reading or modifying parameters.

## 2026-07-28 - Authorization and Course Context Bypass in grade.php
**Vulnerability:** Any logged-in user could supply arbitrary course module IDs to `grade.php` without proper course context or capability verification, which allowed them to perform unauthorized redirects.
**Learning:** Even redirection pages or simple router scripts like `grade.php` must explicitly enforce course-level logins and verify user capabilities before handling and processing course module request parameters.
**Prevention:** Fetch the course and course-module records using `get_course_and_cm_from_cmid`, call `require_login($course, true, $cm)`, and require the necessary module capability (e.g., `mod/peerwork:view`) before redirecting or forwarding requests.
