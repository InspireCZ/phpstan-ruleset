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
