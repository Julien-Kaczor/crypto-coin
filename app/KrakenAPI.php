<?php

namespace App;

use App\Kraken\Client;
use GuzzleHttp\Client as HttpClient;

class KrakenAPI
{
    public $keyApi;
    public $secretApi;
    public $krakenClient;

    public $currencyCrypto = ["XXBTZEUR", "XETHZEUR", "XLTCZEUR", "XXRPZEUR"];
    public $nameCrypto = ["XXBTZEUR" => "Bitcoin", "XETHZEUR" => "Ethereum", "XLTCZEUR" => "Litecoin", "XXRPZEUR" => "Ripple"];
    public $nameAsset = ["XXBT" =>  "Bitcoin", "XETH" => "Ethereum", "XLTC" => "Litecoin", "XXRP" => "Ripple"];

    //
    public $nameAssetTmp = ["XXBT" =>  "XXBTZEUR", "XETH" => "XETHZEUR", "XLTC" => "XLTCZEUR", "XXRP" => "XXRPZEUR"];

    public function __construct()
    {
        $this->keyApi = "AgC57HUfE7hsNytq6tT+Gfma9l4QpKqUxJ8+j/tQpMCqqoqRmlYqljeV";
        $this->secretApi = "Q4s+1mbCweF1DW7gLhvdFOStnBK6BLG0zgSnPoQNWqVdjXBOWJn/M9R25bfRWF6M9qCdCsR5MeFn3bGEilcRZg==";

        $this->krakenClient = new Client(new HttpClient(), $this->keyApi, $this->secretApi, null);
        // dd($this->debug());
    }


    public function getBalance()
    {
        $balances = $this->krakenClient->getAccountBalance();
        $data = [];
        $market = $this->getMarket(false)->getOriginalContent();

        foreach ($balances as $balance) {
            $value = $market[$this->nameAssetTmp[$balance->currency()] ?? 0] ?? 0;
            $data[$this->nameAsset[$balance->currency()] ?? "EUR.BALANCE"] = [
                "crypto" => $balance->amount(),
                "devise" => round($balance->amount() * intval($value))
            ];
        }

        $data["EUR.TOTAL"] = round(intval($this->krakenClient->getTradeBalance()["eb"] ?? 0.0));

        return response()->json($data);
    }

    public function getMarket($realName = false)
    {
        $pairs = $this->krakenClient->getAssetPairs($this->currencyCrypto);

        $data = [];

        foreach ($pairs as $pair) {
            if ($realName) {
                $data[$this->nameCrypto[$pair->name()]] = $this->krakenClient->getTradesCurrency($pair->name())[$pair->name()][999][0];
            } else {
                $data[$pair->name()] = $this->krakenClient->getTradesCurrency($pair->name())[$pair->name()][999][0];
            }
        }

        return response()->json($data);
    }

    public function getMarketByMonth()
    {
        $pairs = $this->krakenClient->getAssetPairs($this->currencyCrypto);

        $data = [];

        foreach ($pairs as $pair) {
            $data[$this->nameCrypto[$pair->name()]] = $this->krakenClient->getTradesCurrency($pair->name())[$pair->name()][999][0];
        }


        return response()->json($data);
    }

    public function debug()
    {
        $data = [];
        $allAsset = $this->krakenClient->getAsset();

        foreach ($allAsset as $key => $c) {
            if (!str_contains($c->name(), ".")) {
                $data['pair'][] = $c->name();
                $data['altname'][] = $c->altname();
            }
        }

        dd($data);
    }
}