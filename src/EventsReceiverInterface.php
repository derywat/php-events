<?php

namespace derywat\events;

interface EventsReceiverInterface {

	public function eventHandler(EventInterface $event):void;

}