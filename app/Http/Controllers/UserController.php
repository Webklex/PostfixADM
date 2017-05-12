<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUserCreateRequest;
use App\Http\Requests\PostUserUpdateRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Domain;
use App\Models\Log;
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate() {
        $aDomain = Domain::available();

        return view('user.create', [
            'aDomain' => $aDomain
        ]);
    }

    /**
     * @param PostUserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(PostUserCreateRequest $request) {
        /** @var User $mUser */
        $mUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $mUser->super_user = $request->get('super_user') == true ? 1 : 0;
        $mUser->save();

        Log::log('User "'.$mUser->name.'" created');

        return redirect()->to('/user');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($id) {
        /** @var User $mUser */
        $mUser = User::with(['domains'])->findOrFail($id);
        $aDomain = Domain::all();

        return view('user.update', [
            'aDomain' => $aDomain,
            'mUser' => $mUser,
        ]);
    }

    /**
     * @param $id
     * @param PostUserUpdateRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postUpdate($id, PostUserUpdateRequest $request) {

        /** @var User $mUser */
        $mUser = User::findOrFail($id);
        $mUser->update($request->except(['super_user', 'password']));


        if($request->has('password')){
            $mUser->password = bcrypt($request->get('password'));
        }

        $mUser->super_user = $request->get('super_user') == true ? 1 : 0;

        $mUser->save();
        Log::log('User "'.$mUser->name.'" updated');

        return $this->getUpdate($mUser->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id) {
        /** @var User $mUser */
        $mUser = User::findOrFail($id);

        Log::log('User "'.$mUser->name.'" deleted');
        $mUser->delete();

        return redirect()->to('/user');
    }

    /**
     * @param $id
     * @param $domain
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccount(){

        return view('user.account', [
            'mUser' => realUser(),
            'updated' => false
        ]);
    }

    /**
     * @param UpdateAccountRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateAccount(UpdateAccountRequest $request){

        /** @var User $mUser */
        $mUser = realUser();
        $mUser->password = bcrypt($request->get('password'));
        $mUser->save();

        return view('user.account', [
            'mUser' => $mUser,
            'updated' => true
        ]);
    }
}