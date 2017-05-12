<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostMailboxCreateRequest;
use App\Http\Requests\PostMailboxUpdateRequest;
use App\Mail\TestMail;
use App\Models\Domain;
use App\Models\Log;
use App\Models\Mailbox;
use Illuminate\Support\Facades\Mail;

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
        $aMailbox = Mailbox::whereHasAvailableDomain()->paginate(10);
        return view('mailbox.index', [
            'aMailbox' => $aMailbox
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function test($id){
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::whereHasAvailableDomain()->findOrFail($id);

        Mail::to([$mMailbox->email])->send(new TestMail());

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate() {
        $aDomain = Domain::available();

        return view('mailbox.create', [
            'aDomain' => $aDomain
        ]);
    }

    /**
     * @param PostMailboxCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(PostMailboxCreateRequest $request) {
        $mDomain = Domain::getAvailable($request->get('domain_id'));
        if($mDomain == null) abort(404);

        $encryption = config('postfixadm.encryption.method');
        $password = exec('doveadm pw -s '.$encryption.' -p '.$request->get('password').' 2>&1');
        /** @var Mailbox $mMailbox */
        $mMailbox = new Mailbox();

        if($request->has('quota_kb') == true) $mMailbox->quota_kb  = (int)$request->get('quota_kb');
        $mMailbox->domain    = $mDomain->name;
        $mMailbox->email     = $request->get('email').'@'.$mDomain->name;
        $mMailbox->password  = $password;

        $mMailbox->active = 1;
        $mMailbox->save();

        Log::log('Mailbox "'.$mMailbox->email.'" created');

        return redirect()->to('/mailbox');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($id) {
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::whereHasAvailableDomain()->findOrFail($id);

        return view('mailbox.update', [
            'mMailbox' => $mMailbox
        ]);
    }

    /**
     * @param $id
     * @param PostMailboxUpdateRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postUpdate($id, PostMailboxUpdateRequest $request) {

        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::whereHasAvailableDomain()->findOrFail($id);

        if($request->has('quota_kb') == true) $mMailbox->quota_kb  = (int)$request->get('quota_kb');
        if($request->has('password')){
            $encryption = config('postfixadm.encryption.method');
            $password = exec('doveadm pw -s '.$encryption.' -p '.$request->get('password').' 2>&1');
            $mMailbox->password = $password;
        }

        $mMailbox->active = $request->get('active') == true ? 1 : 0;

        $mMailbox->save();
        Log::log('Mailbox "'.$mMailbox->email.'" updated');

        return $this->getUpdate($mMailbox->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id) {
        /** @var Mailbox $mMailbox */
        $mMailbox = Mailbox::whereHasAvailableDomain()->findOrFail($id);

        Log::log('Mailbox "'.$mMailbox->email.'" deleted');
        $mMailbox->delete();

        return redirect()->to('/mailbox');
    }
}