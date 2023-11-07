## Bifrost

This package deleloped to be like a bridge between PHP and JavaScript.

### Installation

```bash
composer require amgrade/bifrost
```

### Usage

```php
// Somewhere in your controller class.
\AMgrade\Bifrost\Bifrost::push(['foo' => 'bar', 'baz' => 'foo']);
```

```php
// Later in your view (e.g. Laravel Blade).
<head>
...
{!! \AMgrade\Bifrost\Bifrost::toHtml() !!}
</head>
```

```javascript
// In your JS app.
console.log(window.Bifrost.foo);
console.log(window.Bifrost.baz);
```

### Configuration
You can pass your own namespace to prevent name conflicts.

```php
<head>
...
{!! \AMgrade\Bifrost\Bifrost::toHtml('YOUR_NAMESPACE') !!}
</head>
```

```javascript
// In your JS app.
console.log(window.YOUR_NAMESPACE.foo);
console.log(window.YOUR_NAMESPACE.baz);
```
