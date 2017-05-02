# AllProgrammic SendinBlue Bundle

This bundle provides integration and api client of the sendinblue mail broker with Symfony

## Installation

Get the dependence in your project

```bash
composer require allprogrammic/sendinblue-bundle
```

Enable the bundle. In your AppKernel.php

```php
public function registerBundles()
{
    $bundles = [
        // ...
        new AllProgrammic\Bundle\SendinBlueBundle\AllProgrammicSendinBlueBundle(),
        // ...
    ];
}
```

## Configuration

Get your sendinblue API key [here](https://account.sendinblue.com/advanced/api/), and add it to your config.yml

```yaml
sendinblue:
    api:
        key: 'your key'
```

You may also want to set it through your parameters.yml file.

parameters.yml
```yaml
parameters
  sendinblue_api_key: 'your key'
```

config.yml
```yaml
sendinblue:
    api:
        key: '%sendinblue_api_key%'
```

## Usage

This bundle provide a service 'sendinblue.api.client' to interact with the sendinblue api.

### Example : retrieve your account data

```php
$this->get('sendinblue.api.client')->getAccount();
```

### Example : send a transactional message

```php
$message = new \AllProgrammic\Bundle\SendinBlueBundle\Api\TransactionalMessage('my subject');
$message
    ->from('test@test.com', 'My Company')
    ->addTo('john.doe@acme.com')
    ->html($this->renderView('mytemplate.html.twig'))
    ->text($this->renderView('mytemplate.txt.twig'));

$this->get('sendinblue.api.client')->sendTransactional(message);
```
