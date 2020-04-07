<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Advert\Advert\Order;
use App\Entity\Contact\Contact;
use App\Http\Requests\Admin\Contact\RespondRequest;
use App\UseCase\Site\ContactsService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;

/**
 * Class ContactsController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ContactsController extends CrudController
{
    /**
     * @var ContactsService
     */
    private $contactsService;

    public function __construct(ContactsService $contactsService)
    {
        parent::__construct();
        $this->contactsService = $contactsService;
    }

    public function setup()
    {
        $this->crud->setModel(Contact::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contact_requests');
        $this->crud->setEntityNameStrings('contact', 'contacts');

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'Имя'],
            ['name' => 'phone', 'label' => 'Телефон'],
            ['name' => 'email', 'label' => 'Email'],
            ['name' => 'type', 'label' => 'Тип', 'type' => 'select_from_array', 'options' => Contact::getTypesList()],
            ['name' => 'status', 'label' => 'Статус', 'type' => 'select_from_array', 'options' => Contact::getStatusesList()],
            ['name' => 'viewed', 'type' => 'boolean', 'label' => 'Просмотрено', 'options' => ['Нет', 'Да']],
            ['name' => 'created_at', 'label' => 'Дата'],
        ]);

        $this->crud->setRequiredFields(UpdateRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->allowAccess('show');

        $this->crud->addButtonFromView('line', 'contact_form_respond', 'contact_form_respond', 'beginning');
        $this->crud->addButtonFromView('line', 'contact_form_status', 'contact_form_status', 'beginning');

        $this->crud->orderBy(\DB::raw("FIELD(status, '".Contact::STATUS_NEW."')"), 'DESC');
        $this->crud->orderBy(\DB::raw("FIELD(viewed, '".false."')"), 'DESC');
        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->setListView('admin.contact.list');
    }

    public function show($id)
    {
        $this->crud->addColumn(['name' => 'text', 'label' => 'Сообщение']);

        $this->crud->addColumn(['name' => 'created_at', 'type' => 'date', 'label' => 'Дата обращения']);
        $this->crud->addColumn(['name' => 'respond_at', 'type' => 'date', 'label' => 'Дата ответа']);
        $this->crud->addColumn(['name' => 'response_text', 'type' => 'text', 'label' => 'Текст ответа', 'limit' => -1]);

        $content =  parent::show($id);

        return $content;
    }

    // show contact form and text response to user
    public function response(Contact $contact)
    {
        if($contact->isRespond()) {
            \Alert::error('You already respond to this contact message.')->flash();

            return redirect()->back();
        }

        return view('admin.contact.respond', ['crud' => $this->crud, 'entry' => $contact]);
    }

    // send respond to user
    public function respond(Contact $contact, RespondRequest $request)
    {
        try {
            $this->contactsService->respond($contact, $request);

            \Alert::success('Request was successful respond.')->flash();

            return redirect(backpack_url('contact_requests'));
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function view(Contact $contact)
    {
        try {
            $this->contactsService->markViewed($contact);

            \Alert::success('Request was successful mark as viewed.')->flash();

            return redirect(backpack_url('contact_requests'));
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $this->crud->addFields([
            ['name' => 'name', 'type' => 'text', 'label' => 'Имя'],
            ['name' => 'phone', 'type' => 'text', 'label' => 'Телефон'],
            ['name' => 'email', 'type' => 'text', 'label' => 'Email'],
            ['name' => 'text', 'type' => 'text', 'label' => 'Текст'],
        ]);

        return parent::edit($id);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
