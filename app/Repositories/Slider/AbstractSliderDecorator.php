<?php

namespace Fully\Repositories\Slider;

/**
 * Class AbstractSliderDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractSliderDecorator implements SliderInterface
{
    /**
     * @var SliderInterface
     */
    protected $slider;

    /**
     * @param SliderInterface $slider
     */
    public function __construct(SliderInterface $slider)
    {
        $this->slider = $slider;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->slider->all();
    }
}
