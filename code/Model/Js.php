<?php

class BlueAcorn_UniversalAnalytics_Model_Js {


    public function observe($event, $content) {
        $text = ".observe( '{$event}', ";
        $text .= $this->anonFunc('event', $content);
        $text .= ');';

        return $text;
    }


    public function each($content) {
        $text = '.forEach( ';
        $text .= $this->anonFunc('element, index, array', $content);
        $text .= ');';

        return $text;
    }

    public function anonFunc($paramList, $content) {

        // $functionText = $this->func('function', $paramList);
        // $functionText .= '{ ';

        $functionText = 'function(' . $paramList . ') { ';
        $functionText .= $content;
        $functionText .= ' }';

        return $functionText;
    }

    public function call($name) {
        $params = func_get_args();
        $name = array_shift($params);
        $outputList = Array();

        foreach ($params as $element) {
            if (is_array($element)) {
                $outputList[] = json_encode($element); 
            } else {
                $outputList[] = "'" . $element . "'";
            }
        }

        return "{$name}(" . implode(', ', $outputList) . ");\n";
    }

    /**
     * Generates a block of JS text for Universal Analytics
     * calls. This method takes an indeterminate number of parameters.
     *
     * @name generateGoogleJS
     * @param multi
     * @return string
     */
    public function generateGoogleJS() {
        $params = func_get_args();
        array_unshift($params, 'ga');
        
        return call_user_func_array(Array($this, 'call'), $params);
    }


}