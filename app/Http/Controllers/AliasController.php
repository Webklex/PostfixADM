<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostAliasCreateRequest;
use App\Http\Requests\PostAliasUpdateRequest;
use App\Models\Domain;
use App\Models\Alias;

class AliasController extends Controller {

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
        $aAlias = Alias::whereHas('domain', function($q){
            $q->whereIn('id', Domain::available()->pluck('id'));
        })->paginate(10);
        return view('alias.index', [
            'aAlias' => $aAlias
        ]);
    }

    public function getCreate() {
        $aDomain = Domain::available();

        return view('alias.create', [
            'aDomain' => $aDomain
        ]);
    }

    public function postCreate(PostAliasCreateRequest $request) {
        /** @var Alias $mAlias */
        $mDomain = Domain::getAvailable($request->get('domain_id'));
        if($mDomain == null) abort(404);

        $mAlias = Alias::create([
            'domain_id'     => $request->get('domain_id'),
            'source'        => $request->get('source'),
            'destination'   => implode(',', $request->get('destination'))
        ]);
        $mAlias->save();

        return redirect()->to('/alias');
    }

    public function getUpdate($id) {
        /** @var Alias $mAlias */
        $mAlias  = Alias::findOrFail($id);
        $aDomain = Domain::available();

        return view('alias.update', [
            'mAlias' => $mAlias,
            'aDomain' => $aDomain
        ]);
    }

    public function postUpdate($id, PostAliasUpdateRequest $request) {

        /** @var Alias $mAlias */
        $mAlias = Alias::findOrFail($id);
        $mAlias->update($request->all());

        return $this->getUpdate($mAlias->id);
    }

    public function getDelete($id) {
        /** @var Alias $mAlias */
        $mAlias = Alias::findOrFail($id);

        $mAlias->delete();

        return redirect()->to('/alias');
    }
}
