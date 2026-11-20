# CLAUDE.md — web (Disaster Relief Management)

## Purpose

Fork of the team project `AtaQou/web`: a PHP/MySQL web app for disaster relief with three roles
(administrator, rescuer, citizen). This is a **fork** — treat upstream as the source of truth.

## Fork workflow

```bash
git remote add upstream https://github.com/AtaQou/web.git   # once
git fetch upstream && git merge upstream/main
```

- Work on feature branches (`feature/...`, `fix/...`); open PRs to upstream for shared changes.
- Changes that only matter for this fork (README, CLAUDE.md) can go straight to `main`.

## Structure

- `web/includes/` — `db_connect.php` (PDO, port 3310) and role-access guards
- `web/pages/admin|rescuer|citizen/` — one folder per role
- `db_init.txt` — schema; `docker_compose.yml` — MySQL container
- Duplicate copies of `docker_compose.yml`, `db_init.txt`, `dockerinstructions.txt` exist at the root
  and in `web/` — the root copies are the ones documented in the README.

## Conventions

- PHP 8, PDO with prepared statements only; escape output with `htmlspecialchars`.
- Every page under `pages/<role>/` must include the matching `includes/<role>_access.php`.
- Comments may be in Greek or English; new code in English.

## Known issues

- Passwords: always `password_hash()` on write, `password_verify()` on login (login.php also upgrades
  legacy plain-text passwords — keep that until all old accounts have logged in once).
- `.gitignore` is the Visual Studio template — not relevant to PHP; replace with a PHP/Docker one.

## Do not

- Do not commit `db/data/` (MySQL volume) or real credentials.
- Do not rewrite history or force-push — upstream and teammates share it.
