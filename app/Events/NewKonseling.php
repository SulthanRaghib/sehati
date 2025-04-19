<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewKonseling implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $konseling;
    /**
     * Create a new event instance.
     */
    public function __construct($konseling)
    {
        $this->konseling = $konseling;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('konseling-baru')
        ];
    }

    public function broadcastAs()
    {
        return 'konseling-baru';
    }

    public function broadcastWith(): array
    {
        // Log::info('Data yang dikirim ke pusher:', $this->konseling);
        return [
            'konseling' => $this->konseling,
        ];
        // return [
        //     'id' => $this->konseling->id,
        //     'title' => $this->konseling->title,
        //     'body' => $this->konseling->body,
        //     'is_read' => $this->konseling->is_read,
        // ];
    }
}
