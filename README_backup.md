# Chelsymooy Subscriptions

**Chelsymooy Subscriptions** is a flexible plans and subscription management system for Laravel, with the required tools to run your SAAS like services efficiently. It's simple architecture, accompanied by powerful underlying to afford solid platform for your business.

[![Packagist](https://img.shields.io/packagist/v/chelsymooy/laravel-subscriptions.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/chelsymooy/laravel-subscriptions)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/chelsymooy/laravel-subscriptions.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/chelsymooy/laravel-subscriptions/)
[![Travis](https://img.shields.io/travis/chelsymooy/laravel-subscriptions.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/chelsymooy/laravel-subscriptions)
[![StyleCI](https://styleci.io/repos/93313402/shield)](https://styleci.io/repos/93313402)
[![License](https://img.shields.io/packagist/l/chelsymooy/laravel-subscriptions.svg?label=License&style=flat-square)](https://github.com/chelsymooy/laravel-subscriptions/blob/develop/LICENSE)


## Considerations

- Payments are out of scope for this package.
- You may want to extend some of the core models, in case you need to override the logic behind some helper methods like `renew()`, `cancel()` etc. E.g.: when cancelling a subscription you may want to also cancel the recurring payment attached.


## Installation

1. Install the package via composer:
    ```shell
    composer require chelsymooy/laravel-subscriptions
    ```

2. Publish resources (migrations and config files):
    ```shell
    php artisan vendor:publish
    ```

3. Execute migrations via the following command:
    ```shell
    php artisan migrate
    ```

4. Done!


## Usage

### New Subscription

**Chelsymooy Subscriptions** has been specially made for Eloquent and simplicity has been taken very serious as in any other Laravel related aspect. To add Subscription functionality to your User model just use the `\Chelsymooy\Subscriptions\Traits\HasSubscriptions` trait like this:

```php
namespace App\Models;

use Chelsymooy\Subscriptions\Traits\HasSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasSubscriptions;
}
```

That's it, we only have to use that trait in our User model! Now your users may subscribe to plans.

### Recurring Bill

```php
$plan = app('Chelsymooy.subscriptions.plan')->create([
    'name' => 'Pro',
    'description' => 'Pro plan',
    'price' => 9.99,
    'signup_fee' => 1.99,
    'invoice_period' => 1,
    'invoice_interval' => 'month',
    'trial_period' => 15,
    'trial_interval' => 'day',
    'sort_order' => 1,
    'currency' => 'USD',
]);

// Create multiple plan features at once
$plan->features()->saveMany([
    new PlanFeature(['name' => 'listings', 'value' => 50, 'sort_order' => 1]),
    new PlanFeature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
    new PlanFeature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
    new PlanFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
]);
```

### Activate Subscription as Middleware

You can query the plan for further details, using the intuitive API as follows:

```php
$plan = app('Chelsymooy.subscriptions.plan')->find(1);

// Get all plan features                
$plan->features;

// Get all plan subscriptions
$plan->subscriptions;

// Check if the plan is free
$plan->isFree();

// Check if the plan has trial period
$plan->hasTrial();

// Check if the plan has grace period
$plan->hasGrace();
```

Both `$plan->features` and `$plan->subscriptions` are collections, driven from relationships, and thus you can query these relations as any normal Eloquent relationship. E.g. `$plan->features()->where('name', 'listing_title_bold')->first()`.

### Send Bill to User Email

Say you want to show the value of the feature _pictures_per_listing_ from above. You can do so in many ways:

```php
// Use the plan instance to get feature's value
$amountOfPictures = $plan->getFeatureByName('pictures_per_listing')->value;

// Query the feature itself directly
$amountOfPictures = app('Chelsymooy.subscriptions.plan_feature')->where('name', 'pictures_per_listing')->first()->value;

// Get feature value through the subscription instance
$amountOfPictures = app('Chelsymooy.subscriptions.plan_subscription')->find(1)->getFeatureValue('pictures_per_listing');
```

### Frontend Hook

Coming soon

### Scopes

### Models

**Chelsymooy Subscriptions** uses 4 models:

```php
Chelsymooy\Subscriptions\Models\Plan;
Chelsymooy\Subscriptions\Models\PlanPrice;
Chelsymooy\Subscriptions\Models\Subscription;
Chelsymooy\Subscriptions\Models\Bill;
```


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Help on Email](mailto:chelsy@thunderlab.id)
- [Follow on Twitter](https://twitter.com/cmooy)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [chelsy@thunderlab.id](chelsy@thunderlab.id). All security vulnerabilities will be promptly addressed.


## About Chelsymooy

Chelsymooy is a software developer specialized in web & android applications.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2020 Chelsymooy LLC, Some rights reserved.
