<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\Page;
use App\Entity\Common\Variable;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use YandexCheckout\Helpers\UUID;

/**
 * Class AboutPageController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class AboutPageController extends CrudController
{
    public function updatePage(Request $request)
    {
        foreach ($request->except(['_token', '_method', 'slug']) as $key => $value) {
            Variable::where('key', $key)->update(['value' => $value]);
        }

        Page::where('type', Page::TYPE_ABOUT_PAGE)->update(['slug' => $request->get('slug')]);

        /**
         * @var UploadedFile $file */
        foreach ($request->allFiles() as $key => $file) {
            $name = UUID::v4() . '.' . $file->getClientOriginalExtension();
            $res = $file->storePubliclyAs('images', $name, ['disk' => 'full_public']);

            Variable::where('key', $key)->update(['value' => 'images/' . $name]);
        }

        return redirect()->back();
    }

    public function editPage()
    {
        $variables = Variable::aboutPage()->get()->keyBy('key')->pluck('value', 'key');
        $slug = Page::where('type', Page::TYPE_ABOUT_PAGE)->first()->slug;

        return view('admin.main.about', [
            'crud' => $this->crud,
            'slug' => $slug,
            'data' => $variables,
            'fields' => []
        ]);
    }
}
