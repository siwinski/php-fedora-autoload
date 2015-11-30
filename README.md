# Fedora Autoloaders

Standardized, simplified, and singleton autoloaders


### Symfony

#### Before

```
BuildRequires: php-composer(symfony/class-loader)
Requires:      php-composer(symfony/class-loader)

cat <<'AUTOLOAD' | tee src/autoload.php
<?php

if (!isset($fedoraClassLoader) || !($fedoraClassLoader instanceof \Symfony\Component\ClassLoader\ClassLoader)) {
    if (!class_exists('Symfony\\Component\\ClassLoader\\ClassLoader', false)) {
        require_once '%{_datadir}/php/Symfony/Component/ClassLoader/ClassLoader.php';
    }

    $fedoraClassLoader = new \Symfony\Component\ClassLoader\ClassLoader();
    $fedoraClassLoader->register();
}

// This library
$fedoraClassLoader->addPrefix('Foo\\Bar\\', dirname(dirname(__DIR__)));

// Another library (i.e. dependency)
require_once '%{_datadir}/php/Foo/Bar/autoload.php';
AUTOLOAD
```

#### After

```
BuildRequires: php-composer(fedora/autoload-symfony)
Requires:      php-composer(fedora/autoload-symfony)

cat <<'AUTOLOAD' | tee src/autoload.php
<?php

// This library
require_once '%{_datadir}/php/Fedora/Autoload/Symfony.php';
\Fedora\Autoload\Symfony::getInstance()
    ->addPrefix('Foo\\Bar\\', dirname(dirname(__DIR__)));

// Another library (i.e. dependency)
require_once '%{_datadir}/php/Foo/Baz/autoload.php';
AUTOLOAD
```

### Zend

#### Before

```
BuildRequires: php-composer(zendframework/zend-loader)
Requires:      php-composer(zendframework/zend-loader)

cat <<'AUTOLOAD' | tee src/autoload.php
<?php

require_once '%{_datadir}/php/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'fallback_autoloader' => true, // for other dep, if needed
        'autoregister_zf' => true,     // for ZF, if needed
        'namespaces' => array(
           'Foo\\Bar' => __DIR__       // Your namespace
))));

// Another library (i.e. dependency)
require_once '%{_datadir}/php/Foo/Baz/autoload.php';
AUTOLOAD
```

#### After

```
BuildRequires: php-composer(fedora/autoload-zend)
Requires:      php-composer(fedora/autoload-zend)

cat <<'AUTOLOAD' | tee src/autoload.php
<?php

require_once '%{_datadir}/php/Fedora/Autoload/Zend.php';
\Fedora\Autoload\Zend::factory(array(
    'fallback_autoloader' => true,  // for other dep, if needed
    'autoregister_zf' => true,      // for ZF, if needed
    'namespaces' => array(
        'Foo\\Bar' => __DIR__       // Your namespace
    )
));

// Another library (i.e. dependency)
require_once '%{_datadir}/php/Foo/Baz/autoload.php';
AUTOLOAD
```
