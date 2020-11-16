<p align="center"><a href="https://postmarkapp.com" target="_blank"><img src="https://postmarkapp.com/images/logo.svg" alt="Postmark Inbound" width="240" height="40"></a>

# postmark-inbound

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![StyleCI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]

Simple API to process Postmark Inbound Webhooks.

## Installation

You can install the package via composer:

``` bash
composer require mvdnbrk/postmark-inbound
```

## Usage

``` php
$inbound = new \Mvdnbrk\Postmark\InboundMessage(file_get_contents('php://input'));

$inbound->from->name;                   // John Doe
$inbound->from->email;                  // john@example.com
$inbound->from->full;                   // John Doe <john@example.com>

$inbound->tag;
$inbound->replyTo;
$inbound->textBody;
$inbound->htmlBody;
$inbound->messageId;                    // MessageID assigned by Postmark.
$inbound->messageIdFromHeaders;         // Message-ID value from headers.
$inbound->strippedTextReply;
$inbound->originalRecipient;

$inbound->originalDate;                 // Wed, 6 Sep 2017 12:00:00 +0200
$inbound->date;                         // PostmarkDate::class which is an extension of the DateTime::class
$inbound->date->format('Y-m-d H:i:s')   // 2017-09-06 12:00:00
$inbound->date->isUtc                   // boolean, is the date in the UTC timezone?
$inbound->date->timezone;               // +02:00
$inbound->date->inUtcTimezone()         // Sets the timezone to UTC.
$inbound->subject;                      // Subject of the message.

$inbound->isSpam;                       // boolean, is the message to be considered as spam?
$inbound->spamStatus;                   // Spam status, defaults to 'No' when not present.
$inbound->spamScore;                    // float, defaults to 0.0 when not present.

$inbound->to->count()                   // Recipient count.
$inbound->cc->count()
$inbound->bcc->count()

$inbound->attachments->count()          // Attachment count.

$inbound->headers->count()              // Header count.
```

### Recipients

```php
$inbound->to->each(function($contact) {
    $contact->name;
    $contact->email;
    $contact->full;
    $contact->mailboxHash;
});

$inbound->cc->each(function($contact) {
    $contact->name;
    ...
});

$inbound->bcc->each(function($contact) {
    $contact->name;
    ...
});
```

Get the first recipient:
```
$inbound->to->first();
```

### Attachments

```php
$inbound->attachments->each(function($attachment) {
    $attachment->name;
    $attachment->contentType;
    $attachment->contentLength;
    $attachment->content();         // Base64 decoded data
});
```

Get the first attachment:
```php
$inbound->attachments->first();
```

Get the last attachment:
```php
$inbound->attachments->last();
```

### Headers

The Message-ID in the headers are sometimes keyed with upper `ID` and sometimes they are in the format of `Id`.
So if you want to get the Message-ID from a message you can simply use the `$inbound->messageIdFromHeaders` helper attribute.
Please note that `$inbound->messageId` will give you the id of the message that was assigned by Postmark.

```php
$inbound->headers->each(function($value, $key) {
    ...
});

$inbound->headers->get('Message-ID');
$inbound->headers->get('MIME-Version');
$inbound->headers->get('Received-SPF');
$inbound->headers->get('X-Spam-Score');
$inbound->headers->get('X-Spam-Status');
...
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark van den Broek][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/postmark-inbound.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/workflow/status/mvdnbrk/postmark-inbound/tests/main?label=tests&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/postmark-inbound.svg?style=flat-square
[ico-styleci]: https://github.styleci.io/repos/102744848/shield?style=flat-square&branch=main

[link-packagist]: https://packagist.org/packages/mvdnbrk/postmark-inbound
[link-tests]: https://github.com/mvdnbrk/postmark-inbound/actions?query=workflow%3Atests
[link-downloads]: https://packagist.org/packages/mvdnbrk/postmark-inbound
[link-styleci]: https://github.styleci.io/repos/102744848
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
