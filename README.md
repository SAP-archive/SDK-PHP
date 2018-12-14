[logo]: https://cdn.cai.tool.sap/brand/sapcai/sap-cai-black.svg "SAP Conversational AI"

![alt text][logo]

# SAP Conversational AI - SDK PHP
SAP Conversational AI official SDK in PHP

## Synospis

This module is a wrapper around the [SAP Conversational AI](https://cai.tool.sap) API, and allows you to:
* [Analyse your text](https://github.com/SAPConversationalAI/SDK-PHP/wiki/Analyse-text)
* [Manage your conversation](https://github.com/SAPConversationalAI/SDK-PHP/wiki/Manage-conversation)
* [Receive and send messages](https://github.com/SAPConversationalAI/SDK-PHP/wiki/Receive-and-send-messages)


## Installation

Install the package using npm, as shown below:
```bash
composer require sapcai/sdk-php
```

You can now use the SDK in your code. All you need is your bot's token. In case you have enabled our versioning feature in the settings of your bot, you can refer to our [versioning documentation](https://cai.tools.sap/docs/concepts/versioning) to learn how to select the appropriate token for you versions and environments.

Using the entire SDK:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sapcai\Client;

$client = new Client('YOUR_TOKEN');
```

Extracting one single API:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sapcai\Client;

$request = Client::Request('YOUR_TOKEN');
$connect = Client::Connect('YOUR_TOKEN');
```

## More

You can view the whole API reference at [cai.tool.sap/docs/api-reference](https://cai.tool.sap/docs/api-reference).

## Author

Marian André, marian.andre@sap.com

You can follow us on Twitter at [@sapcai](https://twitter.com/sapcai) for updates and releases.

## License

Copyright (c) [2019] [SAP Conversational AI](https://cai.tool.sap)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
