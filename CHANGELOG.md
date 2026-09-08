# Changelog

## 0.2.2

- Let the installed example use the host's loaded Composer autoloader or an explicit autoload path.
  Keep the package checkout fallback and reject missing or unreadable explicit paths.
- Execute the original example from the fresh no-dev Composer ZIP installation in both host
  bootstrap modes, with missing-path refusal checks. Runtime APIs and dependency pins are unchanged.

## 0.2.1

- Select Access Context 0.1.2 so every consumer receives its malformed UTF-8 identity refusal.
- Keep dependency-readiness coordinates synchronized with the exact production requirements.
  Reject stale, missing, duplicate or mismatched evidence entries in the package gate.
- Preserve package API ownership and require independent release verification before consumer adoption.

## 0.2.0

- Correct DST fall-back scheduling, odd retry caps and overflow-safe cron field expansion.
- Add explicit package-owned retry, jitter and handler registry factories with Laminas service resolution tests.
- Pin published Contribution 0.1.1 and Access Context 0.1.1; complete capability, API/member documentation and archive gates.

## 0.1.0

- Extract portable schedules, job state, retry and queue policies, and host-facing ports.
- Preserve package-owned behavior, architecture, API and clean archive consumer checks.
- Use published Canonical JSON 0.1.1, Contribution 0.1.0 and Access Context 0.1.0.
- Publish the recorded version after the human rebase merge passes the shared package gate.
