# Application Flow

Dash has a few key concepts that are useful to understand the application
workflow.

Every request starts at the `public/index.php`, which boots up the Kernel,
sets the Exception handler, reads the primary configuration, etc.

Then you have `config/` as a folder, which contains a main.php (core configurations)
and a `layout.php` where your main layouts are stored.

The layout will look roughly like this:

```php
<?php

return [
    'layout:index' => [
        'base' => 'base', // The base layout to extend from (Core/Resources/view/layout)
        'title' => 'Simple Dashboard', // Application Title

        'variables' => [
            // Numerous base template variables
            // ...
        ],

        // A collection of containers
        'containers' => [
            [
                'template' => 'column_two_horizontal', // The template (Core/Resources/view/templates) to use
                // The cache TTL to use for this container. Even if the inner modules cache for less time
                // this will take priority.
                'cache_ttl' => 3600,

                // A collection of things to render. Each template has a few variables
                // that needs definition. Each "section" (sectionLeft, sectionRight) is one
                // such thing. You should look in docs/configuration or the template itself
                // to discover what needs to be set.
                'render' => [
                    'sectionLeft' => [
                        // The module that occupies this section,
                        'module' => 'Constant.StaticHtml',

                        // Configuration the module needs. Refer to docs/configuration
                        // for this. You can also define "cache_ttl" in here to override
                        // the default module cache ttl.
                        'config' => [
                            'text' => 'Lorem ipsum',
                        ],
                    ],

                    'sectionRight' => [
                        'module' => 'Constant.StaticHtml',

                        'config' => [
                            'text' => 'dolor sit amet',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

This config throws a few definitions at us.

First of all, we define the `Layout`, which is the main wrapper for this page.

The layout has a few variables and sets the base template to inherit from, but then
delegates to several smaller components called `Container`s

Containers have a template definition (which is a partial), define cache TTL for the
first time, and then moves on to a 'render' block which will create `Section`s

Sections are basically containers for a single `Module`'s output, they can yet again
define a cache TTL, are used for configuration management of a module (say a twitter
api key, for instance.)

Then you have the Module at last, which is where all the complex logic happens (loading
tweets, checking uptime of servers, showing server load, etc.)

And that's everything there is to it.
