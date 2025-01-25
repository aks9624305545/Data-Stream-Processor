<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DataStreamRequest;
use App\Services\DataStraemService;

class DataStreamController extends Controller
{
    protected $dataStraemService;
    
    public function __construct(DataStraemService $dataStraemService)
    {
        $this->dataStraemService = $dataStraemService;
    }

    public function dataStreamAnalyze(DataStreamRequest $DataStreamRequest){

        $stream = $DataStreamRequest->stream;
        $k = $DataStreamRequest->k;
        $top = $DataStreamRequest->top;
        $exclude = $DataStreamRequest->exclude;

        if ($DataStreamRequest->hasFile('stream') && $DataStreamRequest->file('stream')->isValid()) {
            $stream = $this->dataStraemService->getStreamDataFromFile($DataStreamRequest);
        }

        $getDataStreamAnalyze = $this->dataStraemService->dataStreamAnalyze($stream, $k, $top, $exclude);

        $getDataStreamAdd = $this->dataStraemService->dataStreamAdd($stream, $k, $top, $exclude, $getDataStreamAnalyze);

        return response()->json(['status'=>true,'statusCode'=>200,'message'=>'Analyze data success','result'=>$getDataStreamAnalyze]);
    }
}
