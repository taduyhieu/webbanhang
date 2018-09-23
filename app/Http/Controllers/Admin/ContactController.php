<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use Response;
use DB;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Contact\ContactInterface;
use Fully\Repositories\Contact\ContactRepository as Contact;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class ContactController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ContactController extends Controller
{
    protected $contact;
    protected $perPage;

    public function __construct(ContactInterface $contact)
    {
        View::share('active', 'modules');
        $this->contact = $contact;
        $this->perPage = config('fully.modules.contact.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pagiData = $this->contact->paginate(Input::get('page', 1), $this->perPage, true);
        $contacts = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'company_name'  => 'required|unique:contact,company_name',
            'address'          => 'required',
            'phone_number'       => 'required|numeric',
            'email'   => 'required|email',
        ],[
            'company_name.required' => trans('fully.val_contact_name_req'),
            'name.unique'           => trans('fully.val_contact_name_unique'),
            'address.required'      => trans('fully.val_contact_address_req'),
            'phone_number.required' => trans('fully.val_contact_phone_req'),
            'email.required'        => trans('fully.val_contact_email_req'),
            'email'                 => trans('fully.val_contact_email_format'),
            'numeric'               => trans('fully.val_contact_number'),
        ]);
        try {
            $this->contact->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.contact.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.contact.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contact = $this->contact->find($id);

        return view('backend.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contact = $this->contact->find($id);

        return view('backend.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id,Request $request)
    {   
        $this->validate($request, [
            'company_name'  => 'required',
            'address'          => 'required',
            'phone_number'       => 'required|numeric',
            'email'   => 'required|email',
        ],[
            'company_name.required' => trans('fully.val_contact_name_req'),
            'name.unique'           => trans('fully.val_contact_name_unique'),
            'address.required'      => trans('fully.val_contact_address_req'),
            'phone_number.required' => trans('fully.val_contact_phone_req'),
            'email.required'        => trans('fully.val_contact_email_req'),
            'email'                 => trans('fully.val_contact_email_format'),
            'numeric'               => trans('fully.val_contact_number'),
        ]);
        try {
            $this->contact->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.contact.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.contact.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->contact->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.contact.index');
    }

    public function confirmDestroy($id)
    {
        $contact = $this->contact->find($id);

        return view('backend.contact.confirm-destroy', compact('contact'));
    }

    public function togglePublish($id)
    {
        return $this->contact->togglePublish($id);
    }
}
