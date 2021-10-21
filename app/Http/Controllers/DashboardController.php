<?php

namespace App\Http\Controllers;

use App\CryptoMoney;
use App\Kraken\Facade\Kraken;
use App\KrakenAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $kraken;

    public function __construct()
    {
        $this->kraken = new KrakenAPI();
        $this->middleware('auth');
    }

    public function index()
    {
        $balance = $this->kraken->getBalance()->getOriginalContent();
        $market = $this->kraken->getMarket(true)->getOriginalContent();
        $crypto = CryptoMoney::all();

        return view('back.view.home', compact('balance', 'market', 'crypto'));
    }

    public function welcome()
    {
        return Auth::check() ? $this->index() : view('welcome');
    }
}