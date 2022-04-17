<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        return view('pages/customers/customers', [
            "title" => "Customers",
            'active' => 'customers',
            "customers" => Customer::all()
        ]);
    }


    public function addCustomer(Request $request) {
        $customer = new Customer;
        $customer->name = $request->post()['name'];
        $customer->username = $request->post()['username'];
        $customer->numberid = $request->post()['id-number'];
        $customer->email = $request->post()['email'];
        $customer->password = $request->post()['password'];
        $customer->phone = $request->post()['phone'];
        $customer->save();   
        return redirect('customers');
    }

    public function editCustomer(Request $request) {
        $customer = Customer::find($request->post()['id']);
        $customer->name = $request->post()['name'];
        $customer->username = $request->post()['username'];
        $customer->numberid = $request->post()['id-number'];
        $customer->email = $request->post()['email'];
        $customer->password = $request->post()['password'];
        $customer->phone = $request->post()['phone'];
        $customer->save();   
        return redirect('customers');
    }

    public function ActivateCustomer(Request $request)
    {
        $customer = Customer::find($request->query('id'));
        $customer->isActive = true;
        $customer->save();   
        return redirect('customers');
    }

    public function DeactivateCustomer(Request $request)
    {
        $customer = Customer::find($request->query('id'));
        $customer->isActive = false;
        $customer->save();   
        return redirect('customers');
    }

}
