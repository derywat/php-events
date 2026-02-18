<?php

namespace derywat\events;

trait EventsProducerTrait {

	protected $eventsReceivers = array();

	public function registerEventReceiver(EventsReceiverInterface $eventsReceiver):void {
		$this->eventsReceivers[] = $eventsReceiver;
	}

	public function registerEventReceivers($eventsReceivers):void {
		foreach($eventsReceivers as $eventsReceiver){
			$this->registerEventReceiver($eventsReceiver);
		}
	}

	protected function reportEvent(EventInterface $event){
		foreach($this->eventsReceivers as $receiver){
			$receiver->eventHandler($event);
		}
	}

	protected function getRegisteredEventReceivers(){
		return $this->eventsReceivers;
	}

}
