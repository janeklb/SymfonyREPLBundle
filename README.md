SymfonyREPLBundle
=================

A Read-Eval-Print Loop ./app/console command for your Symfony environment

Installation
============

Register the namespace in `autoload.php`
``` php
$loader->registerNamespaces(array(
	// ...
	'JLB'              => __DIR__.'/../vendor/bundles',
```

Add to your `AppKernel.php`:
``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new JLB\SymfonyREPLBundle\JLBSymfonyREPLBundle(),
    );
}
```

Add to your ``deps``:
```
[JLBSymfonyREPLBundle]
	git=git://github.com/janeklb/SymfonyREPLBundle.git
	target=/bundles/JLB/SymfonyREPLBundle
```


Usage
=====

Run ``./app/console symfony:REPL``

