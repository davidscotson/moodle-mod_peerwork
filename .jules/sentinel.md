# Sentinel Security Journal

This journal tracks critical security learnings, vulnerability patterns, and prevention strategies specific to this codebase.

## 2026-07-17 - Stored/Reflected XSS in Feedback and File Area URLs
**Vulnerability:** Raw, unescaped submission feedback and filename URLs were output directly inside HTML tables in view.php and locallib.php. If a user submitted feedback containing malicious Javascript or uploaded files with carefully crafted malicious filenames/URLs, these payloads could execute in other users' browsers.
**Learning:** Moodle provides format_text() to securely parse, filter, and format HTML and other content formats using context limits. Direct rendering of raw DB strings bypasses these safety filters. Also, filename and URL outputs in generated links must always be escaped with s() to prevent HTML attribute injection or tag breakouts.
**Prevention:** Always use format_text() with the correct formatting constants and context for user-supplied HTML. Ensure all generated HTML links utilize s() to escape the href attribute and link content.
