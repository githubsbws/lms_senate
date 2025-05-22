<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class FileUploadProgress implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $fileId;
    public $index;
    public $progress;

    public function __construct($fileId,$index, $progress)
    {
        $this->fileId = $fileId;
        $this->index = $index;
        $this->progress = $progress;
    }

    public function broadcastOn()
    {
        return [
            new Channel('file-upload.' . $this->fileId),   // ช่องเฉพาะไฟล์
            new Channel('file-upload-all')                 // ช่องรวมทุกไฟล์
        ];
    }

    public function broadcastAs()
    {
        return 'FileUploadProgress';
    }
}