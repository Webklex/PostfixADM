<?php
/*
* File: BrowserHistory.php
* Category: -
* Author: MSG
* Created: 17.07.17 19:41
* Updated: -
*
* Description:
*  -
*/

namespace App\Libraries\BrowserHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BrowserHistory {

    /** @var Request $request */
    protected $request = null;

    /** @var Collection $history */
    protected $history = [];

    /**
     * BrowserHistory constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->setRequest($request);

        $this->loadHistory();
    }

    /**
     * BrowserHistory deconstructor.
     */
    public function __destruct() {
        $this->save();
    }

    /**
     * Load the current browser history
     */
    protected function loadHistory(){
        $this->history = collect($this->request->session()->get('browser_history', []));
    }

    /**
     * Save the current history
     */
    protected function save(){
        $this->request->session()->put('browser_history', $this->history->toArray());
        $this->request->session()->save();
    }

    /**
     * Redirect to the previous page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back(){
        if($this->history->count() > 1){
            $this->history = $this->history->slice(0, -2);
            $this->save();
            return redirect()->to($this->history->last());
        }
        return redirect()->to('/');
    }

    /**
     * Add a new Uri to the history
     * @param $uri
     *
     * @return $this
     */
    public function addURI($uri){

        if($this->history->last() != $uri){
            $this->history->push($uri);
            $this->save();
        }

        return $this;
    }

    /**
     * Set the Request instance
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request){
        $this->request = $request;
        $this->loadHistory();

        return $this;
    }

    /**
     * Get the current history object
     * @return Collection
     */
    public function getHistory(){
        return $this->history;
    }

}