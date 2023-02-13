<?php

namespace App\Http\Controllers;

use App\Models\CommandLobby;
use FFMpeg;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class StreamController extends Controller
{
    public function stream(Request $request)
    {
//        $output = 'rtmp://localhost/output/' . random_bytes(5);
        $command = 'ffmpeg -i rtmp://localhost/live -i rtmp://localhost/live2 -filter_complex "[0:v][1:v]hstack=inputs=2[v]" -map "[v]" -c:v libx264 -b:v 500k -r 30 -g 60 -f flv rtmp://localhost/live1234';
        $lobby = CommandLobby::where('lobby_id', $request->lobby_id)->first();
        if(!$lobby){
            CommandLobby::create([
                'command' => $command,
                'lobby_id' => $request->lobby_id
            ]);
        }

        $process = Process::fromShellCommandline($command,
            '/home/dbxdevz/', null, null, null);
        $process->start();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // ffmpeg -i <input RTMP URL> -c:v copy -c:a aac -strict -2 -f flv <output RTMP URL>
        $processChange = Process::fromShellCommandline('ffmpeg -i rtmp://localhost/live1234 -c:v copy -c:a aac -strict -2 -f flv rtmp://localhost/output/live_2',
            null, null, null, null);
        $processChange->start();

        if ($processChange->isSuccessful()) {
            $killProcess = Process::fromShellCommandline($lobby->command);
            $killProcess->stop();

            $lobby->command = $command;
            $lobby->save();
        }

        return response('message', 200);
    }

    public function getUrls()
    {

    }
}
