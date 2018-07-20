<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 4:12 PM
 */

namespace App\Events;


use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class OrderCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * OrderCreateEvent constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
