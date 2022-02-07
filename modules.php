<?php

use PhpModules\Lib\Module;
use PhpModules\Lib\Modules;

/* Internal modules */
$exceptions = Module::strict('MlsExporting\Exceptions');
$xml = Module::strict('MlsExporting\Xml', [$exceptions]);
$tcx = Module::strict('MlsExporting\Tcx', [$xml]);

$internal = [$exceptions, $xml, $tcx];

return Modules::builder('./src')
    ->allowUndefinedModules()
    ->register($internal);
