<?php

namespace App\Http\Resources\Blog;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            //'content' => $this->content,
            'slug' => $this->slug,
            'views' => $this->views,
            'image' => $this->getPreview(),
            'crop' => $this->getCrop(),
            'main_category' => $this->getMainCategory(),
            'description' => $this->getDescription(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
