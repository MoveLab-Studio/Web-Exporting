<?php

namespace Tests\Tcx;

use MlsExporting\Tcx\TcxExporter;
use PHPUnit\Framework\TestCase;

class TcxExporterTest extends TestCase
{

    public function test_notImplemented():void
    {
        /* Given */
        $tcxExporter = new TcxExporter();

        /* Then */
        $this->expectException(\Exception::class);

        /* When */
        $tcxExporter->export();
    }

}