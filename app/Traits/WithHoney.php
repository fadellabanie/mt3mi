<?php

namespace App\Traits;

trait WithHoney
{
    public $hg_name;
    public $hg_time;

    public function mountWithHoney()
    {
        $this->hg_name = null;
        $this->hg_time = microtime(true);
    }

    public function getHoneyPassedProperty()
    {
        return abort_if($this->detect(), 422);
    }

    public function honeyPasses()
    {
        return $this->honeyPassed;
    }

    public function enabled()
    {
        return config('honeypot.enabled');
    }

    public function detect()
    {
        if (!$this->enabled()) {
            return false;
        }

        if (!is_null($this->hg_name)) {
            return true;
        }

        if ($this->submittedTooQuickly()) {
            return true;
        }

        return false;
    }

    protected function submittedTooQuickly()
    {
        $timeToSubmit = microtime(true) - $this->hg_time;

        return $timeToSubmit <= config('honeypot.minimum_time');
    }
}