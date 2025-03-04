<?php

namespace RefactoringGuru\Facade\RealWorld;

class YouTubeDownloader {
    protected $youtube;
    protected $ffmpeg;

    public function __construct(string $youtubeApiKey) {
        $this->youtube = New Youtube($youtubeApiKey);
        $this->ffmpeg = new FFMpeg();
    }

    public function downloadVideo(string $url) : void {
        echo "Fetching video metadata from youtube...\n";

        echo "Saving video file to a temporary file...\n";

        echo "Processing source video...\n";

        echo "Normalizing and resizing the video to smaller dimensions...\n";

        echo "Capturing preview image...\n";

        echo "Saving video in target formats...\n";

        echo "Done!\n";
    }
}

class Youtube {
    public function fetchVideo() : string {return "";}
    public function saveAs() : void {}
}

class FFMpeg {
    public static function create() : FFMpeg { return new FFMpeg(); }
    public function open(string $video) : void {} 
}

class FFMpegVideo {
    public function filters() : self {return $this;}
    public function resize() : self {return $this;}
    public function synchronize() : self {return $this;}
    public function frame() : self {return $this;}
    public function save() : self {return $this;}
}

function clientCode(YouTubeDownloader $facade) {
    $facade->downloadVideo("https://www.youtube.com/watch?v=QH2-TGUlwu4");
}

$facade = new YouTubeDownloader("APIKEY-XXXXXXXXX");
clientCode($facade);