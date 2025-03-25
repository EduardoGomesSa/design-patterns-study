<?php 

namespace RefactoringGuru\Command\RealWorld;

interface Command {
    public function execute() : void;
    public function getId() : int;
    public function getStatus() : int;
}

abstract class WebScrapingCommand implements Command {
    public $id;
    public $status = 0;
    public $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getURL() : string {
        return $this->url;
    }

    public function execute() : void {
        $html = $this->download();
        $this->parse($html);
        $this->complete();
    }

    public function download() : string {
        $html = file_get_contents($this->getURL());
        echo "WebScrapingCommand: Downloaded {$this->url}\n";

        return $html;
    }

    abstract public function parse(string $html) : void;

    public function complete() : void {
        $this->status = 1;
        Queue::get()->completeCommand($this);
    }
}

class IMDBGenresScrapingCommand extends WebScrapingCommand {
    public function __construct() {
        $this->url = "https://www.imdb.com/feature/genre/";
    }

    public function parse(string $html): void
    {
        preg_match_all("|href=\"(https://www.imdb.com/search/title\?genres=.*?)\"|", $html, $matches);

        echo "IMDBGenresScrapingCommand: Discovered " . count($matches[1]) . " genres.\n";

        foreach ($matches[1] as $genre) {
            Queue::get()->add(new IMDBGenrePageScrapingCommand($genre));
        }
    }
}

class IMDBGenrePageScrapingCommand extends WebScrapingCommand {
    private $page;

    public function __construct(string $url, int $page = 1) {
        parent::__construct($url);
        $this->page = $page;
    }

    public function getURL(): string
    {
        return $this->url . '?page=' . $this->page;
    }

    public function parse(string $html) : void {
        preg_match_all("|href=\"(/title/.*?/)\?ref_=adv_li_tt\"|", $html, $matches);
        echo "IMDBGenrePageScrapingCommand: Discovered " . count($matches[1]) . " movies.\n";

        foreach ($matches[1] as $moviePath) {
            $url = "https://www.imdb.com" . $moviePath;
            Queue::get()->add(new IMDBMovieScrapingCommand($url));
        }

        if(preg_match("|Next &#187;</a>|", $html)) {
            Queue::get()->add(new IMDBGenrePageScrapingCommand($this->url, $this->page + 1));
        }
    }
}

class IMDBMovieScrapingCommand extends WebScrapingCommand {
    public function parse(string $html): void
    {
        if(preg_match("|<h1 itemprop=\"name\" class=\"\">(.*?)</h1>|", $html, $matches)) {
            $title = $matches[1];
        }
        
        echo "IMDBMovieScrapingCommand: Parsed movie $title.\n";
    }
}