<?php

namespace App\Helpers\Services\Infrastructure\Seo;

use Backpack\CRUD\CrudPanel;
use Illuminate\Database\Schema\Blueprint;

class SeoHelper
{
    const FIELD_META_TITLE = 'meta_title';
    const FIELD_META_DESCRIPTION = 'meta_description';
    const FIELD_META_KEYWORDS = 'meta_keywords';
    const FIELD_SEO_TEXT = 'seo_text';
    const FIELD_BREADCRUMB_NAME = 'breadcrumb_name';

    public static function getSeoTypes(): array
    {
        return [
            self::FIELD_BREADCRUMB_NAME,
            self::FIELD_META_TITLE,
            self::FIELD_META_KEYWORDS,
            self::FIELD_SEO_TEXT,
            self::FIELD_META_DESCRIPTION,
        ];
    }

    public static function migration(Blueprint &$table, $except = [])
    {
        $fields = array_diff(static::getSeoTypes(), $except);

        array_map(function ($field) use(&$table) {
            if($field === static::FIELD_SEO_TEXT) {
                $table->text($field)->nullable();
            } else {
                $table->string($field)->nullable();
            }
        }, $fields);
    }

    public static function rollbackMigration(Blueprint &$table, $except = [])
    {
        $fields = array_diff(static::getSeoTypes(), $except);

        array_map(function ($field) use(&$table) {
            $table->removeColumn($field);
        }, $fields);
    }

    public static function controller(CrudPanel &$crud, $except = [])
    {
        $fields = [
            ['name' => self::FIELD_META_TITLE,       'label' => 'Meta Title',       'type' => 'text', 'tab' => 'Meta-теги'],
            ['name' => self::FIELD_META_DESCRIPTION, 'label' => 'Meta Description', 'type' => 'textarea', 'tab' => 'Meta-теги'],
            ['name' => self::FIELD_META_KEYWORDS,    'label' => 'Meta Keywords',    'type' => 'text', 'tab' => 'Meta-теги'],
            ['name' => self::FIELD_BREADCRUMB_NAME,  'label' => 'Breadcrumb name',  'type' => 'text', 'tab' => 'Meta-теги'],
            [
                'name'  => self::FIELD_SEO_TEXT,
                'type'  => 'ckeditor',
                'label' => 'Сео текст',
                'tab'   => 'Meta-теги',
                'simplemdeAttributes' => [
                    'spellChecker' => false,
                    'forceSync' => true,
                ],
            ]
        ];
        $crud->addFields(array_filter(
            array_map(function($field) use($except) {
                if(in_array($field['name'], $except)) {
                    return;
                }

                return $field;
            }, $fields)
        ));
    }

    public static function validationRules($except = [])
    {
        return array_diff_assoc([
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
            'breadcrumb_name' => 'nullable|max:255',
            'seo_text' => 'nullable',
        ], $except);
    }
}
