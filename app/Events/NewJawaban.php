<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewJawaban implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jawaban;
    /**
     * Create a new event instance.
     *
     * @param mixed $jawaban
     */
    public function __construct($jawaban)
    {
        $this->jawaban = $jawaban;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('jawaban-konseling'),
        ];
    }

    public function broadcastAs()
    {
        return 'jawaban-konseling';
    }

    public function broadcastWith(): array
    {
        return [
            'jawaban' => $this->jawaban,
        ];
    }
}
