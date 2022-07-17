<?php

namespace App\Http\Controllers;

use App\Models\Country;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('countries-list');
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
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|unique:countries',
            'capital_city' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            $country = new Country();
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if (!$query) {
                return response()->json(['code' => 400, 'message' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 200, 'message' => 'New Country has been successfully saved']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Country::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="d-flex justify-content-center">
                            <button class="btn btn-sm btn-primary me-2" data-id="' . $row['id'] . '" id="editCountryBtn"><i
                            class="bi bi-pencil me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteCountryBtn"><i
                            class="bi bi-trash me-1"></i>Delete</button>
                        </div>';
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="country_checkbox" data-id="' . $row['id'] . '"><label></label>';
            })

            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }

    public function edit(Request $request)
    {
        $country_id = $request->country_id;
        $countryDetails = Country::find($country_id);
        return response()->json(['details' => $countryDetails]);
    }

    public function update(Request $request)
    {
        $country_id = $request->cid;

        $validator = Validator::make($request->all(), [
            'country_name' => 'required|unique:countries,country_name,' . $country_id,
            'capital_city' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'error' => $validator->errors()->toArray()]);
        } else {

            $country = Country::find($country_id);
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if ($query) {
                return response()->json(['code' => 200, 'message' => 'Country Details have Been updated']);
            } else {
                return response()->json(['code' => 400, 'msg' => 'Something went wrong']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $country_id = $request->country_id;
        $query = Country::find($country_id)->delete();

        if($query){
            return response()->json(['code'=>200, 'message'=>'Country has been deleted from database']);
        }else{
            return response()->json(['code'=>400, 'message'=>'Something went wrong']);
        }
    }
}
