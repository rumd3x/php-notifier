<?php
namespace Rumd3x\Notifier;

use Rumd3x\BaseObject\BaseObject;
use Rumd3x\Notifier\Interfaces\NotifiableInterface;

class Notification extends BaseObject {

	const NOTIFY_ALL = 0;
	const WATCHING_ONLY = -1;
	
    protected $origin;
    protected $action;
    protected $message;

    public function __construct(NotifiableInterface $origin, $message = NULL) {
        $dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
        $caller = isset($dbt[1]['function']) ? $dbt[1]['function'] : null;
        $this->action = $caller;

        $this->origin = $origin;
        $this->message = $message;
    }

    public function getOrigin(){
		return $this->origin;
	}

	public function setOrigin($origin){
		$this->origin = $origin;
	}

	public function getAction(){
		return $this->action;
	}

	public function setAction($action){
		$this->action = $action;
	}

	public function getMessage(){
		return $this->message;
	}

	public function setMessage($message){
		$this->message = $message;
    }
    
}