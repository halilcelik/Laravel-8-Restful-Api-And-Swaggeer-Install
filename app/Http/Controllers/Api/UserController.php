<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Validator;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
       // return Product::all();
      // return response()->json(Product::all(), 200);
    //  return response(Product::paginate(10), 200);

    $offset = $request->has('offset') ? $request->query('offset') : 0;
    $limit = $request->has('limit') ? $request->query('limit') :  10;

    $qb = User::query();
    if ($request->has('q'))
    $qb->where('name', 'like', '%' . $request->query('q') . '%');

    if ($request->has('sortBy'))
    $qb->orderBy($request->query('sortBy'), $request->query('sort','DESC'));

    $data = $qb->offset($offset)->limit($limit)->get();

    $data->each->setAppends(['full_name']);
    
    return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
         // $input = $request->all();
      //  $product = Product::create($input);
      
      $user = new User;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->save();
      


      return response([
          'data' => $user,
          'message' => 'User created.'
      ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(/*$id*/User $user)

    {
        return $user;
      /*   $user = User::find($id);
        if($user){
            return response($user, 200);
        }else {
            return response(['message' => 'User not found'],404);
        } */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save(); 
        
  
  
        return response([
            'data' => $user,
            'message' => 'User updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            
            'message' => 'User deleted.'
        ], 200);
    }
    public function custom1()
    {
     /*   $user2 = User::find(2);
        return new UserResource($user2);  */

        $users = User::all();
        return UserResource::collection($users); 

       /* $users = User::all();
        return new UserCollection($users);  */
        $users = User::all();
        return UserResource::collection($users)->additional([
            'meta' => [
                'total_users' => $users->count(),
                'custom' => 'value'
            ]
        ]);

    }
}
