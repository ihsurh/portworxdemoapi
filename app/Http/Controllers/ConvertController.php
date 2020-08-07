<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ConvertController extends Controller
{
    

    private function converter($input)
    {
        $retArray = array();
        if (is_object($input)) {
            # code...
            $inputAsArray = get_object_vars($input);
        } else if(is_array($input)){
            # code...
            $inputAsArray = $input;
        }else{
            return $retArray;
        }
        
        
        $inputAsArrayKeys = array_keys($inputAsArray);
        foreach ($inputAsArrayKeys as $key) {
            $upperKey = strtoupper($key);
            if (is_object($inputAsArray[$key]) || is_array($inputAsArray[$key])) {
                # code...
                $retArray[$upperKey]= $this->converter($inputAsArray[$key]);
            } else {
                # code...
                $retArray[$upperKey]=$inputAsArray[$key];
            }
            
        }
    
        return $retArray;
    }

    public function convert(Request $request)
    {
        $input = $request->json()->get('input');
        if($input == null ||(!is_array($input) && !is_object($input))){
            return response()->json(['error' => 'Invalid input'], 400);
        }else{
    
            return $this->converter($input);
        }
    }
}
