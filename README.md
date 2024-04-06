# Comments Service Client

Test task library that make requests to imagine service with comments.

## Installation

Use the package manager [composer](https://pip.pypa.io/en/stable/) to install this lib

```bash
composer require sklemin/comments-service-client
```

## Usage

```php
use Sklemin\Client\ClientBuilder\ClientBuilder;
use Sklemin\Client\Exceptions\LoaderException;

$client = ClientBuilder::build('https', 'jsonplaceholder.typicode.com');

try {
    $response = $client->getComments();
    echo '<pre>';
    echo sprintf("Response status code: %s.\n\n", $response->getResponseCode());
    echo sprintf("Response headers: %s.\n\n", $response->getHeaders());
    echo sprintf("Response body: %s.\n\n", $response->getBody());
    echo '</pre>';
} catch (LoaderException $e){
    // do some errors processing
}
```
## License

[MIT](https://choosealicense.com/licenses/mit/)