<?php
/**
 * This file is part of phpswitch.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\Lighthouse\Console\Command\Phar;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class ExtractCommand extends Command
{
    const NAME = 'phar:extract';
    const DESC = 'Builds phpswitch Phar';

    /**
     * @param string $name
     */
    public function __construct($name = self::NAME)
    {
        parent::__construct($name);

        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Phar filename', 'phpswitch.phar')
            ->addArgument('output', InputArgument::OPTIONAL, 'Output directory', 'phar')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $output = $input->getArgument('output');

        $phar = new \Phar($name);
        $phar->extractTo($output);
    }
}
