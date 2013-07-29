<?php
namespace tests\units\jubianchi\Lighthouse\Phar;

use mageekguy\atoum;
use mageekguy\atoum\mock;
use mageekguy\atoum\mock\streams;
use jubianchi\Lighthouse\Phar\Bootstrap as TestedClass;

require_once __DIR__ . '/../../../bootstrap.php';

class Bootstrap extends atoum\test
{
    public function test__construct()
    {
        $this
            ->if($class = uniqid())
            ->then
                ->exception(function() use ($class) {
                    new TestedClass($class);
                })
                    ->isInstanceOf('\\InvalidArgumentException')
                    ->hasMessage(sprintf('Class %s does not exist', $class))
            ->if($this->mockGenerator->generate('\\jubianchi\\Lighthouse\\Phar\\Runnable', '\\mock'))
            ->then
                ->object($builder = new TestedClass('\\mock\\jubianchi\\Lighthouse\\Phar\\Runnable'))->isInstanceOf('\\jubianchi\\Lighthouse\\Phar\\Bootstrap')
        ;
    }

    public function test__toString()
    {
        $this
            ->if($this->mockGenerator->generate('\\jubianchi\\Lighthouse\\Phar\\Runnable', '\\mock'))
            ->and($builder = new TestedClass('\\mock\\jubianchi\\Lighthouse\\Phar\\Runnable'))
            ->then
                ->castToString($builder)->isEqualTo(<<<EOF
<?php

\$basedir = __DIR__ . DIRECTORY_SEPARATOR . '..';

require_once implode(
    DIRECTORY_SEPARATOR,
    array(
        \$basedir,
        'vendor',
        'autoload.php'
    )
);

\$app = new \mock\jubianchi\Lighthouse\Phar\Runnable(\$basedir, array (
));
\$app->run();
EOF
                )
            ->if($args = array($key = uniqid() => $value = uniqid()))
            ->and($builder = new TestedClass('\\mock\\jubianchi\\Lighthouse\\Phar\\Runnable', $args))
            ->then
                ->castToString($builder)->isEqualTo(<<<EOF
<?php

\$basedir = __DIR__ . DIRECTORY_SEPARATOR . '..';

require_once implode(
    DIRECTORY_SEPARATOR,
    array(
        \$basedir,
        'vendor',
        'autoload.php'
    )
);

\$app = new \mock\jubianchi\Lighthouse\Phar\Runnable(\$basedir, array (
  '$key' => '$value',
));
\$app->run();
EOF
                )
        ;
    }
}
