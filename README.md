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
    "my url", //optionnal
    "my reference", //optionnal
    array("key1" => "val1", ), //optionnal
);
```

### Best practices

* the category field is used for filtering activities by category
* the reference field is used to represent the object linked to this activity (if there is an object)
* The data field is used to add every information you would need linked to this activity

### Display a list of activities in a twig template

```twig
{{ render(controller('KitpagesActivityBundle:Activity:list', {
    'filterList': { "category": "my_category" },
    'request': app.request
} ) ) }}
```

note : category is not mandatory in filter list.

### get activity list in PHP

#### get all activities

```php
$activityManager = $this->get("kitpages_activity.activity_manager");
$activityList = $activityManager->getActivityList();
```

#### get activities for a given category

```php
$activityManager = $this->get("kitpages_activity.activity_manager");
$activityList = $activityManager->getActivityList( array(
    "category" => "my category"
) );
```

#### get activities for all categories beginning by "payments."

```php
$activityManager = $this->get("kitpages_activity.activity_manager");
$activityList = $activityManager->getActivityList( array(
    "category" => "payment.*"
) );
```

#### principle of filter

You can filter the fields category, title, message, url or reference.

You can use "*" at the beginning or the end of your filter as a wildcard (everything
with category beginning by "xxx" or ending by "xxx").

#### ordering results

By default activity list is ordered by createdAt DESC. You can specify the order :

```php
$activityManager = $this->get("kitpages_activity.activity_manager");
$activityList = $activityManager->getActivityList(
    array("category" => "payment.*"),
    "id", // sort field : id, reference, category, createdAt
    "DESC" // order
);
```

## Features :

* record activities
* display activities with a paginator and a full text filter

## Installation

Using [Composer](http://getcomposer.org/), just `$ composer require kitpages/activity-bundle` package or:

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
