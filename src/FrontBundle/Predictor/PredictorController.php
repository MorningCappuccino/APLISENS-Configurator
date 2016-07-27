<?php


namespace FrontBundle\Predictor;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FrontBundle\Predictor\Finder;

class PredictorController extends Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    //TODO => this $params is very bad; But I no time rewrire main.js Core and generate() function
    public $params = array(
        'eqModeID' => null,
        'accuracyID' => null,
        'specialVersionID' => null,
        'measurementRangeID' => null,
        'bodyTypeID' => null,
        'processConnectionID' => null,
        'pulsePipeLength' => null,
        'cableLength' => null,
        'tubeLength' => null,
        'anotherMeasurementRange' => null,
        'secondProcessConnection' => null,
        'cablePTFELength' => null,
        'PTFEenvelopeLength' => null,
        'valveUnitID' => null,
        'weldedElementID' => null,
        'braceID' => null,
        'countryCodeID' => null,
        'ContOtherSpecVers' => array(
            'ids' => []
        )
    );

    function makePrediction($str)
    {
        //get services
        $finder = $this->get('app.finder');
        $em = $this->getDoctrine()->getManager();


        /*-----------------------------------------
        delete any spaces
        -----------------------------------------*/
        $str = preg_replace('/^\s+/', '', $str); //since begin
        $str = preg_replace('/\s+$/', '', $str); //since end
        $str = preg_replace('/\s+\//', '/', $str); //before "/"
        $str = preg_replace('/\/\s+/', '/', $str); //after "/"

        //split string by "/"
        $arr = preg_split('/\//', $str);

        $count_params = count($arr);


        /*-----------------------------------------
        assume EqMode
        -----------------------------------------*/
        $eq_mode_id = $finder->isEqMode($arr[0]);
        if ($eq_mode_id === false) {
           return 'Модификации оборудования "'. $arr[0] . '" в базе данных не обнаружено.';
        }

        /*-----------------------------------------
        assume Accuracy Class
        -----------------------------------------*/
        $arr[1] = preg_replace('/[,]/', '.', $arr[1]);
        $accuracy_id = $finder->isAccuracyClass($arr[1]);
        if ($accuracy_id === false) {
            return 'Класса точности "'. $arr[1] . '" в базе данных не обнаружено.';
        }

        /*-----------------------------------------
        assume Special Version is exist
        -----------------------------------------*/
        $special_version_id = $finder->isSpecialVersion($arr[2]);

        //find anotherSpecialVersions
        if ($special_version_id !== false) {
            for ($i = 3; $i < count($arr); $i++) {
                $id = $finder->isSpecialVersion($arr[$i]);
                if ($id === false) break;
                $this->params['ContOtherSpecVers']['ids'][$i] = $id;
            }
        }

        /*-----------------------------------------
        assume Measurement Range is exist
        -----------------------------------------*/
        if ( !empty($i) ) {
            $res = $em->getRepository('AppBundle:MeasurementRange')->parse($arr[$i]);
            $curr_position = $i;
        } else {
            $res = $em->getRepository('AppBundle:MeasurementRange')->parse($arr[2]);
            $curr_position = 2;
        }

        $theRange = $res['theRange'];
        $unit = $res['unit'];
        $measurement_range_id = $finder->isMeasurementRange($theRange, $unit);
        if ($measurement_range_id === false) {
            return 'Диапазона измерения "'. $arr[$curr_position] . '" в базе данных не обнаружено.';
        }

        //validate secondMeasurementRange
        if ($measurement_range_id !== false) {
            $res = $em->getRepository('AppBundle:MeasurementRange')->parse($arr[++$curr_position]);
            $theRange = $res['theRange'];
            $unit = $res['unit'];

            if ( empty($theRange) && empty($unit) ) {
                $curr_position--;
            } else {
                $another_measurement_range = $theRange . ' ' . $unit;
            }
        }

        /*-----------------------------------------
        assume Body Type is exist
        -----------------------------------------*/
        $body_type_id = $finder->isBodyType($arr[++$curr_position]);
        if ($body_type_id === false) {
            --$curr_position;
        }

        /*-----------------------------------------
        assume Process Connection is exist
        -----------------------------------------*/
        $process_connection_id = $finder->isProcessConnection($arr[++$curr_position]);

        if ($process_connection_id !== false && ($curr_position < $count_params - 1) ) {
            /*-----------------------------------------
            assume Valve Unit is exist
            -----------------------------------------*/

            //Temporary fix problems with find "VM-3/A" and "VM-5/A"
            $vu = $arr[$curr_position+1];
            if ( ($vu === 'VM-3') || ($vu === 'VM-5') ) {
                if ($vu === 'VM-3') {
                    if ($arr[$curr_position+2] === 'A') {
                        $valve_unit_id = $finder->isValveUnit('VM-3/A');
                        $curr_position += 2;
                    }
                }
                if ($vu === 'VM-5') {
                    if ($arr[$curr_position+2] === 'A') {
                        $valve_unit_id = $finder->isValveUnit('VM-5/A');
                        $curr_position += 2;
                    }
                }
            } else {
                //end temporary fix
                $valve_unit_id = $finder->isValveUnit($arr[++$curr_position]);
                $valve_unit_id === false ? --$curr_position : false;
            }
        } else {
            --$curr_position;
        }

        /*-----------------------------------------
        assume Welded Element is exist
        -----------------------------------------*/
        if ($curr_position < $count_params - 1) {
            $welded_element_id = $finder->isWeldedElement($arr[++$curr_position]);
            $welded_element_id === false ? --$curr_position : false;
        }

        /*-----------------------------------------
        assume Bracing is exist
        -----------------------------------------*/
        if ($curr_position < $count_params - 1) {
            $bracing_id = $finder->isBracing($arr[++$curr_position]);
            $bracing_id === false ? --$curr_position : false;
        }

        /*-----------------------------------------
        assume Country Code is exist
        -----------------------------------------*/
        if ($curr_position < $count_params - 1) {
            $country_code_id = $finder->isCountryCode($arr[++$curr_position]);
        }


        $this->params['eqModeID'] = $eq_mode_id;
        $this->params['accuracyID'] = $accuracy_id;
        $this->params['specialVersionID'] = $special_version_id;
        $this->params['measurementRangeID'] = $measurement_range_id;
        if ( !empty($another_measurement_range) ) {
            $this->params['anotherMeasurementRange'] = $another_measurement_range;
        }
        $this->params['bodyTypeID'] = $body_type_id;
        $this->params['processConnectionID'] = $process_connection_id;
        if ( !empty($valve_unit_id) ) {
            $this->params['valveUnitID'] = $valve_unit_id;
        }
        if ( !empty($welded_element_id) ) {
            $this->params['weldedElementID'] = $welded_element_id;
        }
        if ( !empty($bracing_id) ) {
            $this->params['braceID'] = $bracing_id;
        }
        if ( !empty($country_code_id) ) {
            if (($country_code_id !== false)) {
                $this->params['countryCodeID'] = $country_code_id;
            }
        } else {
                $this->params['countryCodeID'] = 1;
        }

        $result = array('params' => $this->params);

        return $result;
    }
}