<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use Symfony\Component\Process\Process;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

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

        static::$webServerProc = static::createServerProcess();
        static::$webServerProc->start();

        static::afterClass(function () {
            if (static::$webServerProc) {
                static::$webServerProc->stop();
            }
        });
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

        if (static::hasBrowserStackKey()) {
            $capabilities
                ->setCapability('browserstack.local', true)
                ->setCapability('browserstack.localIdentifier', env('BROWSERSTACK_LOCAL_IDENTIFIER'))
                ->setCapability('build', env('BROWSERSTACK_BUILD_NAME'))
                ->setCapability('project', env('BROWSERSTACK_PROJECT_NAME'), env('APP_NAME'));
        }

        return RemoteWebDriver::create(static::getDriverURL(), $capabilities);
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

    /**
     * Determine if the BrowserStack Key and User is set.
     *
     * @return bool
     */
    protected static function hasBrowserStackKey()
    {
        return isset($_SERVER['BROWSERSTACK_ACCESS_KEY']) || isset($_ENV['BROWSERSTACK_ACCESS_KEY']);
    }

    protected static function getDriverURL()
    {
        if (static::hasBrowserStackKey()) {
            return 'https://'.env('BROWSERSTACK_USERNAME').':'.env('BROWSERSTACK_ACCESS_KEY').'@hub-cloud.browserstack.com/wd/hub';
        }

        return $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515';
    }

    protected static function createServerProcess()
    {
        return (new Process([PHP_BINARY, 'artisan', 'serve', '--env=testing']))
            ->setWorkingDirectory(realpath(__DIR__.'/../'))
            ->setTimeout(null);
    }
}
