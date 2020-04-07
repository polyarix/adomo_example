<?php

namespace App\Events\User\Cabinet;

use App\Entity\User\Portfolio\Album;
use App\Entity\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PortfolioAlbumCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Album
     */
    public $album;
    /**
     * @var User
     */
    public $user;

    public function __construct(Album $album, User $user)
    {
        $this->album = $album;
        $this->user = $user;
    }
}
