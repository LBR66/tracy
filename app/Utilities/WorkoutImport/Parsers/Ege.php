<?php

namespace App\Utilities\WorkoutImport\Parsers;

use App\Utilities\WorkoutImport\Point;
use \Exception;

/**
 * This library loads and parse gpx file
 *
 */
class Ege extends Parser implements \Iterator, ParserInterface
{
    public function parse($file)
    {  
        if (file_exists($file)) {
            $xmlReader = new \XMLReader();
            $xmlReader->open(addslashes($file));
            //Summary
            while($xmlReader->read()) {
                // check to ensure nodeType is an Element not attribute or #Text
                //echo $xmlReader->localName . "\n"; 
                if($xmlReader->nodeType == \XMLReader::ELEMENT) {
                    if($xmlReader->localName == 'meta-inf') {
                        $key   = $xmlReader->getAttribute('key');
                        $value = $xmlReader->getAttribute('value');
                        switch ($key) {
                            case "START_TIME":
                                $starttime = $value;
                                break;
                            case "END_TIME":
                                $endtime = $value;
                                break;
                            case "NAME":
                                $name = $value;
                                break;
                            case "COUNT":
                                $count = $value; 
                                break;
                            case "DURATION":
                                $duration = $value;
                                break;
                            case "DISTANCE":
                                $distance = round($value,2);
                                break;
                            case "HEARTRATE_AVG":
                                $heartrate_avg = $value;
                                break;
                            case "HEARTRATE_MAX":
                                $heartrate_max = $value;
                                break;
                            case "POWER_AVG":
                                $power_avg = $value;
                                break;
                            case "POWER_MAX":
                                $power_max = $value;
                                break;
                            case "CADENCE_AVG":
                                $cadence_avg = $value;
                                break;
                            case "CADENCE_MAX":
                                $cadence_max = $value;
                                break;
                            case "PHYSICAL_ENERGY":
                                $physical_energy = $value;
                                break;
                            case "SYSTEMWEIGHT":
                                $systemweight = $value;                                                
                        }
                    }        
                }
            }
            $xmlReader->close();

            $xmlReader->open(addslashes($file));
            //Entries
            $index=0;
            while($xmlReader->read()) {
                // check to ensure nodeType is an Element not attribute or #Text
                if($xmlReader->nodeType == \XMLReader::ELEMENT) {
                         
                    if($xmlReader->localName == 'entry') {
                        $time   = $xmlReader->getAttribute('time');
                        $distance = $xmlReader->getAttribute('distance');
                        $power = $xmlReader->getAttribute('power');
                        $heartrate = $xmlReader->getAttribute('heartrate');
                        $cadence = $xmlReader->getAttribute('cadence');
                        $speed = $xmlReader->getAttribute('speed');
                        $phys_energy = $xmlReader->getAttribute('phys-energy');
                        $value = $xmlReader->getAttribute('value');
                        $temperature = $xmlReader->getAttribute('temperature');
                        $slope = $xmlReader->getAttribute('slope');
                        $latp = round($xmlReader->getAttribute('lat'),6);
                        $lonp = round($xmlReader->getAttribute('lon'),6);  

                        // push points to array
                            $point = new Point(
                                floatval($latp),
                                floatval($lonp)
                            );
                            #$point->setSegmentIndex($index);
                            $point->setSegmentIndex(0);
                            if (!empty($value)) {
                                $point->setEvelation(floatval($value));
                            };
                            if (!empty($time)) {
                                $point->setTime($time);
                            };

                            if (!empty($heartrate)) {
                                $point->setHeartRate(intval($heartrate));
                            }
                            else {$point->setHeartRate(0);}
                            
                            if (!empty($power)) {
                                $point->setPower(intval($power));
                            };
                            
                            if (!empty($cadence)) {
                                $point->setCadence(intval($cadence));
                            };
                            if (!empty($starttime)) {
                                $zwdat=date_create($starttime);
                                date_add($zwdat, date_interval_create_from_date_string($index . ' seconds'));
                                $point->setTime( $zwdat->format('d-m-Y') . "T" . $zwdat->format('H:i:s'). "\n");
                            };
                            ##
                            $this->points[] = $point;                  
                }
                $index++;
            }
        }
            } else {
            throw new \Exception('The file does not exist.');
        }

        return $this->points;
    }

}
