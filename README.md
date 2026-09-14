# Inspire PHPStan ruleset

Set of PHPStan rules used by INSPIRE CZ developers.

## v1, v3
Branches `v1` and `v3`  is for Webspire 7 projects (`v3` is for PHPStan 2.*).

## Where is v2?
The v2 branch was originally created for Webspire 8–specific projects. Since Webspire 8 is no longer in active development and the branch has gone unmaintained, it has been deleted.

## Rules

### DisableUnaryNegationOperatorRule
This rules prevents developers from using unary negation operator. Rule error identifier `unaryNegation.nowAllowed`.

```php
❌ if (!$var) ...
```

```php
👍 if (false === $var) ...
```

### PresenterMethodVisibilityRule
Nette validates presenter entry points while it compiles the DI container, but it only sees
presenters listed in the Composer classmap - and that classmap is complete only after an
optimized install. A wrong visibility therefore passes unnoticed on a development machine and
breaks the deployment build instead. This rule reports it where it is written.

Rule error identifiers `presenterMethod.mustBePublic` and `presenterMethod.mustNotBePrivate`.

```php
❌ private function handleImportResult(ImportResult $result): void
```

```php
👍 private function saveImportResult(ImportResult $result): void
```

The rule mirrors `Nette\Bridges\ApplicationDI\ApplicationExtension::checkPresenter()`:
`action*`, `render*` and `handle*` must be public non-static, `createComponent*` must be
non-private non-static. Two deliberate limits: it covers descendants of
`Nette\Application\UI\Presenter` only, because that is all Nette checks at compile time, and it
takes the prefixes literally, so a presenter overriding `formatActionMethod()` and friends is
out of its reach.

Do not put a violation in the baseline. A baselined violation still breaks the deployment.
