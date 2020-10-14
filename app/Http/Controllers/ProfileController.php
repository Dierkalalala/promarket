<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;

class ProfileController extends Controller
{
    public function myprofile()
    {
    	return view('profile.index');
    }

    public function oneOrder()
    {	
    	$order = Order::find(request()->id);

    	return view('profile.user-order', compact('order'));
    }

    public function edit(Request $request)
    {	

    	$user = Auth::user();
    	// dd($user->avatar);
    	$data = $request->all();
	 	if($request->hasfile('avatar')){
	        $avatar = $request->file('avatar');
	        $filename = time() . '.' . $avatar->getClientOriginalExtension();
	        Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename) );
   		 }else{
   		 	$filename = null;
   		 }
   		 $user->update($data);

   		 $user->avatar = $filename;
   		 $save = $user->save();
   		  if($save){
            session()->flash('success','Успешно сохранено!');
        }else{
            session()->flash('error','Случилос ошибка!');
        }

        return redirect()->route('profile.index');
    }

 	public function avatarStore(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/uploads/avatar/'),$imageName);
        $user = Auth::user();
        $path=public_path().'/uploads/avatar/'.$user->avatar;
        if (file_exists($path)) {
            unlink($path);
        }
   		$save = $user->update([
   			'avatar' => $imageName,
   		]);
        return response()->json(['success'=>$imageName]);
    }
}