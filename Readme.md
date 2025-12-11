# PHP library for sending and receiving events.

Library allows to send events from class to all registered receivers.

## Sending event from class

### Define custom event class

Example class implements sending string message.

```php
use derywat\events\EventInterface;

class MyCustomEventClass implements EventInterface {

	protected $message;

	public function __construct(string $message){
		$this->message = $message;
	}

	public function __tostring(): string {
		return "{$this->message}";
	}

}
```

### Send event

Use custom event class to report event to all receivers.

```php
use derywat\events\EventsProducerInterface;
use derywat\events\EventsProducerTrait;

class MyClass implements EventsProducerInterface {
	use EventsProducerTrait;

	protected function myMethodWithEvent(){
		//report event
		$this->reportEvent(new MyCustomEventClass("message to send in event"));
	}
}
```
## Receiving events

### Receiving events in class

Events may be received in any class by implementing EventsReceiverInterface.

```php
use derywat\events\EventsReceiverInterface;

class MyEventReceivingClass implements EventsReceiverInterface {
	
	public function eventHandler(EventInterface $event):void {
		$class = get_class($event);
		switch($class) {  
			case MyCustomEventClass::class:
				//handle events of MyCustomEventClass here
				break;
		}
	}

}
```

Multiple objects of classes implementing EventsReceiverInterface may be added using registerEventReceiver method.

```php

$receiverInstance = new MyEventReceivingClass();
$producerInstance = new MyClass();
//register receiver in producer
$producerInstance->registerEventReceiver($receiverInstance);
```

### Receiving events in closures defined outside of class instance

Adding EventReceiverTrait implements EventsReceiverInterface in any class.  


```php
use derywat\events\EventsReceiverInterface;
use derywat\events\EventReceiverTrait;

class MyEventReceivingClass implements EventsReceiverInterface {
	use EventReceiverTrait;
}
```

Trait implements event handler using event handling closures.
Event handlers are external to class and class instance object.

```php
use derywat\events\EventsReceiver;

$receiverInstance = new MyEventReceivingClass();
$receiverInstance->addEventHandlerClosure(
	function(EventInterface $event):void {
		$class = get_class($event);
		switch($class) {  
			case MyCustomEventClass::class:
				//handle events of MyCustomEventClass here
				break;
		}
	}
);

$producerInstance = new MyClass();
$producerInstance->registerEventReceiver($receiverInstance);
```



### Using EventsReceiver with EventsReceiver object

Event handling can be implemented with instance of predefined EventsReceiver class.

```php
use derywat\events\EventsReceiver;

$producerInstance = new MyClass();

$producerInstance->registerEventReceiver(
	//create instance of EventsReceiver
	(new EventsReceiver())->addEventHandlerClosure(
		function(EventInterface $event):void {
			$class = get_class($event);
			switch($class) {  
    			case MyCustomEventClass::class:
			        //handle events of MyCustomEventClass here
			        break;
			}
		}
	)
);
```

