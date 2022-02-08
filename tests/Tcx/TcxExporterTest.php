<?php

namespace Tests\Tcx;

use MlsExporting\Tcx\Models\Activity;
use MlsExporting\Tcx\Models\ActivityExtension;
use MlsExporting\Tcx\Models\HeartRateInBeatsPerMinute;
use MlsExporting\Tcx\Models\Intensity;
use MlsExporting\Tcx\Models\Lap;
use MlsExporting\Tcx\Models\Sport;
use MlsExporting\Tcx\Models\Track;
use MlsExporting\Tcx\Models\Trackpoint;
use MlsExporting\Tcx\Models\TriggerMethod;
use MlsExporting\Tcx\TcxExporter;
use PHPUnit\Framework\TestCase;
use Tests\XmlAssertions;

class TcxExporterTest extends TestCase
{

    use XmlAssertions;

    public function test_should_convert_lap(): void
    {
        /* Given */
        $activity = $this->activity([$this->lap()]);

        /* When */
        $result = (new TcxExporter())->export($activity);

        /* Then */
        $this->assertXmlStringEqualsXmlString(<<<XML
<?xml version="1.0" encoding="UTF-8"?>\n
<TrainingCenterDatabase xmlns="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2" xmlns:ns2="http://www.garmin.com/xmlschemas/UserProfile/v2" xmlns:ns3="http://www.garmin.com/xmlschemas/ActivityExtension/v2" xmlns:ns4="http://www.garmin.com/xmlschemas/ProfileExtension/v1" xmlns:ns5="http://www.garmin.com/xmlschemas/ActivityGoals/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2 http://www.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd">
    <Activities>
        <Activity Sport="Other">
            <Id>2022-02-07T12:34:56+00:00</Id>
            <Lap StartTime="2022-02-07T12:34:56+00:00">
                <TotalTimeSeconds>60</TotalTimeSeconds>
                <DistanceMeters>500</DistanceMeters>
                <Calories>0</Calories>
                <Intensity>Active</Intensity>
                <TriggerMethod>Manual</TriggerMethod>
            </Lap>
            <Notes>This way quite the workout</Notes>
        </Activity>
    </Activities>
</TrainingCenterDatabase>
XML, $result);
        $this->assertXmlSchema($result, 'https://www8.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd');
    }

    public function test_should_convert_trackpoint(): void
    {
        /* Given */
        $lap = $this->lap();
        $trackpoint = $this->trackpoint();
        $lap->track = new Track([$trackpoint]);

        $activity = $this->activity([$lap]);

        /* When */
        $result = (new TcxExporter())->export($activity);

        /* Then */
        $this->assertXmlStringEqualsXmlString(<<<XML
<?xml version="1.0" encoding="UTF-8"?>\n
<TrainingCenterDatabase xmlns="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2" xmlns:ns2="http://www.garmin.com/xmlschemas/UserProfile/v2" xmlns:ns3="http://www.garmin.com/xmlschemas/ActivityExtension/v2" xmlns:ns4="http://www.garmin.com/xmlschemas/ProfileExtension/v1" xmlns:ns5="http://www.garmin.com/xmlschemas/ActivityGoals/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2 http://www.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd">
    <Activities>
        <Activity Sport="Other">
            <Id>2022-02-07T12:34:56+00:00</Id>
            <Lap StartTime="2022-02-07T12:34:56+00:00">
                <TotalTimeSeconds>60</TotalTimeSeconds>
                <DistanceMeters>500</DistanceMeters>
                <Calories>0</Calories>
                <Intensity>Active</Intensity>
                <TriggerMethod>Manual</TriggerMethod>
                <Track>
                    <Trackpoint>
                      <Time>2022-02-07T12:34:56+00:00</Time>
                      <DistanceMeters>100</DistanceMeters>
                      <HeartRateBpm>
                        <Value>125</Value>
                      </HeartRateBpm>
                      <Cadence>23</Cadence>
                      <Extensions>
                        <TPX xmlns="http://www.garmin.com/xmlschemas/ActivityExtension/v2"/>
                      </Extensions>
                    </Trackpoint>
                </Track>
            </Lap>
            <Notes>This way quite the workout</Notes>
        </Activity>
    </Activities>
</TrainingCenterDatabase>

XML, $result);
        $this->assertXmlSchema($result, 'https://www8.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd');
    }

