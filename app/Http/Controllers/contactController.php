<?php

namespace App\Http\Controllers;

use App\Mail\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;

class contactController extends Controller
{
    public function review()
    {
        return View::make("review");
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $contacts = [
            "name" => $request->name,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "review" => $request->review,
        ];
        Contact::create($contacts);
        Mail::to("gabrielarafol.mendoza@tup.edu.ph")->send(
            new contactMail($contacts)
        );
        return back()->with("success", "Feedback Successfully Send");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::withTrashed()->paginate(6);

        if(session(key: 'success_message')){
            Alert::image('Congratulations!',session(key: 'success_message'),'https://media1.giphy.com/media/RlI8KU5ZPym0f1bZoF/giphy.gif?cid=6c09b952413438a6eef5934ef4253170b611937fa7566f75&rid=giphy.gif&ct=s','200','200','I Am A Pic');
        }

        return view("contacts.index", [
            "contacts" => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);
        return Redirect::to("contact")->withSuccessMessage("Contact Data Deleted!");
    }

    public function restore($id)
    {
        Contact::onlyTrashed()
            ->findOrFail($id)
            ->restore();
        return Redirect::route("contact.index")->withSuccessMessage("Contact Data Restored!");
    }

    public function forceDelete($id)
    {
        $contacts = Contact::findOrFail($id);
        $contacts->forceDelete();
        return Redirect::route("contact.index")->withSuccessMessage("Contact Data Permanently Deleted!");
    }
}
