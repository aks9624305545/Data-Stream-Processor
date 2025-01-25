<?php
namespace App\Services;

use App\Models\DataStream;
use Illuminate\Support\Facades\Cache;

class DataStraemService{

    public function dataStreamAnalyze($stream, $k, $top, $exclude){
        $cacheKey = 'dataStreamAnalyze_' . implode('_', [
            $stream,
            $k,
            $top,
            serialize($exclude)
        ]);

        $getSequenceData = Cache::remember($cacheKey, 60, function () use ($stream, $k, $top, $exclude) {
            $subsequenceCount = [];
            $streamLength = strlen($stream);
            
            for ($i = 0; $i <= $streamLength - $k; $i++) {
                $subsequence = substr($stream, $i, $k);
                if (in_array($subsequence, $exclude)) {
                    continue;
                }
                $subsequenceCount[$subsequence] = ($subsequenceCount[$subsequence] ?? 0) + 1;
            }
            
            arsort($subsequenceCount);
            $sorted = array_slice($subsequenceCount, 0, $top, true);

            $sequenceData = [];
            foreach ($sorted as $subsequence => $count) {
                $sequenceData[] = ['subsequence' => $subsequence, 'count' => $count];
            }
            // dd($sequenceData);
            return $sequenceData;
        });
        // dd($getSequenceData);

        return $getSequenceData;
    }

    public function dataStreamAdd($stream, $k, $top, $exclude, $sequenceData){
        $dataStream = DataStream::create([
            'stream' => $stream,
            'k' => $k,
            'top' => $top,
            'exclude' => json_encode($exclude),
            'sequenceData' => json_encode($sequenceData),
        ]);

        return $dataStream;
    }

    public function getStreamDataFromFile($DataStreamRequest){
        $requestStream = '';
        $file = $DataStreamRequest->file('stream');
        $handle = fopen($file->getPathname(), 'r');
        while (($line = fgets($handle)) !== false) {
            $requestStream .= trim($line);
        }
        fclose($handle);

        return $requestStream;
    }
}