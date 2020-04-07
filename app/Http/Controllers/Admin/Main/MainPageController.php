<?php

namespace App\Http\Controllers\Admin\Main;

use App\Entity\Common\Variable;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use YandexCheckout\Helpers\UUID;

/**
 * Class CommonVariablesController
 * @package App\Http\Controllers\Admin\Main
 * @property-read CrudPanel $crud
 */
class MainPageController extends CrudController
{
    public function updateMainPage(Request $request)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Variable::where('key', $key)->update(['value' => $value]);
        }

        /**
         * @var UploadedFile $file */
        foreach ($request->allFiles() as $key => $file) {
            $name = UUID::v4() . '.' . $file->getClientOriginalExtension();
            $res = $file->storePubliclyAs('images', $name, ['disk' => 'full_public']);

            Variable::where('key', $key)->update(['value' => 'images/' . $name]);
        }

        return redirect()->back();
    }

    public function editMainPage()
    {
        $variables = Variable::mainPage()->get()->keyBy('key')->pluck('value', 'key');
        //dd($variables->toArray());

        return view('admin.main.index', [
            'crud' => $this->crud,
            'data' => $variables,
            'fields' => []
        ]);
    }
}
