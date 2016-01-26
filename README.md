yii2-snotify
============
Snotify is extension implements at server-side notification to the user without client-side.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bupy7/yii2-snotify "*"
```

or add

```
"bupy7/yii2-snotify": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Register module to `modules` section in config file:

```php
[
    'modules' => [
        ...
        
        'snotifymodule' => [
            'class' => 'bupy7\notify\ss\Module',
        ],

        ...
    ],
],
```

Add `snotifymodule` to `bootstrap` section in config file:

```php
[
    'bootstrap' => [
        ...
        
        'snotifymodule',
    
        ...
    ],
],
```

Register manager of snotify to `components` section in config file:

```php
[
    'components' => [
        ...

        'snotify' => [
            'class' => 'bupy7\notify\ss\components\Manager',
        ],
        
        ...
    ],
],
```

> You can rename a component and a module how do you like.

Run migration:

```
php ./yii migrate/up --migrationPath=@bupy7/notify/ss/migrations
```

Adding notification message:

```php
$userId = Yii::$app->user->id;
$body = 'Example of text message';
$title = 'Example of title message';
Yii::$app->snotify
    // success notify type
    ->addSuccess($userId, $body, $title)
    // danger notify type
    ->addDanger($userId, $body, $title)
    // info notify type
    ->addInfo($userId, $body, $title)
    // warning notify type
    ->addWarning($userid, $body, $title);
```

Profit! Your notification added to {{%notification}} table.

Configuration
-------------

Module:


```php
[
    'modules' => [
        ...
        
        'snotifymodule' => [
            'class' => 'bupy7\notify\ss\Module',
            'tableName' => '{{%notification}}', // table name with notification messages
            'db' => 'db', // database connection component config or name
        ],

        ...
    ],
],
```

License
-------

yii2-snotify is released under the BSD 3-Clause License.