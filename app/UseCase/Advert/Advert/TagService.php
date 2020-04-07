<?php

namespace App\UseCase\Advert\Advert;

use App\Entity\Advert\Tag;

class TagService
{
    public function findSimilar(Tag $tag, $limit = 5)
    {
        $categories = $tag->categories->pluck('id');

        $tags = \DB::table('category_categories_tags')
            ->select('tag_id')
            ->whereIn('category_id', $categories)
            ->where('tag_id', '!=', $tag->id)
            ->distinct()
            ->limit($limit)
            ->pluck('tag_id')
        ;

        return Tag::whereIn('id', $tags)->get();
    }
}
