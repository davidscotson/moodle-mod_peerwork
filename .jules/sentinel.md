# Sentinel Journal

## 2024-07-21 - Unauthorized Plugin Settings Management and CSRF in adminmanageplugins.php
**Vulnerability:** Authorization bypass and CSRF vulnerabilities in `adminmanageplugins.php`. Any authenticated user could access plugin management and trigger changes without sufficient capabilities or session key checks.
**Learning:** Checking standard login (`require_login()`) without a specific capability check (`require_capability()`) leaves administrative endpoints unprotected. Furthermore, missing session key validations (`require_sesskey()`) allows state-changing actions via CSRF.
**Prevention:**
1. Secure administrative and management files with robust capability checks (e.g. `moodle/site:config` on `context_system::instance()`).
2. Always validate session keys (`require_sesskey()`) on state-changing parameters and operations.
