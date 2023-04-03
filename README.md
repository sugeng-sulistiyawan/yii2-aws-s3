# Yii2 AWS S3

Amazon S3 or Amazon Simple Storage Service component for Yii2.

[![Latest Stable Version](http://poser.pugx.org/diecoding/yii2-aws-s3/v)](https://packagist.org/packages/diecoding/yii2-aws-s3)
[![Total Downloads](http://poser.pugx.org/diecoding/yii2-aws-s3/downloads)](https://packagist.org/packages/diecoding/yii2-aws-s3)
[![Quality Score](https://img.shields.io/scrutinizer/g/sugeng-sulistiyawan/yii2-aws-s3.svg)](https://scrutinizer-ci.com/g/sugeng-sulistiyawan/yii2-aws-s3)
[![Build Status](https://app.travis-ci.com/sugeng-sulistiyawan/yii2-aws-s3.svg?branch=master)](https://app.travis-ci.com/sugeng-sulistiyawan/yii2-aws-s3)
[![Latest Unstable Version](http://poser.pugx.org/diecoding/yii2-aws-s3/v/unstable)](https://packagist.org/packages/diecoding/yii2-aws-s3)
[![License](http://poser.pugx.org/diecoding/yii2-aws-s3/license)](https://packagist.org/packages/diecoding/yii2-aws-s3)
[![PHP Version Require](http://poser.pugx.org/diecoding/yii2-aws-s3/require/php)](https://packagist.org/packages/diecoding/yii2-aws-s3)

> Yii2 AWS S3 uses [SemVer](http://semver.org/).

## Table of Contents

- [Yii2 AWS S3](#yii2-aws-s3)
  - [Table of Contents](#table-of-contents)
  - [Instalation](#instalation)
  - [Dependencies](#dependencies)
  - [Configuration](#configuration)
  - [Usage](#usage)
    - [Basic Usage](#basic-usage)
    - [Advanced Usage](#advanced-usage)
    - [Custom Commands](#custom-commands)
  - [License](#license)

## Instalation

Package is available on [Packagist](https://packagist.org/packages/diecoding/yii2-aws-s3), 
you can install it using [Composer](https://getcomposer.org).

```shell
composer require diecoding/yii2-aws-s3 "^1.0"
```

or add to the require section of your `composer.json` file.

```
"diecoding/yii2-aws-s3": "^1.0"
```

## Dependencies

- PHP 7.4+
- [yiisoft/yii2](https://github.com/yiisoft/yii2)
- [aws/aws-sdk-php](https://github.com/aws/aws-sdk-php)

## Configuration

1. Add the component to `config/main.php`

    ```php
    'components' => [
        // ...
        's3' => [
            'class' => \diecoding\aws\s3\Service::class,
            'endpoint' => 'my-endpoint',
            'usePathStyleEndpoint' => true,
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => 'my-key',
                'secret' => 'my-secret',
            ],
            'region' => 'my-region',
            'defaultBucket' => 'my-bucket',
            'defaultAcl' => 'public-read',
        ],
        // ...
    ],
    ```

## Usage

### Basic Usage

```php
/** @var \diecoding\aws\s3\Service $s3 */
$s3 = Yii::$app->get('s3');
// or 
$s3 = Yii::$app->s3;

// Usage of the command factory and additional params
// ==================================================

/** @var \Aws\ResultInterface $result */
$result = $s3->commands()->get('filename.ext')->saveAs('/path/to/local/file.ext')->execute();

$result = $s3->commands()->put('filename.ext', 'body')->withContentType('text/plain')->execute();

$result = $s3->commands()->delete('filename.ext')->execute();

$result = $s3->commands()->upload('filename.ext', '/path/to/local/file.ext')->withAcl('private')->execute();

$result = $s3->commands()->restore('filename.ext', $days = 7)->execute();

$result = $s3->commands()->list('path/')->execute();

/** @var bool $exist */
$exist = $s3->commands()->exist('filename.ext')->execute();

/** @var string $url */
$url = $s3->commands()->getUrl('filename.ext')->execute();

/** @var string $signedUrl */
$signedUrl = $s3->commands()->getPresignedUrl('filename.ext', '+2 days')->execute();

// Short syntax
// ============

/** @var \Aws\ResultInterface $result */
$result = $s3->get('filename.ext');

$result = $s3->put('filename.ext', 'body');

$result = $s3->delete('filename.ext');

$result = $s3->upload('filename.ext', '/path/to/local/file.ext');

$result = $s3->restore('filename.ext', $days = 7);

$result = $s3->list('path/');

/** @var bool $exist */
$exist = $s3->exist('filename.ext');

/** @var string $url */
$url = $s3->getUrl('filename.ext');

/** @var string $signedUrl */
$signedUrl = $s3->getPresignedUrl('filename.ext', '+2 days');

// Asynchronous execution
// ======================

/** @var \GuzzleHttp\Promise\PromiseInterface $promise */
$promise = $s3->commands()->get('filename.ext')->async()->execute();

$promise = $s3->commands()->put('filename.ext', 'body')->async()->execute();

$promise = $s3->commands()->delete('filename.ext')->async()->execute();

$promise = $s3->commands()->upload('filename.ext', 'source')->async()->execute();

$promise = $s3->commands()->list('path/')->async()->execute();
```

### Advanced Usage

```php
/** @var \diecoding\aws\s3\Service $s3 */
$s3 = Yii::$app->get('s3');
// or 
$s3 = Yii::$app->s3;

/** @var \diecoding\aws\s3\commands\GetCommand $command */
$command = $s3->create(GetCommand::class);
$command->inBucket('my-another-bucket')->byFilename('filename.ext')->saveAs('/path/to/local/file.ext');

/** @var \Aws\ResultInterface $result */
$result = $s3->execute($command);

// or async
/** @var \GuzzleHttp\Promise\PromiseInterface $promise */
$promise = $s3->execute($command->async());
```

### Custom Commands

Commands have two types: plain commands that's handled by the `PlainCommandHandler` and commands with their own handlers.
The plain commands wrap the native AWS S3 commands.

The plain commands must implement the `PlainCommand` interface and the rest must implement the `Command` interface.
If the command doesn't implement the `PlainCommand` interface, it must have its own handler.

Every handler must extend the `Handler` class or implement the `Handler` interface.
Handlers gets the `S3Client` instance into its constructor.

The implementation of the `HasBucket` and `HasAcl` interfaces allows the command builder to set the values
of bucket and acl by default.

To make the plain commands asynchronously, you have to implement the `Asynchronous` interface.
Also, you can use the `Async` trait to implement this interface.

Consider the following command:

```php
<?php

namespace app\components\s3\commands;

use diecoding\aws\s3\base\commands\traits\Options;
use diecoding\aws\s3\interfaces\commands\Command;
use diecoding\aws\s3\interfaces\commands\HasBucket;

class MyCommand implements Command, HasBucket
{
    use Options;

    protected $bucket;

    protected $something;

    public function getBucket()
    {
        return $this->bucket;
    }

    public function inBucket(string $bucket)
    {
        $this->bucket = $bucket;

        return $this;
    }

    public function getSomething()
    {
        return $this->something;
    }

    public function withSomething(string $something)
    {
        $this->something = $something;

        return $this;
    }
}
```

The handler for this command looks like this:

```php
<?php

namespace app\components\s3\handlers;

use app\components\s3\commands\MyCommand;
use diecoding\aws\s3\base\handlers\Handler;

class MyCommandHandler extends Handler
{
    public function handle(MyCommand $command)
    {
        return $this->s3Client->someAction(
            $command->getBucket(),
            $command->getSomething(),
            $command->getOptions()
        );
    }
}
```

And usage this command:

```php
/** @var \diecoding\aws\s3\Service $s3 */
$s3 = Yii::$app->get('s3');
// or 
$s3 = Yii::$app->s3;

/** @var \app\components\s3\commands\MyCommand $command */
$command = $s3->create(MyCommand::class);
$command->withSomething('some value')->withOption('OptionName', 'value');

/** @var \Aws\ResultInterface $result */
$result = $s3->execute($command);
```

Custom plain command looks like this:

```php
<?php

namespace app\components\s3\commands;

use diecoding\aws\s3\interfaces\commands\HasBucket;
use diecoding\aws\s3\interfaces\commands\PlainCommand;

class MyPlainCommand implements PlainCommand, HasBucket
{
    protected $args = [];

    public function getBucket()
    {
        return $this->args['Bucket'] ?? '';
    }

    public function inBucket(string $bucket)
    {
        $this->args['Bucket'] = $bucket;

        return $this;
    }

    public function getSomething()
    {
        return $this->args['something'] ?? '';
    }

    public function withSomething($something)
    {
        $this->args['something'] = $something;

        return $this;
    }

    public function getName(): string
    {
        return 'AwsS3CommandName';
    }

    public function toArgs(): array
    {
        return $this->args;
    }
}
```

Any command can extend the `ExecutableCommand` class or implement the `Executable` interface that will
allow to execute this command immediately: `$command->withSomething('some value')->execute();`.

## License

Yii2 AWS S3 is licensed under the MIT License.

See the [LICENSE](LICENSE) file for more information.
