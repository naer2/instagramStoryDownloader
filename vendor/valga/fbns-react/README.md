# fbns-react

A PHP client for the FBNS built on top of ReactPHP.

## Requirements

You need to install the [GMP extension](http://php.net/manual/en/book.gmp.php) to be able to run this code on x86 PHP builds.

## Installation

```sh
composer require valga/fbns-react
```

## Basic Usage

```php
// Set up a FBNS client.
$loop = \React\EventLoop\Factory::create();
$client = new \Fbns\Client\Lite($loop);

// Read saved credentials from a storage.
$auth = new \Fbns\Client\Auth\DeviceAuth();
try {
    $auth->read($storage->get('fbns_auth'));
} catch (\Exception $e) {
}

// Connect to a broker.
$connection = new \Fbns\Client\Connection($deviceAuth, USER_AGENT);
$client->connect(HOSTNAME, PORT, $connection);

// Bind events.
$client
    ->on('connect', function (\Fbns\Client\Lite\ConnectResponsePacket $responsePacket) use ($client, $auth, $storage) {
        // Update credentials and save them to a storage for future use.
        try {
            $auth->read($responsePacket->getAuth());
            $storage->set('fbns_auth', $responsePacket->getAuth());
        } catch (\Exception $e) {
        }
        
        // Register an application.
        $client->register(PACKAGE_NAME, APPLICATION_ID);
    })
    ->on('register', function (\Fbns\Client\Message\Register $message) use ($app) {
        // Register received token with an application.
        $app->registerPushToken($message->getToken());
    })
    ->on('push', function (\Fbns\Client\Message\Push $message) use ($app) {
        // Handle received notification payload.
        $app->handlePushNotification($message->getPayload());
    });

// Run main loop.
$loop->run();
```

## Advanced Usage

```php
// Set up a proxy.
$connector = new \React\Socket\Connector($loop);
$proxy = new \Clue\React\HttpProxy('username:password@127.0.0.1:3128', $connector);

// Disable SSL verification.
$ssl = new \React\Socket\SecureConnector($proxy, $loop, ['verify_peer' => false, 'verify_peer_name' => false]);

// Enable logging to stdout.
$logger = new \Monolog\Logger('fbns');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::INFO));

// Set up a client.
$client = new \Fbns\Client\Lite($loop, $ssl, $logger);

// Persistence.
$client->on('disconnect', function () {
    // Network connection has been closed. You can reestablish it if you want to.
});
$client->connect(HOSTNAME, PORT, $connection)
    ->otherwise(function () {
        // Connection attempt was unsuccessful, retry with an exponential backoff.
    });
```
