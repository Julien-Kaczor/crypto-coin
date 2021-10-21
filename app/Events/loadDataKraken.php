<?php

namespace App\Events;

use App\KrakenAPI;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class loadDataKraken implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $balance;
    public $market;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $idUser)
    {
        $this->id =  $idUser;
        $this->balance = (new KrakenAPI())->getBalance();
        $this->market = (new KrakenAPI())->getMarket();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('get-currency-' . $this->id);
    }
}