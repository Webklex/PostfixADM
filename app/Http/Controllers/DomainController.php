<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDomainCreateRequest;
use App\Http\Requests\PostDomainUpdateRequest;
use App\Models\Domain;
use App\Models\Log;

class DomainController extends Controller {

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
        $aDomain = Domain::availableQuery()->paginate(10);
        return view('domain.index', [
            'aDomain' => $aDomain
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate() {
        $aDomain = Domain::available();

        return view('domain.create', [
            'aDomain' => $aDomain
        ]);
    }

    /**
     * @param PostDomainCreateRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCreate(PostDomainCreateRequest $request) {
        /** @var Domain $mDomain */
        $mDomain = new Domain();
        $mDomain->name = $request->get('name');
        $mDomain->active = 1;
        $mDomain->save();
        $mDomain->users()->attach(auth()->user()->id);
        $mDomain->save();

        Log::log('Domain "'.$mDomain->name.'" created');

        return $this->getUpdate($mDomain->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($id) {
        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        return view('domain.update', [
            'mDomain' => $mDomain
        ]);
    }

    /**
     * @param $id
     * @param PostDomainUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate($id, PostDomainUpdateRequest $request) {

        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        $mDomain->name = $request->get('name');
        $mDomain->active = $request->get('active') == true ? 1 : 0;
        $mDomain->save();

        Log::log('Domain "'.$mDomain->name.'" updated');

        return redirect()->to('/domain');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id) {
        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        Log::log('Domain "'.$mDomain->name.'" deleted');
        $mDomain->delete();

        return redirect()->to('/domain');
    }
}