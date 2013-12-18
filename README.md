KitpagesActivityBundle
======================

Records activity of a website and manage notifications to the users.

Features :

* record activities
* display activities with a paginator and a full text filter

Create an activity
------------------

in a controller

```php
$this->get("kitpages_activity.activity_manager")->createActivity(
    "my_category",
    "my title",
    "my message content",
    "my url" //optionnal
);
```

