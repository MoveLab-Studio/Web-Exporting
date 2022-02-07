<?php

use PhpModules\Lib\Module;
use PhpModules\Lib\Modules;

/* Internal modules */

$tcx = Module::strict('MlsExporting\Tcx');

$internal = [$tcx];

return Modules::builder('./src')
    ->register($internal);