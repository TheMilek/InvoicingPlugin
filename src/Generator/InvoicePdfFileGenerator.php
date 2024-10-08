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

namespace Sylius\InvoicingPlugin\Generator;

use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Sylius\InvoicingPlugin\Model\InvoicePdf;
use Symfony\Component\Config\FileLocatorInterface;

final class InvoicePdfFileGenerator implements InvoicePdfFileGeneratorInterface
{
    public function __construct(
        private TwigToPdfGeneratorInterface $twigToPdfGenerator,
        private FileLocatorInterface $fileLocator,
        private InvoiceFileNameGeneratorInterface $invoiceFileNameGenerator,
        private string $template,
        private string $invoiceLogoPath
    ) {
    }

    public function generate(InvoiceInterface $invoice): InvoicePdf
    {
        $filename = $this->invoiceFileNameGenerator->generateForPdf($invoice);

        $pdf = $this->twigToPdfGenerator->generate(
            $this->template,
            [
                'invoice' => $invoice,
                'channel' => $invoice->channel(),
                'invoiceLogoPath' => $this->fileLocator->locate($this->invoiceLogoPath),
            ],
        );

        return new InvoicePdf($filename, $pdf);
    }
}
