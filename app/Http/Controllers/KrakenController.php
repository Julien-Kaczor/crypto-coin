<?php

namespace App\Http\Controllers;

use App\KrakenAPI;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use BeyondCode\LaravelWebSockets\Server\WebSocketServerFactory;
use Illuminate\Http\Request;

class KrakenController extends Controller
{
    public $kraken;

    public function __construct()
    {
        $this->kraken = new KrakenAPI();
        $this->middleware('auth');
    }

    public function getBalance()
    {
        return ($this->kraken->getBalance());
    }


    public function getTradeBalance()
    {
        return ($this->kraken->krakenClient->getTradeBalance());
    }


    public function getMarket()
    {
        return ($this->kraken->getMarket());
    }
}