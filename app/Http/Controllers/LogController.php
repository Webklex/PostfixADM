<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostMailboxCreateRequest;
use App\Http\Requests\PostMailboxUpdateRequest;
use App\Mail\TestMail;
use App\Models\Domain;
use App\Models\Log;
use App\Models\Mailbox;
use Illuminate\Support\Facades\Mail;

class LogController extends Controller {

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
        $aLog = Log::orderBy('created_at', 'DESC')->paginate(10);

        return view('log.index', [
            'aLog' => $aLog
        ]);
    }
}