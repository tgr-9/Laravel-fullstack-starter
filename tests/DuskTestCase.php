<?php

namespace Tests;

use Creasi\Laravel\SupportsBrowserStack;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;
    use SupportsBrowserStack;

    /**
     * @var \Symfony\Component\Process\Process
     */
    protected static $webServerProc;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     *
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail() && ! static::hasBrowserStackKey()) {
            static::startChromeDriver();
        }

        // static::$webServerProc = static::createServerProcess();
        // static::$webServerProc->start();

        // static::afterClass(function () {
        //     if (static::$webServerProc) {
        //         static::$webServerProc->stop();
        //     }
        // });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--start-maximized',
        ])->unless($this->headlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
            ]);
        })->all());

        $capabilities = DesiredCapabilities::chrome()
            ->setCapability(ChromeOptions::CAPABILITY, $options);

        return RemoteWebDriver::create(
            $this->getDriverURL(),
            $this->withBrowserStackCapabilities($capabilities)
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function headlessDisabled()
    {
        if (static::hasBrowserStackKey()) {
            return true;
        }

        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) || isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }
}
