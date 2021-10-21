<?php

namespace App\Kraken;

use App\Kraken\Contracts\Order as OrderContract;
use App\Kraken\Exceptions\KrakenApiErrorException;
use App\Kraken\Objects\{
    Balance,
    BalanceCollection,
    OrdersCollection,
    OrderStatus,
    Pair,
    PairCollection,
    Ticker,
    TickerCollection
};
use Carbon\Carbon;
use GuzzleHttp\ClientInterface as HttpClient;
use Illuminate\Support\Collection;

class Client implements Contracts\Client
{
    const API_URL = 'https://api.kraken.com';
    const API_VERSION = 0;

    /**
     * API key
     *
     * @var string
     */
    protected $key;

    /**
     * API secret
     *
     * @var string
     */
    protected $secret;

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * Two-factor password
     *
     * @var string
     */
    private $otp;

    /**
     * @param HttpClient $client
     * @param string $key API key
     * @param string $secret API secret
     * @param string|null $otp Two-factor password (if two-factor enabled, otherwise not required)
     */
    public function __construct(HttpClient $client, string $key, string $secret, string $otp = null)
    {
        $this->client = $client;
        $this->key = $key;
        $this->secret = $secret;
        $this->otp = $otp;
    }

    /**
     * Get tradable asset pairs
     *
     * @param string|array $pair
     * @param string $info Info to retrieve
     *                      info = all info (default),
     *                      leverage = leverage info,
     *                      fees = fees schedule,
     *                      margin = margin info
     *
     * @return PairCollection|Pair[]
     * @throws KrakenApiErrorException
     */
    public function getAssetPairs($pair = null, string $info = 'info'): PairCollection
    {
        $data = ['info' => $info];
        if ($pair) {
            if (is_array($pair)) {
                $pair = implode(',', $pair);
            }

            $data['pair'] = $pair;
        }

        $result = $this->request('AssetPairs', $data);

        return (new PairCollection($result))->map(function ($information, $pair) {
            return new Pair($pair, $information);
        });
    }

    public function getAsset(): PairCollection
    {
        $result = $this->request('Assets', [], true, false);

        return (new PairCollection($result))->map(function ($information, $pair) {
            return new Pair($pair, $information);
        });
    }

    /**
     * Get ticker information
     *
     * @param string|array $pair comma delimited list of asset pairs to get info on
     * @return TickerCollection|Ticker[]
     * @throws KrakenApiErrorException
     */
    public function getTicker($pair): TickerCollection
    {
        if (is_array($pair)) {
            $pair = implode(',', $pair);
        }

        $result = $this->request('Ticker', ['pair' => $pair]);

        return (new TickerCollection($result))->map(function ($information, $pair) {
            return new Ticker($pair, $information);
        });
    }

    /**
     * Get account balance
     *
     * @return BalanceCollection|Balance[]
     * @throws KrakenApiErrorException
     */
    public function getAccountBalance(): BalanceCollection
    {
        $result = $this->request('Balance', [], false);

        return (new BalanceCollection($result))->map(function ($amount, $currency) {
            return new Balance($currency, $amount);
        });
    }

    /**
     * Get trade balance
     *
     * @return array
     * @throws KrakenApiErrorException
     */
    public function getTradeBalance(): array
    {
        return $this->request('TradeBalance', ['asset' => 'ZEUR'], false);
    }

    /**
     * Get trade balance
     *
     * @return array
     * @throws KrakenApiErrorException
     */
     
    public function getTradesCurrency($pair): array
    {
        return $this->request('Trades', ['pair' => $pair], true);
    }

    public function getTradesCurrencyByDate($pair, $timestamp): array
    {
        return $this->request('Trades', ['pair' => $pair, 'since' => $timestamp], true);
    }

    public function getLedgers(): array
    {
        return $this->request('Ledgers', [], false);
    }

    public function getTradeVolume($pair = null): array
    {
        return $this->request('TradeVolume', ['pair' => $pair], false);
    }

    public function getTradesHistory(): array
    {
        return $this->request('TradesHistory', [], false);
    }

    /**
     * Get open orders
     *
     * @param bool $trades Whether or not to include trades in output
     * @return OrdersCollection
     * @throws KrakenApiErrorException
     */
    public function getOpenOrders(bool $trades = false): OrdersCollection
    {
        $orders = $this->request('OpenOrders', ['trades' => $trades], false);

        return $this->makeCollection(
            $orders['open']
        );
    }

