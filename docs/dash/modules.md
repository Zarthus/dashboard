# Modules

Creating a module is trivially easy. Each module looks roughly like this:

```php
<?php

class YourModule extends AbstractModule
{
    // Validate the module before execution: Ensures no configuration mistakes
    // are made. Should throw a bunch of ValidationExceptions.
    public function validate(): void
    {
        // This is a helper to check if $this->config has a certain key.
        // Will throw a ValidationException if not set.
        $this->requireConfigOption('some_var');
    }

    // Runs the application. Write your logic in here.
    public function execute(): string
    {
        return $this->config['some_var'];
    }

    // This provides a sensible default cache time-to-live for your module
    public function getDefaultCacheTtl(): int { return 3600; }
}
```

Your module has access to several components:

- The entire `Kernel`, which in itself can be used to access core configurations.
- A lazy loaded Monolog logger through `$this->getLogger()`
- The `$this->config`, an array of the options provided in the module config section.
