<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostMailboxCreateRequest;
use App\Http\Requests\PostMailboxUpdateRequest;
use App\Models\Domain;
use App\Models\Mailbox;

class MailboxController extends Controller {

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
        $aMailbox = Mailbox::whereHas('domain', function($q){
            $q->whereIn('id', Domain::available()->pluck('id'));
        })->paginate(10);
        return view('mailbox.index', [
            'aMailbox' => $aMailbox
        ]);
    }

    public function getCreate() {
        $aDomain = Domain::available();

        return view('mailbox.create', [
            'aDomain' => $aDomain
        ]);
    }

    public function postCreate(PostMailboxCreateRequest $request) {
        $mDomain = Domain::getAvailable($request->get('domain_id'));
        if($mDomain == null) abort(404);

        $password = exec('doveadm pw -s SHA512-CRYPT -p '.$request->get('password').' 2>&1');
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::create([
            'quota_kb' => $request->get('quota_kb'),
            'domain_id' => $request->get('domain_id'),
            'password' => $password,
            'email' => $request->get('email').'@'.$mDomain->name,
        ]);

        $mMailbox->active = 1;

        $mMailbox->domain()->associate($mDomain);
        $mMailbox->save();

        return $this->getUpdate($mMailbox->id);
    }

    public function getUpdate($id) {
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::findOrFail($id);

        return view('mailbox.update', [
            'mMailbox' => $mMailbox
        ]);
    }

    public function postUpdate($id, PostMailboxUpdateRequest $request) {

        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::findOrFail($id);
        $mMailbox->update($request->except(['active', 'password']));


        if($request->has('password')){
            $password = exec('doveadm pw -s SHA512-CRYPT -p '.$request->get('password').' 2>&1');
            $mMailbox->password = $password;
        }

        $mMailbox->active = $request->get('active') == true ? 1 : 0;

        $mMailbox->save();

        return $this->getUpdate($mMailbox->id);
    }

    public function getDelete($id) {
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::findOrFail($id);

        $mMailbox->delete();

        return redirect()->to('/mailbox');
    }
}