    /**
     * Get closed orders
     *
     * @param bool $trades Whether or not to include trades in output
     * @param Carbon|null $start Starting date
     * @param Carbon|null $end Ending date
     * @return OrdersCollection
     * @throws KrakenApiErrorException
     */
    public function getClosedOrders(bool $trades = false, Carbon $start = null, Carbon $end = null): OrdersCollection
    {
        $parameters = ['trades' => $trades];

        if ($start) {
            $parameters['start'] = $start->timestamp;
        }

        if ($end) {
            $parameters['end'] = $end->timestamp;
        }

        $orders = $this->request('ClosedOrders', $parameters, false);

        return $this->makeCollection(
            $orders['closed']
        );
    }

    /**
     * Add standard order
     *
     * @param OrderContract $order
     * @return OrderStatus
     * @throws KrakenApiErrorException
     */
    public function addOrder(OrderContract $order): OrderStatus
    {
        $result = $this->request('AddOrder', $order->toArray(), false);

        return new OrderStatus($result['txid'][0], $result['descr']);
    }

    /**
     * Cancel open order
     *
     * @param string $transactionId
     * @return array
     * @throws KrakenApiErrorException
     */
    public function cancelOrder(string $transactionId): array
    {
        return $this->request('CancelOrder', ['txid' => $transactionId], false);
    }

    /**
     * Make request
     *
     * @param string $method
     * @param array $parameters
     * @param bool $isPublic
     * @return array
     * @throws KrakenApiErrorException
     */
    public function request(string $method, array $parameters = [], bool $isPublic = true, bool $isPost = true): array
    {
        $headers = ['User-Agent' => 'Kraken PHP API Agent'];

        if (!$isPublic) {
            if ($this->otp) {
                $parameters['otp'] = $this->otp;
            }

            $parameters['nonce'] = $this->generateNonce();

            $headers['API-Key'] = $this->key;
            $headers['API-Sign'] = $this->generateSign($method, $parameters);
        }

        if ($isPost)
            $result = $this->sendRequest($method, $parameters, $isPublic, $headers);
        else
            $result = $this->sendRequestGet($method, $isPublic);

        if (!empty($result['error'])) {
            throw new KrakenApiErrorException(implode(', ', $result['error']));
        }

        return $result['result'];
    }

    /**
     * @param string $method
     * @param bool $isPublic
     * @return string
     */
    protected function buildUrl(string $method, bool $isPublic = true): string
    {
        return static::API_URL . $this->buildPath($method, $isPublic);
    }

    /**
     * @param string $method
     * @param bool $isPublic
     * @return string
     */
    protected function buildPath(string $method, bool $isPublic = true): string
    {
        $queryType = $isPublic ? 'public' : 'private';

        return '/' . static::API_VERSION . '/' . $queryType . '/' . $method;
    }

    /**
     * Message signature using HMAC-SHA512 of (URI path + SHA256(nonce + POST data))
     * and base64 decoded secret API key
     *
     * @param string $method
     * @param array $parameters
     * @return string
     */
    protected function generateSign(string $method, array $parameters = []): string
    {
        $queryString = http_build_query($parameters, '', '&');

        return base64_encode(
            hash_hmac(
                'sha512',
                $this->buildPath($method, false) . hash('sha256', $parameters['nonce'] . $queryString, true),
                base64_decode($this->secret),
                true
            )
        );
    }

    /**
     * Generate a 64 bit nonce using a timestamp at microsecond resolution
     * string functions are used to avoid problems on 32 bit systems
     *
     * @return string
     */
    protected function generateNonce(): string
    {
        $nonce = explode(' ', microtime());
        return $nonce[1] . str_pad(substr($nonce[0], 2, 6), 6, '0');
    }

    /**
     * Decode json response from Kraken API
     *
     * @param $response
     * @return array
     */
    protected function decodeResult($response): array
    {
        return \GuzzleHttp\json_decode(
            $response,
            true
        );
    }

    /**
     * @param array $orders
     * @return OrdersCollection
     */
    protected function makeCollection(array $orders): OrdersCollection
    {
        return (new OrdersCollection($orders))->map(function ($order, $txid) {
            return new Objects\Order($txid, $order);
        });
    }

    /**
     * @param string $method
     * @param array $parameters
     * @param bool $isPublic
     * @param $headers
     * @return array
     */
    protected function sendRequest(string $method, array $parameters, bool $isPublic, $headers): array
    {
        $response = $this->client->post($this->buildUrl($method, $isPublic), [
            'headers' => $headers,
            'form_params' => $parameters,
            'verify' => true
        ]);

        return $this->decodeResult(
            $response->getBody()->getContents()
        );
    }

    protected function sendRequestGet(string $method, bool $isPublic): array
    {
        $response = $this->client->get($this->buildUrl($method, $isPublic));

        return $this->decodeResult(
            $response->getBody()->getContents()
        );
    }
}