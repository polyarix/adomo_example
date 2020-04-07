<?php

if(!function_exists('markdown_render'))
{
    function markdown_render($html)
    {
        return \Mews\Purifier\Facades\Purifier::clean(\Illuminate\Mail\Markdown::parse($html), [
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src|style]',
        ]);
    }
}

if(!function_exists('markdown_render'))
{
    function markdown_render($html)
    {
        return \Mews\Purifier\Facades\Purifier::clean(\Illuminate\Mail\Markdown::parse($html), [
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src|style]',
        ]);
    }
}

if(!function_exists('normalize_status'))
{
    function normalize_status($status)
    {
        switch ($status) {
            case 1: return 'Ужасно';
            case 2: return 'Плохо';
            case 3: return 'Нормально';
            case 4: return 'Хорошо';
            case 5: return 'Отлично';
        }

        return 'undefined status';
    }
}

if(!function_exists('get_user_role'))
{
    function get_user_role(\App\Entity\User\User $user)
    {
        if($user->isCustomer()) {
            return 'Заказчик';
        }

        return $user->workData->isBrigade() ? 'Бригада' : 'Исполнитель';
    }
}

if(!function_exists('meta_title_helper'))
{
    function meta_title_helper($value = null, $default = null)
    {
        return $value ? $value : $default;
    }
}

if(!function_exists('meta_description_renderer'))
{
    function meta_description_renderer($description)
    {
        return view('app._partials._meta_description', compact('description'));
    }
}

if(!function_exists('meta_keywords_renderer'))
{
    function meta_keywords_renderer($keywords)
    {
        return view('app._partials._meta_keywords', compact('keywords'));
    }
}

if(!function_exists('meta_helper_renderer'))
{
    function meta_helper_renderer($model)
    {
        return view('app._partials._meta_base', compact('model'));
    }
}

if(!function_exists('main_config'))
{
    function main_config($key, $default = null)
    {
        $list = app(\App\Service\Main\Config\CommonConfigLoader::class);

        $value = $default;
        if(isset($list[$key])) {
            $value = $list[$key]['value'];
        }

        return $value;
    }
}

if(!function_exists('slug_config'))
{
    function slug_config($key, $default = null)
    {
        $list = app(App\Service\Main\Config\SlugsLoader::class);

        $value = $default;
        if(isset($list[$key])) {
            $value = $list[$key]['slug'];
        }

        return $value;
    }
}

if(!function_exists('custom_config'))
{
    function custom_config($type, $key, $default = null)
    {
        $list = \App\Entity\Common\Variable::where('type', $type)->keyBy('key');

        $value = $default;
        if(isset($list[$key])) {
            $value = $list[$key]['value'];
        }

        return $value;
    }
}

if(!function_exists('image_to_base64'))
{
    function image_to_base64($path = null)
    {
        $storage = \Illuminate\Support\Facades\Storage::disk('public');

        if(!$path || !$storage->exists($path)) {
            $data = file_get_contents(public_path('img/default_avatar.png'));
        } else {
            $data = $storage->get($path);
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

if(!function_exists('num_decline'))
{
    /**
     * @example num_decline( 4, 'книга, книги, книг' ); // > 4 книги
     * @inheritDoc
     */
    function num_decline( $number, $titles, $param2 = '', $param3 = '' )
    {
        if( $param2 )
            $titles = [ $titles, $param2, $param3 ];

        if( is_string($titles) )
            $titles = preg_split( '/, */', $titles );

        if( empty($titles[2]) )
            $titles[2] = $titles[1]; // когда указано 2 элемента

        $cases = [ 2, 0, 1, 1, 1, 2 ];

        $intnum = abs( intval( strip_tags( $number ) ) );

        return $titles[ ($intnum % 100 > 4 && $intnum % 100 < 20) ? 2 : $cases[min($intnum % 10, 5)] ];
    }
}

if(!function_exists('date_duration'))
{
    function date_duration(\Carbon\Carbon $from, ?\Carbon\Carbon $to = null)
    {
        return \App\Service\User\Common\DatesDuration::getDuration($from, $to);
    }
}

if(!function_exists('sanitize_phone'))
{
    function sanitize_phone($value)
    {
        return preg_replace('/([^0-9]*)/', '', $value);
    }
}

if(!function_exists('localized_date'))
{
    function localized_date(\Carbon\Carbon $date, $format)
    {
        return (new \Jenssegers\Date\Date($date))->format($format);
    }
}

if(!function_exists('about_path'))
{
    function about_path()
    {
        return url(slug_config(\App\Entity\Common\Page::TYPE_ABOUT_PAGE));
    }
}

if(!function_exists('contacts_path'))
{
    function contacts_path()
    {
        return url(slug_config(\App\Entity\Common\Page::TYPE_CONTACTS_PAGE));
    }
}

if(!function_exists('faq_path'))
{
    function faq_path()
    {
        return url(slug_config(\App\Entity\Common\Page::TYPE_FAQ_PAGE));
    }
}

if(!function_exists('userecho_enabled'))
{
    function userecho_enabled()
    {
        return config('services.userecho.enabled', false);
    }
}
