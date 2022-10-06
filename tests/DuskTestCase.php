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
        if (! static::runningInSail()) {
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

        self::withBrowserStackCapabilities($capabilities);

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

    protected static function withBrowserStackCapabilities(DesiredCapabilities $caps): DesiredCapabilities
    {
        if (! static::hasBrowserStackKey()) {
            return $caps;
        }

        $caps->setCapability('bstack:options', [
            // 'os' => 'Windows',
            // 'osVersion' => '10',
            'projectName' => self::getProjectName(),
            'buildName' => self::getBuildName(),
            'seleniumVersion' => '4.0.0',
        ]);

        if ($bsLocalID = env('BROWSERSTACK_LOCAL_IDENTIFIER')) {
            $caps
                ->setCapability('browserstack.local', true)
                ->setCapability('browserstack.localIdentifier', $bsLocalID);
        }

        // $caps->setCapability('browserVersion', '100.0');

        return $caps;
    }

    /**
     * Get build name
     *
     * @return string
     */
    private static function getBuildName(): string
    {
        if ($build = ($_SERVER['BROWSERSTACK_BUILD_NAME'] ?? $_ENV['BROWSERSTACK_BUILD_NAME'] ?? null)) {
            return $build;
        }

        return \exec('echo "$(git branch --show-current)-$(git rev-parse --short HEAD)"');
    }

    /**
     * Get project name
     *
     * @return string
     */
    private static function getProjectName(): string
    {
        if ($project = env('BROWSERSTACK_PROJECT_NAME')) {
            return $project;
        }

        return \substr(\exec('git remote get-url origin'), 15, -4);
    }

    protected static function getDriverURL()
    {
        if (static::hasBrowserStackKey()) {
            return 'https://'.env('BROWSERSTACK_USERNAME').':'.env('BROWSERSTACK_ACCESS_KEY').'@hub.browserstack.com/wd/hub';
        }

        return env('DUSK_DRIVER_URL', 'http://localhost:9515');
    }

    protected static function createServerProcess()
    {
        return (new Process([PHP_BINARY, 'artisan', 'serve', '--env=testing']))
            ->setWorkingDirectory(realpath(__DIR__.'/../'))
            ->setTimeout(null);
    }
}
