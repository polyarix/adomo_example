<?php use App\Helpers\Services\Infrastructure\Seo\SeoHelper; ?>

@if($description = $model->{SeoHelper::FIELD_META_DESCRIPTION})
    <meta name="description" content="{{ $description }}">
@endif

@if($keywords = $model->{SeoHelper::FIELD_META_KEYWORDS})
    <meta name="keywords" content="{{ $keywords }}">
@endif

