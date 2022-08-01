# Inspire PHPStan ruleset

Set of PHPStan rules used by INSPIRE CZ developers.

## DisableUnaryNegationOperatorRule
This rules prevents developers from using unary negation operator.

```php
❌ if (!$var) ...
```

```php
👍 if (false === $var) ...
```