    public function test_should_convert_multiple_trackpoints(): void
    {
        /* Given */
        $lap = $this->lap();
        $trackpoint1 = $this->trackpoint();
        $trackpoint2 = $this->trackpoint();
        $lap->track = new Track([$trackpoint1, $trackpoint2]);

        $activity = $this->activity([$lap]);

        /* When */
        $result = (new TcxExporter())->export($activity);

        /* Then */
        $this->assertXmlStringEqualsXmlString(<<<XML
<?xml version="1.0" encoding="UTF-8"?>\n
<TrainingCenterDatabase xmlns="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2" xmlns:ns2="http://www.garmin.com/xmlschemas/UserProfile/v2" xmlns:ns3="http://www.garmin.com/xmlschemas/ActivityExtension/v2" xmlns:ns4="http://www.garmin.com/xmlschemas/ProfileExtension/v1" xmlns:ns5="http://www.garmin.com/xmlschemas/ActivityGoals/v1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.garmin.com/xmlschemas/TrainingCenterDatabase/v2 http://www.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd">
    <Activities>
        <Activity Sport="Other">
            <Id>2022-02-07T12:34:56+00:00</Id>
            <Lap StartTime="2022-02-07T12:34:56+00:00">
                <TotalTimeSeconds>60</TotalTimeSeconds>
                <DistanceMeters>500</DistanceMeters>
                <Calories>0</Calories>
                <Intensity>Active</Intensity>
                <TriggerMethod>Manual</TriggerMethod>
                <Track>
                    <Trackpoint>
                      <Time>2022-02-07T12:34:56+00:00</Time>
                      <DistanceMeters>100</DistanceMeters>
                      <HeartRateBpm>
                        <Value>125</Value>
                      </HeartRateBpm>
                      <Cadence>23</Cadence>
                      <Extensions>
                        <TPX xmlns="http://www.garmin.com/xmlschemas/ActivityExtension/v2"/>
                      </Extensions>
                    </Trackpoint>
                    <Trackpoint>
                      <Time>2022-02-07T12:34:56+00:00</Time>
                      <DistanceMeters>100</DistanceMeters>
                      <HeartRateBpm>
                        <Value>125</Value>
                      </HeartRateBpm>
                      <Cadence>23</Cadence>
                      <Extensions>
                        <TPX xmlns="http://www.garmin.com/xmlschemas/ActivityExtension/v2"/>
                      </Extensions>
                    </Trackpoint>
                </Track>
            </Lap>
            <Notes>This way quite the workout</Notes>
        </Activity>
    </Activities>
</TrainingCenterDatabase>

XML, $result);
        $this->assertXmlSchema($result, 'https://www8.garmin.com/xmlschemas/TrainingCenterDatabasev2.xsd');
    }

    /**
     * @param Lap[] $laps
     * @return Activity
     */
    private function activity(array $laps): Activity
    {
        $activity = new Activity(
            \DateTime::createFromFormat('Y-m-d H:i:s', '2022-02-07 12:34:56'),
            Sport::Other,
            $laps
        );
        $activity->notes = 'This way quite the workout';
        return $activity;
    }

    private function lap(): Lap
    {
        $lap = new Lap(\DateTime::createFromFormat('Y-m-d H:i:s', '2022-02-07 12:34:56'));
        $lap->intensity = Intensity::Active;
        $lap->totalTimeSeconds = 60;
        $lap->distanceMeters = 500;
        $lap->calories = 0;
        $lap->triggerMethod = TriggerMethod::Manual;
        return $lap;
    }

    /**
     * @return Trackpoint
     */
    private function trackpoint(): Trackpoint
    {
        $trackpoint = new Trackpoint();
        $trackpoint->time = \DateTime::createFromFormat('Y-m-d H:i:s', '2022-02-07 12:34:56');
        $trackpoint->cadence = 23;
        $trackpoint->distanceMeters = 100;
        $trackpoint->heartRateBpm = new HeartRateInBeatsPerMinute(125);
        $activityExtension = new ActivityExtension();
        $trackpoint->extensions = [$activityExtension];
        return $trackpoint;
    }
}