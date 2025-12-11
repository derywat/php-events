<?php

namespace derywat\events;

interface EventsProducerInterface {
	
	public function registerEventReceiver(EventsReceiverInterface $progressConsumer):void;
	
	public function registerEventReceivers($eventsReceivers):void;

}