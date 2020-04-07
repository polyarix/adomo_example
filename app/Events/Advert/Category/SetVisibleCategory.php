<?php

namespace App\Events\Advert\Category;

use App\Entity\Advert\Category;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SetVisibleCategory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Category
     */
    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
