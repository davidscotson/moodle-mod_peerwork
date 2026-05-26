## 2025-05-15 - IDOR in group-based actions
**Vulnerability:** Several scripts (details.php, export.php, override.php, etc.) accepted a `groupid` parameter and used it to fetch data without verifying that the group actually belonged to the current course.
**Learning:** Even after `require_login($course)` and checking capabilities, Moodle does not automatically ensure that other object IDs provided via request parameters are consistent with the context.
**Prevention:** Always validate user-provided IDs against the current context (e.g., `$group->courseid == $course->id`) immediately after fetching the object.

## 2025-05-15 - XSS in filename rendering
**Vulnerability:** Filenames were being rendered directly in HTML within `locallib.php`.
**Learning:** Any user-controlled string, including filenames, must be escaped before being output to HTML.
**Prevention:** Use Moodle's `s()` function to escape filenames in HTML attributes and content.
