<?php

namespace derywat\events;

use Closure;

trait EventsReceiverTrait {

	protected $eventHandlerClosures = array();

	public function addEventHandlerClosure(Closure $eventHandlerClosure):static {
		$this->eventHandlerClosures[] = $eventHandlerClosure;
		return $this;
	}

	public function eventHandler(EventInterface $event):void {
		foreach($this->eventHandlerClosures as $closure){
			$closure($event);
		}
	}

}