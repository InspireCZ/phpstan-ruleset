# Changelog: inspire/phpstan-ruleset
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [3.2.0] - 2026-09-14
### Added
- `PresenterMethodVisibilityRule` reporting `action*`, `render*`, `handle*` and `createComponent*` presenter methods whose visibility Nette rejects while compiling the DI container

## [3.1.2] - 2026-08-17
### Fixed
- do not report the `phpDoc.parseError` ignore as unmatched in packages without `*Entity.php`

## [3.1.1] - 2025-12-24
### Changed
- set identifier for `DisableUnaryNegationOperatorRule` to `unaryNegation.notAllowed`

## [3.1.0] - 2025-12-24
### Added
- separate config file for Admin (`phpstan-admin.neon`)
- file `phpstan-base.neon` with settings common for `phpstan.neon` and `phpstan-admin.neon`

## [3.0.2] - 2025-09-08
### Changed
- bump staabm/phpstan-todo-by version to ^0.3

## [3.0.0] - 2025-04-06
### Changed
- release version for PHPStan v2

## [1.2.0] - 2022-09-14
### Changed
- updated PHPStan to 1.0
