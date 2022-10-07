<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Support\SupportsBrowserStack;

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

        $driver = RemoteWebDriver::create(
            $this->getDriverURL(),
            $this->withBrowserStackCapabilities($capabilities)
        );

        return $this->prepareBrowserStackSession($driver);
    }

    /**
     * @param  Collection<int, Browser>  $browsers
     * @return void
     */
    protected function storeSourceLogsFor($browsers)
    {
        parent::storeSourceLogsFor($browsers);

        $browsers->each(fn (Browser $browser) => $this->executeScript($browser->driver, [
            'action' => 'setSessionStatus',
            'arguments' => ['status' => 'failed'],
        ]));
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
