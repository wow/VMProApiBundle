# Video Manager Pro API Bundle

[![Build Status](https://travis-ci.org/MovingImage24/VMProApiBundle.svg?branch=master)](https://travis-ci.org/MovingImage24/VMProApiBundle)

Official Symfony bundle for interacting with the Video Manager Pro API.

## Installation

You can install this bundle with composer:

```
composer install movingimage/vmpro-api-bundle
```

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new MovingImage\Bundle\VMProApiBundle(),
        );

        // ...
    }

    // ...
}
```

## Configuration

Inside your `app/config/config.yml` you must at least define the following configuration:

```
vm_pro_api:
    base_url:      %vmpro_base_url%
    default_vm_id: %vmpro_vm_id%
    credentials:
        username:  %vmpro_username%
        password:  %vmpro_password%
```

Please note that you will have to either define the parameters (between the '%%' in the example) in your own `parameters.yml`, or exchange them with your pre-existing parameters.

You may omit the `base_url` parameter, in which case it will default to the **production** API base URL for Video Manager Pro.

`default_vm_id` is an optional parameter, but useful to specify if you interact with only a single video manager.

## Usage

### Testing connection to the API

Once the bundle is installed and configured, you can test whether your configuration lets you successfully connect to the API.
 
Please note: the configuration parameter `default_vm_id` is required for this functionality.

Run the command like this:

```
$ ./bin/console vmpro-api:test-connection
```
  
If your configuration was correct, you should see something like:

```
✔ Connecting with the API succeeded.
```


### Services

Once the bundle is installed, the following services become available to use inside your own service container configuration or controllers:

### @vmpro_api.client

This service is the main API client for interacting with Video Manager Pro API

#### Service container

Inject it like a service in your own `services.yml`:

```
services:
    my_app.my_service:
        class: MyBundle\Services\MyService
        arguments: ["@vmpro_api.client"]
```

#### Controller

Use it inside your controller:

```php
<?php

namespace AppBundle\Controller;

// ...
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
      // ...
      $client = $this->get('vmpro_api.client');
      // ...
    }
}

```

### @vmpro_api.token_manager

This service is the token manager, which manages access + refresh token state for the Video Manager Pro API interaction.

For most normal use cases you should not have the need to access this service directly, but there is some cases in which it might be useful.

#### Service container

Inject it like a service in your own `services.yml`:

```
services:
    my_app.my_service:
        class: MyBundle\Services\MyService
        arguments: ["@vmpro_api.token_manager"]
```

#### Controller

Use it inside your controller:

```php
<?php

namespace AppBundle\Controller;

// ...
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
      // ...
      $client = $this->get('vmpro_api.token_manager');
      // ...
    }
}

```

## Maintainers

* Ruben Knol - ruben.knol@movingimage.com

If you have questions, suggestions or problems, feel free to get in touch with the maintainers by e-mail.

## Contributing

If you want to expand the functionality of the API clients, or fix a bug, feel free to fork and do a pull request back onto the 'master' branch. Make sure the tests pass.