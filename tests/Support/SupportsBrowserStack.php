<?php

namespace Tests\Support;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Symfony\Component\Process\Process;

trait SupportsBrowserStack
{
    /**
     * Determine if the BrowserStack Key and User is set.
     *
     * @return bool
     */
    private static function hasBrowserStackKey(): bool
    {
        return isset($_SERVER['BROWSERSTACK_ACCESS_KEY']) || isset($_ENV['BROWSERSTACK_ACCESS_KEY']);
    }

    private function prepareBrowserStackSession(RemoteWebDriver $driver): RemoteWebDriver
    {
        $this->afterApplicationCreated(fn () => $this->executeScript($driver, [
            'action' => 'setSessionName',
            'arguments' => ['name' => \class_basename($this)],
        ]));

        $this->beforeApplicationDestroyed(fn () => $this->executeScript($driver, [
            'action' => 'setSessionStatus',
            'arguments' => ['status' => 'passed'],
        ]));

        return $driver;
    }

    private function withBrowserStackCapabilities(DesiredCapabilities $caps): DesiredCapabilities
    {
        if (! static::hasBrowserStackKey()) {
            return $caps;
        }

        $caps->setCapability('bstack:options', [
            // 'os' => 'Windows',
            // 'osVersion' => '10',
            'projectName' => $this->getProjectName(),
            'buildName' => $this->getBuildName(),
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
    private function getBuildName(): string
    {
        $build = env('BROWSERSTACK_BUILD_NAME');

        if ($build && (\strlen($build) > 0 && \strlen($build) <= 255)) {
            return $build;
        }

        return \exec('echo "$(git branch --show-current)-$(git rev-parse --short HEAD)"');
    }

    /**
     * Get project name
     *
     * @return string
     */
    private function getProjectName(): string
    {
        if ($project = env('BROWSERSTACK_PROJECT_NAME')) {
            return $project;
        }

        return \substr(\explode('/', \exec('git remote get-url origin'))[1], 0, -4);
    }

    private function getDriverURL(): string
    {
        if (static::hasBrowserStackKey()) {
            return 'https://'.env('BROWSERSTACK_USERNAME').':'.env('BROWSERSTACK_ACCESS_KEY').'@hub.browserstack.com/wd/hub';
        }

        return env('DUSK_DRIVER_URL', 'http://localhost:9515');
    }

    /**
     * @param  \Facebook\WebDriver\Remote\RemoteWebDriver  $driver
     * @param  array  $command
     * @return void
     */
    private function executeScript($driver, $command): void
    {
        if (! static::hasBrowserStackKey()) {
            return;
        }

        $driver->executeScript('browserstack_executor: '.\json_encode($command));
    }

    private static function createServerProcess()
    {
        return (new Process([PHP_BINARY, 'artisan', 'serve', '--env=testing']))
            ->setWorkingDirectory(realpath(__DIR__.'/../'))
            ->setTimeout(null);
    }
}
