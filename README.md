# Inspire PHPStan ruleset

Set of PHPStan rules used by INSPIRE CZ developers.

## v1
Branch `v1` is for Webspire 7 projects.

## master
Branch `master` is for Webspire 8 projects.

## Rules

### DisableUnaryNegationOperatorRule
This rules prevents developers from using unary negation operator.

```php
❌ if (!$var) ...
```

```php
👍 if (false === $var) ...
```
