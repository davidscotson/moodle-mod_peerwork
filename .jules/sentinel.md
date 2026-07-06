# Sentinel Journal - mod_peerwork

This journal tracks critical security learnings and patterns discovered in the `mod_peerwork` plugin.

## 2024-05-22 - [XSS in file links]
**Vulnerability:** Unescaped filenames and URLs in `locallib.php` when generating HTML links for submissions and feedback files.
**Learning:** Manual HTML string concatenation in `locallib.php` bypassed Moodle's standard output escaping mechanisms. Filenames were directly embedded in `<a>` tags.
**Prevention:** Always use `s()` for escaping plain text in HTML attributes and content, or ideally use `html_writer::link()` which handles escaping automatically.
