KitpagesActivityBundle
======================

[![Build Status](https://travis-ci.org/kitpages/KitpagesActivityBundle.svg?branch=master)](https://travis-ci.org/kitpages/KitpagesActivityBundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d63cc087-a033-428a-bdf9-9870bfbf4dd7/small.png)](https://insight.sensiolabs.com/projects/d63cc087-a033-428a-bdf9-9870bfbf4dd7)

Records activity of a website and display notifications on some pages.

Mostly used for rapid prototyping.

## Quick Start

### Create an activity

```php
$this->get("kitpages_activity.activity_manager")->createActivity(
    "my_category",
    "my title",
    "my message content",
    "my url" //optionnal
);
```

### Display a list of activities in a twig template

```twig
{{ render(controller('KitpagesActivityBundle:Activity:list', {
    'filterList': { "category": "my_category" },
    'request': app.request
} ) ) }}
```

note : category is not mandatory in filter list.

## Features :

* record activities
* display activities with a paginator and a full text filter

## Installation

Using [Composer](http://getcomposer.org/), just `$ composer require kitpages/semaphore-bundle` package or:

```javascript
{
  "require": {
    "kitpages/activity-bundle": "~1.0"
  }
}
```

Then add the bundle in AppKernel :

```php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Kitpages\ActivityBundle\KitpagesActivityBundle(),
            new Kitpages\DataGridBundle\KitpagesDataGridBundle(),
        );
    }
```
