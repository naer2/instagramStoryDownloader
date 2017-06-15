<?php

namespace InstagramAPI\Realtime\Utils;

use Clue\React\HttpProxy\ProxyConnector;
use Exception;
use InvalidArgumentException;
use React\Promise\Deferred;
use React\SocketClient\ConnectorInterface;
use React\Stream\Stream;
use RingCentral\Psr7;
use RuntimeException;

/**
 * TEMPORARY. WILL BE REMOVED IN FUTURE.
 *
 * @see https://github.com/clue/php-http-proxy-react/pull/6
 */
class HttpConnectProxy extends ProxyConnector
{
    private $connector;
    private $proxyHost;
    private $proxyPort;
    private $customHeaders;

    public function __construct(
        $proxyUrl,
        ConnectorInterface $connector,
        array $customHeaders = [])
    {
        if (strpos($proxyUrl, '://') === false) {
            $proxyUrl = 'http://'.$proxyUrl;
        }

        $parts = parse_url($proxyUrl);
        if (!$parts || !isset($parts['host'])) {
            throw new InvalidArgumentException('Invalid proxy URL');
        }

        if (!isset($parts['port'])) {
            $parts['port'] = $parts['scheme'] === 'https' ? 443 : 80;
        }

        $this->connector = $connector;
        $this->proxyHost = $parts['host'];
        $this->proxyPort = $parts['port'];
        $this->customHeaders = $customHeaders;
        $username = isset($parts['user']) ? $parts['user'] : '';
        $password = isset($parts['pass']) ? $parts['pass'] : '';
        if (!empty($username) || !empty($password)) {
            $this->customHeaders = $this->customHeaders + [
                    'Proxy-Authorization' => sprintf('Basic %s', base64_encode(sprintf('%s:%s', $username, $password))),
                ];
        }
    }

    public function create(
        $host,
        $port)
    {
        $headers = $this->customHeaders;

        return $this->connector->create($this->proxyHost, $this->proxyPort)->then(function (Stream $stream) use ($host, $port, $headers) {
            $deferred = new Deferred(function ($_, $reject) use ($stream) {
                $reject(new RuntimeException('Operation canceled while waiting for response from proxy'));
                $stream->close();
            });

            // keep buffering data until headers are complete
            $buffer = '';
            $fn = function ($chunk) use (&$buffer, &$fn, $deferred, $stream) {
                $buffer .= $chunk;

                $pos = strpos($buffer, "\r\n\r\n");
                if ($pos !== false) {
                    // end of headers received => stop buffering
                    $stream->removeListener('data', $fn);

                    // try to parse headers as response message
                    try {
                        $response = Psr7\parse_response(substr($buffer, 0, $pos));
                    } catch (Exception $e) {
                        $deferred->reject(new RuntimeException('Invalid response received from proxy: '.$e->getMessage(), 0, $e));
                        $stream->close();

                        return;
                    }

                    // status must be 2xx
                    if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                        $deferred->reject(new RuntimeException('Proxy rejected with HTTP error code: '.$response->getStatusCode().' '.$response->getReasonPhrase(), $response->getStatusCode()));
                        $stream->close();

                        return;
                    }

                    // all okay, resolve with stream instance
                    $deferred->resolve($stream);

                    // emit remaining incoming as data event
                    $buffer = (string) substr($buffer, $pos + 4);
                    if ($buffer !== '') {
                        $stream->emit('data', [$buffer]);
                        $buffer = '';
                    }

                    return;
                }

                // stop buffering when 8 KiB have been read
                if (isset($buffer[8192])) {
                    $deferred->reject(new RuntimeException('Proxy must not send more than 8 KiB of headers'));
                    $stream->close();
                }
            };
            $stream->on('data', $fn);

            $stream->on('error', function (Exception $e) use ($deferred) {
                $deferred->reject(new RuntimeException('Stream error while waiting for response from proxy', 0, $e));
            });

            $stream->on('close', function () use ($deferred) {
                $deferred->reject(new RuntimeException('Connection to proxy lost while waiting for response'));
            });

            $hostAndPort = sprintf('%s:%d', $host, $port);
            $request = new Psr7\Request('CONNECT', $hostAndPort, $headers);
            $request = $request->withRequestTarget($hostAndPort);
            $stream->write(Psr7\str($request));

            return $deferred->promise();
        });
    }
}
