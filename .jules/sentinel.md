# Sentinel Security Journal

## 2024-06-12 - Systemic IDOR in Teacher Endpoints
**Vulnerability:** IDOR (Insecure Direct Object Reference)
**Learning:** Request parameters `gid` and `uid` were not verified against the target course module context or current user's authorization.
**Prevention:** Validate all ID parameters against course and activity contexts. Ensure `require_login` is called before database lookups on request-parameter IDs.

## 2024-07-15 - Missing Context Verification
**Vulnerability:** Authorization and course context validation bypasses in teacher-facing pages.
**Learning:** `require_login` was called after database queries, opening up possibility of information leakage via error messages or DB state alterations.
**Prevention:** Call `require_login` as early as possible immediately after course/module retrieval.
