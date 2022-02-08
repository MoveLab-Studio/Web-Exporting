<?php

namespace MlsExporting\Tcx;

use MlsExporting\Tcx\Models\Activity;
use MlsExporting\Xml\XmlHelper;

/**
 * @public
 */
class TcxExporter
{

    public function export(Activity $activity): string
    {
        $trainingCenterDatabase = new TrainingCenterDatabase([$activity]);

        return XmlHelper::fromSerializable($trainingCenterDatabase);
    }

}