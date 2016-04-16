<?php

class FlexSliderExtension extends Extension
{
    public function onAfterInit()
    {

        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');

        // Flexslider options
        $animate = ($this->owner->Animate) ? 'true' : 'false';
        $animation = '"'.$this->owner->Animation.'"';
        $loop = ($this->owner->Loop) ? 'true' : 'false';
        $sync = ($this->owner->ThumbnailNav == true) ? "#carousel" : '""';
        $before = (method_exists($this->owner->ClassName, 'flexSliderBeforeAction'))
            ? $this->owner->flexSliderBeforeAction()
            : 'function(){}';
        $after = (method_exists($this->owner->ClassName, 'flexSliderAfterAction'))
            ? $this->owner->flexSliderAfterAction()
            : 'function(){}';
        $speed = (method_exists($this->owner->ClassName, 'setFlexSliderSpeed'))
            ? $this->owner->setFlexSliderSpeed()
            : 7000;

        // only call custom script if page has Slides and DataExtension
        if (Object::has_extension($this->owner->data()->ClassName, 'FlexSlider')) {
            if ($this->owner->data()->Slides()->exists()) {
                Requirements::customScript(<<<JS
                  var flexSliderAnimate = {$animate},
                      flexSliderAnimation = {$animation},
                      flexSliderLoop = {$loop},
                      flexSliderSync = {$sync},
                      flexSliderBeforeCallback = {$before},
                      flexSliderAfterCallback = {$after},
                      flexSliderSpeed = {$speed};
JS
                );

                Requirements::javascript(FLEXSLIDER_DIR . '/javascript/init.js');
            }
        }
    }
}
