<?php

namespace InstagramAPI\Realtime\Client\WebSocket;

use GuzzleHttp\Psr7 as gPsr;
use Ratchet\Client\Connector as RatchetConnector;
use Ratchet\RFC6455\Handshake\ClientNegotiator;
use React\Promise\Deferred;
use React\Promise\RejectedPromise;
use React\SocketClient\ConnectorInterface;
use React\Stream\DuplexStreamInterface;

class Connector extends RatchetConnector
{
    /**
     * Constructor. Parent constructor call is omitted intentionally.
     *
     * @param ConnectorInterface $connector
     * @param ConnectorInterface $secureConnector
     */
    public function __construct(
        ConnectorInterface $connector,
        ConnectorInterface $secureConnector)
    {
        $this->_connector = $connector;
        $this->_secureConnector = $secureConnector;
        $this->_negotiator = new ClientNegotiator();
    }

    /**
     * TEMPORARY. WILL BE REMOVED IN FUTURE.
     *
     * @see https://github.com/ratchetphp/Pawl/pull/44
     *
     * Override base method to use custom stream parser.
     *
     * @param string $url
     * @param array  $subProtocols
     * @param array  $headers
     *
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke($url, array $subProtocols = [], array $headers = [])
    {
        try {
            $request = $this->generateRequest($url, $subProtocols, $headers);
            $uri = $request->getUri();
        } catch (\Exception $e) {
            return new RejectedPromise($e);
        }
        $connector = 'wss' === substr($url, 0, 3) ? $this->_secureConnector : $this->_connector;

        $port = $uri->getPort() ?: 80;

        return $connector->create($uri->getHost(), $port)->then(function (DuplexStreamInterface $stream) use ($request, $subProtocols) {
            $futureWsConn = new Deferred();

            $earlyClose = function () use ($futureWsConn) {
                $futureWsConn->reject(new \RuntimeException('Connection closed before handshake'));
            };

            $stream->on('close', $earlyClose);
            $futureWsConn->promise()->then(function () use ($stream, $earlyClose) {
                $stream->removeListener('close', $earlyClose);
            });

            $buffer = '';
            $headerParser = function ($data, DuplexStreamInterface $stream) use (&$headerParser, &$buffer, $futureWsConn, $request, $subProtocols) {
                $buffer .= $data;
                if (false == strpos($buffer, "\r\n\r\n")) {
                    return;
                }

                $stream->removeListener('data', $headerParser);

                $response = gPsr\parse_response($buffer);

                if (!$this->_negotiator->validateResponse($request, $response)) {
                    $futureWsConn->reject(new \DomainException(gPsr\str($response)));
                    $stream->close();

                    return;
                }

                $acceptedProtocol = $response->getHeader('Sec-WebSocket-Protocol');
                if ((count($subProtocols) > 0) && 1 !== count(array_intersect($subProtocols, $acceptedProtocol))) {
                    $futureWsConn->reject(new \DomainException('Server did not respond with an expected Sec-WebSocket-Protocol'));
                    $stream->close();

                    return;
                }

                $futureWsConn->resolve(new Socket($stream, $response, $request));

                $futureWsConn->promise()->then(function (Socket $conn) use ($stream) {
                    $stream->emit('data', [$conn->response->getBody(), $stream]);
                });
            };

            $stream->on('data', $headerParser);
            $stream->write(gPsr\str($request));

            return $futureWsConn->promise();
        });
    }
}
