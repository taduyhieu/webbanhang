<?php

namespace Fully\Repositories\Setting;

/**
 * Class AbstractSettingDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
abstract class AbstractSettingDecorator implements SettingInterface
{
    /**
     * @var SettingInterface
     */
    protected $setting;

    /**
     * @param SettingInterface $setting
     */
    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->setting->getSettings();
    }
}
