<?php

namespace App\Http\Controllers;

use App\City;
use App\Customer;
use App\Http\Requests\FormCustomerRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */



    public function index()

    {

        $customers = Customer::paginate(5);

        $cities = City::all();

        return view('customers.list', compact('customers', 'cities'));

    }


    public function search(Request $request)

    {

        $keyword = $request->input('keyword');

        if (!$keyword) {

            return redirect()->route('customers.index');

        }

        $customers = Customer::where('name', 'LIKE', '%' . $keyword . '%')

            ->paginate(5);


        $cities = City::all();

        return view('customers.list', compact('customers', 'cities'));


    }




    public function filterByCity(Request $request){
        $idCity = $request->input('city_id');

        //kiem tra city co ton tai khong
        $cityFilter = City::findOrFail($idCity);

        //lay ra tat ca customer cua cityFiler
        $customers = Customer::where('city_id', $cityFilter->id)->get();
        $totalCustomerFilter = count($customers);
        $cities = City::all();

        return view('customers.list', compact('customers', 'cities', 'totalCustomerFilter', 'cityFilter'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create(){
        $cities = City::all();

        return view('customers.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $customer = new Customer();
        $customer->name     = $request->input('name');
        $customer->email    = $request->input('email');
        $customer->dob      = $request->input('dob');
        $customer->city_id  = $request->input('city_id');
        $customer->save();

        //tao moi xong quay ve trang danh sach khach hang
        return redirect()->route('customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $customer = Customer::findOrFail($id);
        $cities = City::all();

        return view('customers.edit', compact('customer', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $customer = Customer::findOrFail($id);
        $customer->name     = $request->input('name');
        $customer->email    = $request->input('email');
        $customer->dob      = $request->input('dob');
        $customer->city_id  = $request->input('city_id');
        $customer->save();

        //dung session de dua ra thong bao
        Session::flash('success', 'Cập nhật khách hàng thành công');

        //cap nhat xong quay ve trang danh sach khach hang
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

//dung session de dua ra thong bao
        Session::flash('success', 'Xóa khách hàng thành công');

//xoa xong quay ve trang danh sach khach hang
        return redirect()->route('customers.index');
    }

    public function checkValidation(FormCustomerRequest $request)
    {
        $success = "Dữ liệu được xác thực thành công";
        return view('welcome', compact('success'));
    }
}
