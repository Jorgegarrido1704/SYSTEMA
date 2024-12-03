<?php

namespace App\Http\Controllers;
use App\Http\Controllers\caliController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\juntasController;

class BossCaliController extends Controller
{
    public function __invoke(){
            $value=session('user');
            $cat=session('categoria');

                $calidadControl=new juntasController();
                $caliInfo=$calidadControl->calidad_junta();
                $monthAndYearPareto=$caliInfo->getData()['monthAndYearPareto'];
                $calidad=$caliInfo->getData()['calidad'];
                $datosT=$caliInfo->getData()['datosT'];
                $datosS=$caliInfo->getData()['datosS'];
                $datosF=$caliInfo->getData()['datosF'];
                $labelQ=$caliInfo->getData()['labelQ'];
                $colorQ=$caliInfo->getData()['colorQ'];
                $datos=$caliInfo->getData()['datos'];
                $pareto=$caliInfo->getData()['pareto'];
                $Qdays=$caliInfo->getData()['Qdays'];

                return view('juntas/calidad',['calidadControl'=>$calidadControl,'monthAndYearPareto'=>$monthAndYearPareto,'calidad'=>$calidad,'datosT'=>$datosT,'datosS'=>$datosS,'datosF'=>$datosF,'labelQ'=>$labelQ,'colorQ'=>$colorQ,'value'=>$value,'cat'=>$cat,'datos'=>$datos,'pareto'=>$pareto,'Qdays'=>$Qdays]);

        }
    }


