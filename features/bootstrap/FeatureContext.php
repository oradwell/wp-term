<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I execute command :command
     */
    public function iExecuteCommand($command)
    {
        $page = $this->getSession()->getPage();
        $terminalInput = $page->find('css', '.term-input');

        $terminalInput->setValue($command);

        // Enter key
        $this->getSession()->executeScript("
            jQuery('.term-input').trigger(jQuery.Event('keyup', {which: 13, keyCode: 13}));
        ");
    }

    /**
     * @Then I should see the terminal
     */
    public function iShouldSeeTheTerminal()
    {
        $terminal = $this->getTerminal();
        if (!$terminal->isVisible()) {
            throw new ExpectationException(
                'Terminal is not visible, but visible expected.',
                $this->getSession()
            );
        }
    }

    /**
     * @Then I should not see the terminal
     */
    public function iShouldNotSeeTheTerminal()
    {
        $terminal = $this->getTerminal();
        if ($terminal->isVisible()) {
            throw new ExpectationException(
                'Terminal is visible, but invisible expected.',
                $this->getSession()
            );
        }
    }

    private function getTerminal()
    {
        return $this->getSession()
            ->getPage()
            ->find('css', '.terminal');
    }
}
