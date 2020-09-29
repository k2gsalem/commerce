<?php

namespace App\Http\Controllers\Api\Profile;

use App\Entities\Profile\UserAddress;
use App\Http\Controllers\Controller;
use App\Transformers\Profile\UserAddressTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(UserAddress $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new UserAddressTransformer());
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
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;

        $rules = [
            'user_id'=>'required|integer|exists:users,id',
            'user_name'=>'required|string|max:250',
            'user_contact'=>'required|numeric|digits:10',
            'address_st1'=>'required|string|max:250',
            'address_st2'=>'string|max:250',
            'landmark'=>'string|max:250',
            'area'=>'string|max:250',
            'city_town'=>'string|max:250',
            'state'=>'string|max:250',
            'pincode'=>'regex:^[1-9][0-9]{5}$',
            
        ];

        $this->validate($request, $rules);
        $userAddress = $this->model->create($request->all());
        return $this->response->created(url('api/users/address' . $userAddress->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Profile\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userAddress)
    {
        return $this->response->item($userAddress, new UserAddressTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Profile\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        $request['updated_by'] = $request->user()->id;

        $rules = [
            
            'user_id'=>'required|integer|exists:users,id',
            'user_name'=>'required|string|max:250',
            'user_contact'=>'required|numeric|digits:10',
            'address_st1'=>'required|string|max:250',
            'address_st2'=>'string|max:250',
            'landmark'=>'string|max:250',
            'area'=>'string|max:250',
            'city_town'=>'string|max:250',
            'state'=>'string|max:250',
            'pincode'=>'regex:/^[1-9][0-9]{5}$/',
            
        ];
        
        if ($request->method() == 'PATCH') {
            $rules = [
                'user_id'=>'sometimes|required|integer|exists:users,id',
                'user_name'=>'sometimes|required|string|max:250',
                'user_contact'=>'sometimes|required|numeric|digits:10',
                'address_st1'=>'sometimes|required|string|max:250',
                'address_st2'=>'sometimes|string|max:250',
                'landmark'=>'sometimes|string|max:250',
                'area'=>'sometimes|string|max:250',
                'city_town'=>'sometimes|string|max:250',
                'state'=>'sometimes|string|max:250',
                'pincode'=>'sometimes|regex:/^[1-9][0-9]{5}$/',
                
            ];
           
        }
        $this->validate($request, $rules);
        $userAddress->update($request->except('created_by'));
        return $this->response->item($userAddress->fresh(), new UserAddressTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Profile\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();
        return $this->response->noContent();
        //
    }
}
