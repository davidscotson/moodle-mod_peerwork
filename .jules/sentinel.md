## 2026-06-02 - Output Escaping for XSS Prevention
**Vulnerability:** Persistent XSS in criterion descriptions and feedback filenames.
**Learning:** Criterion descriptions and filenames were rendered directly in HTML without escaping or formatting, allowing for script execution. While Moodle provides `format_text()`, `s()` is a robust alternative for plain text contexts.
**Prevention:** Always use `s()` or `format_text()` when rendering user-provided strings in Moodle plugins.
