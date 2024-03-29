<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\customerRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use RealRashid\SweetAlert\Facades\Alert;

class customerController extends Controller
{
    public function search()
    {
        $customers = Customer::rightJoin(
            "animals",
            "animals.customer_id",
            "=",
            "customers.id"
        )
            ->rightjoin(
                "transactions",
                "transactions.animal_id",
                "=",
                "animals.id"
            )
            ->leftjoin(
                "services",
                "services.id",
                "=",
                "transactions.service_id"
            )
            ->leftjoin(
                "transactions",
                "transactions.id",
                "=",
                "transactions.transaction_id"
            )
            ->select(
                "customers.first_name",
                "animals.animal_name",
                "services.service_name",
                "services.cost",
                "transactions.id",
                "customers.deleted_at"
            )
            ->orderBy("customers.id", "ASC")
            ->get();
        return view("customers.search", [
            "customers" => $customers,
        ]);
    }

    public function result()
    {
        $result = $_GET["result"];
        $customers = Customer::rightJoin(
            "animals",
            "animals.customer_id",
            "=",
            "customers.id"
        )
            ->rightjoin(
                "transactions",
                "transactions.animal_id",
                "=",
                "animals.id"
            )
            ->leftjoin(
                "services",
                "services.id",
                "=",
                "transactions.service_id"
            )
            ->select(
                "customers.first_name",
                "animals.animal_name",
                "services.service_name",
                "services.cost",
                "transactions.id",
                "customers.deleted_at"
            )

            ->where("customers.first_name", "LIKE", "%" . $result . "%")
            ->get();
        return view("customers.result", [
            "customers" => $customers,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Customers = Customer::leftJoin(
            "animals",
            "customers.id",
            "=",
            "animals.customer_id"
        )
            ->select(
                "Customers.id",
                "Customers.first_name",
                "Customers.last_name",
                "Customers.phone_number",
                "Customers.images",
                "Customers.deleted_at",
                "animals.animal_name"
            )
            ->orderBy("Customers.id", "ASC")
            ->withTrashed()
            ->paginate(6);

        if (session(key: "success_message")) {
            Alert::image(
                "Congratulations!",
                session(key: "success_message"),
                "https://media3.giphy.com/media/tKys00Ye9maGtn9pcq/giphy.gif?cid=ecf05e47knblbh9ucuhl5m1gjveld8lk5g6rt9skhd9ok636&rid=giphy.gif&ct=s",
                "200",
                "200",
                "I Am A Pic"
            );
        }

        return view("customers.index", ["customers" => $Customers]);
        //return view("Customers.index", compact("Customers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make("customers.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(customerRequest $request)
    {
        $Customers = new Customer();
        $Customers->first_name = $request->input("first_name");
        $Customers->last_name = $request->input("last_name");
        $Customers->phone_number = $request->input("phone_number");
        if ($request->hasfile("images")) {
            $file = $request->file("images");
            $filename = uniqid() . "_" . $file->getClientOriginalName();
            $file->move("uploads/customers/", $filename);
            $Customers->images = $filename;
        }
        $Customers->save();
        return Redirect::to("customer")->withSuccessMessage(
            "New Customer Added!"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customers = Customer::leftJoin(
            "animals",
            "customers.id",
            "=",
            "animals.customer_id"
        )
            ->select(
                "customers.id",
                "customers.first_name",
                "customers.last_name",
                "customers.phone_number",
                "customers.images",
                "customers.deleted_at",
                "animals.animal_name"
            )
            ->where('customers.id', $id)
            ->get();

        return View::make('customers.show', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Customers = Customer::find($id);
        return View::make("customers.edit", compact("Customers"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(customerRequest $request, $id)
    {
        $Customers = Customer::find($id);
        $Customers->first_name = $request->input("first_name");
        $Customers->last_name = $request->input("last_name");
        $Customers->phone_number = $request->input("phone_number");
        if ($request->hasfile("images")) {
            $destination = "uploads/customers/" . $Customers->images;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file("images");
            $filename = uniqid() . "_" . $file->getClientOriginalName();
            $file->move("uploads/customers/", $filename);
            $Customers->images = $filename;
        }
        $Customers->update();
        return Redirect::to("customer")->withSuccessMessage(
            "New Customer Updated!"
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);
        return Redirect::to("customer")->withSuccessMessage(
            "New Customer Deleted!"
        );
    }

    public function restore($id)
    {
        Customer::onlyTrashed()
            ->findOrFail($id)
            ->restore();
        return Redirect::route("customer.index")->withSuccessMessage(
            "New Customer Restored!"
        );
    }

    public function forceDelete($id)
    {
        $Customers = Customer::findOrFail($id);
        $destination = "uploads/customers/" . $Customers->images;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $Customers->forceDelete();
        return Redirect::route("customer.index")->withSuccessMessage(
            "New Customer Permanently Deleted!"
        );
    }
}
