<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDomainCreateRequest;
use App\Http\Requests\PostDomainUpdateRequest;
use App\Models\Domain;

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

    public function getCreate() {
        $aDomain = Domain::available();

        return view('domain.create', [
            'aDomain' => $aDomain
        ]);
    }

    public function postCreate(PostDomainCreateRequest $request) {
        /** @var Domain $mDomain */
        $mDomain = Domain::create($request->all());
        $mDomain->users()->attach(auth()->user()->id);
        $mDomain->active = 1;
        $mDomain->save();

        return $this->getUpdate($mDomain->id);
    }

    public function getUpdate($id) {
        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        return view('domain.update', [
            'mDomain' => $mDomain
        ]);
    }

    public function postUpdate($id, PostDomainUpdateRequest $request) {

        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        $mDomain->update($request->except('active'));
        $mDomain->active = $request->get('active') == true ? 1 : 0;
        $mDomain->save();

        return redirect()->to('/domain');
    }

    public function getDelete($id) {
        /** @var Domain $mDomain */
        $mDomain = Domain::getAvailable($id);
        if($mDomain == null) abort(404);

        $mDomain->delete();

        return redirect()->to('/domain');
    }
}
