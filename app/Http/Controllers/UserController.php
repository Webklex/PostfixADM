<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUserCreateRequest;
use App\Http\Requests\PostUserUpdateRequest;
use App\Models\Domain;
use App\Models\User;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $aUser = User::paginate(10);
        return view('user.index', [
            'aUser' => $aUser
        ]);
    }

    public function getCreate() {
        $aDomain = Domain::available();

        return view('user.create', [
            'aDomain' => $aDomain
        ]);
    }

    public function postCreate(PostUserCreateRequest $request) {
        /** @var User $mUser */
        $mUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $mUser->super_user = $request->get('super_user') == true ? 1 : 0;
        $mUser->save();

        return redirect()->to('/user');
    }

    public function getUpdate($id) {
        /** @var User $mUser */
        $mUser = User::with(['domains'])->findOrFail($id);
        $aDomain = Domain::all();

        return view('user.update', [
            'aDomain' => $aDomain,
            'mUser' => $mUser,
        ]);
    }

    public function postUpdate($id, PostUserUpdateRequest $request) {

        /** @var User $mUser */
        $mUser = User::findOrFail($id);
        $mUser->update($request->except(['super_user', 'password']));


        if($request->has('password')){
            $mUser->password = bcrypt($request->get('password'));
        }

        $mUser->super_user = $request->get('super_user') == true ? 1 : 0;

        $mUser->save();

        return $this->getUpdate($mUser->id);
    }

    public function getDelete($id) {
        /** @var User $mUser */
        $mUser = User::findOrFail($id);

        $mUser->delete();

        return redirect()->to('/user');
    }

    public function toggleDomain($id, $domain){

        /** @var User $mUser */
        $mUser = User::findOrFail($id);
        $aDomain = $mUser->domains()->get()->keyBy('id');

        /** @var Domain $mDomain */
        $mDomain = Domain::findOrFail($domain);

        if($aDomain->contains($mDomain->id)){
            $aDomain->forget($mDomain->id);
            $status = 'removed';
        }else{
            $aDomain->put($mDomain->id, $mDomain);
            $status = 'added';
        }

        $mUser->domains()->sync($aDomain->pluck('id'));

        return response()->json(['status' => 'success - '.$status]);
    }
}
