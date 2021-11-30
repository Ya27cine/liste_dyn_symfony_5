<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class FormSelectCountrySubscriber implements EventSubscriberInterface
{
    

    public static function getSubscribedEvents()
    {
        return [
           // FormEvents::POST_SUBMIT => 'onPreSetData',
            //FormEvents::PRE_SET_DATA => 'onPreSetData',
          //  FormEvents::POST_SUBMIT => 'onPreSetData',
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
      //dd( $field );

       //var_dump( array_key_exists('name', $event->getData() ));
    }
}
