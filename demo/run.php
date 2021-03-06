<?php

namespace Demo;

/** @var ClassLoader $loader */
$loader = require dirname(__DIR__,) . '/vendor/autoload.php';
$loader->addPsr4('Demo\\', __DIR__ . '/src');

use Aura\Sql\ExtendedPdoInterface;
use Composer\Autoload\ClassLoader;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\MediaQuery\MediaQueryModule;

$sqlDir = __DIR__ . '/sql';
$dsn = 'sqlite::memory:';
$injector = new Injector(new class($sqlDir, $dsn) extends AbstractModule {

    public function __construct(
        private string $sqlDir,
        private string $dsn
    ){}

    protected function configure()
    {
        $mediaQueries = [
            UserAddInterface::class,
            UserItemInterface::class
        ];
        $this->install(new MediaQueryModule($this->dsn, $this->sqlDir, $mediaQueries));
    }
});
/** @var ExtendedPdoInterface $pdo */
$pdo = $injector->getInstance(ExtendedPdoInterface::class);
$pdo->query(/** @lang sql */'CREATE TABLE IF NOT EXISTS user (
          id TEXT,
          name TEXT
)');
/** @var User $user */
$user = $injector->getInstance(User::class);
$user->add('1', 'koriym');
$userItem = $user->get('1');
echo $userItem['name'] === 'koriym' ? 'It works!' : 'It dones not work.';
