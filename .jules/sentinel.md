## 2025-05-14 - [IDOR in Moodle activity modules]
**Vulnerability:** Several entry point scripts (details.php, override.php, etc.) accepted 'groupid', 'uid', or 'pid' parameters without verifying they belonged to the current course or activity instance.
**Learning:** Checking 'require_login' and 'require_capability' is necessary but not sufficient; parameters must be validated against the context (e.g., verifying a group belongs to the course).
**Prevention:** Always use $DB->get_record with multiple conditions (e.g., 'id' AND 'courseid') to fetch objects based on user-provided IDs.
