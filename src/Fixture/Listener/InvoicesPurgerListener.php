<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\InvoicingPlugin\Fixture\Listener;

use Sylius\Bundle\FixturesBundle\Listener\AbstractListener;
use Sylius\Bundle\FixturesBundle\Listener\BeforeSuiteListenerInterface;
use Sylius\Bundle\FixturesBundle\Listener\SuiteEvent;
use Symfony\Component\Filesystem\Filesystem;

final class InvoicesPurgerListener extends AbstractListener implements BeforeSuiteListenerInterface
{
    public function __construct(private Filesystem $filesystem, private string $invoicesPath)
    {
    }

    public function beforeSuite(SuiteEvent $suiteEvent, array $options): void
    {
        $this->filesystem->remove($this->invoicesPath);
    }

    public function getName(): string
    {
        return 'invoices_purger';
    }
}
