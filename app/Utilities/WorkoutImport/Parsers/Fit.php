<?php

namespace App\Utilities\WorkoutImport\Parsers;
use App\Utilities\WorkoutImport\Point;
#use garfielt\php-fit-file-analysis\phpFITFileAnalysis;
use \Exception;

/**
 * This library loads and parse gpx file
 *
 */
class Fit extends Parser implements \Iterator, ParserInterface
{   
    //use phpFITFileAnalysis;

    public function parse($file)
    {
        if (file_exists($file)) {
            $pFFA = new phpFITFileAnalysis('fit_files/my_fit_file.fit');
            throw new Exception('Parser Fit under construction!');

            $index = 0;
            foreach ($activityNode->Lap as $lap) {
                // push points to array
                foreach ($lap->Track->Trackpoint as $trkpt) {
                    $point = new Point(
                        floatval($trkpt->Position->LatitudeDegrees),
                        floatval($trkpt->Position->LongitudeDegrees)
                    );

                    $point->setSegmentIndex($index);

                    if (!empty($trkpt->AltitudeMeters)) {
                        $point->setEvelation(floatval($trkpt->AltitudeMeters));
                    };

                    if (!empty($trkpt->Time)) {
                        $point->setTime($trkpt->Time->__toString());
                    };

                    if (!empty($trkpt->HeartRateBpm)) {
                        $point->setHeartRate(intval($trkpt->HeartRateBpm->Value));
                    }
                    ##
					if (!empty($trkpt->Extensions->TPX->Watts)) {
                        $point->setPower($trkpt->Extensions->TPX->Watts);
                    };
					
                    if (!empty($trkpt->Cadence)) {
                        $point->setCadence($trkpt->Cadence);
                    };
                    
					##
                    $this->points[] = $point;
                }

                $index++;
            }
        } else {
            throw new \Exception('The file does not exist.');
        }

        return $this->points;
    }
}
