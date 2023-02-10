<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\models\Rubrics;
use App\models\News;

class GetNews extends Command
{
    /**
     * @var string
     */
    protected $signature = 'news:get {newsCount}';

    /**
     * https://baconipsum.com/json-api/
     * type: all-meat for meat only or meat-and-filler for meat mixed with miscellaneous ‘lorem ipsum’ filler.
     * paras: optional number of paragraphs, defaults to 5.
     * sentences: number of sentences (this overrides paragraphs)
     * start-with-lorem: optional pass 1 to start the first paragraph with ‘Bacon ipsum dolor sit amet’.
     * format: ‘json’ (default), ‘text’, or ‘html’
     * 
     * @var string
     */
    protected $description = 'Fill news from Baconipsum';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $newsCount = $this->argument('newsCount');
        if ($newsCount > 100) {
            $newsCount = 100;
            $this->warn("\tThe `count` param must be less or equal of 100!");
        }

        $guzzle = new \GuzzleHttp\Client();
        $endpoint = "https://baconipsum.com/api/";
        $query = [
            'type' => 'meat-and-filler',
        ];

        $rubrics = Rubrics::where('rubrics_id', '<>', null)->get()->keyBy('id');
        $rubricsIds = $rubrics->keys();
        $rubricsCount = count($rubricsIds);

        $toInsert = $titles = $bodies = [];

        // Resolve data
        $responseTitle = $guzzle->request('GET', $endpoint, ['query' => $query + ['sentences' => $newsCount]]);
        $titles = explode('. ', trim(json_decode($responseTitle->getBody(), true)[0], '.'));
        $responseBodies = $guzzle->request('GET', $endpoint, ['query' => $query + ['paras' => $newsCount]]);
        $bodies = json_decode($responseBodies->getBody(), true);
        $this->info("\t{$newsCount} titles and bodies has been resolved from https://baconipsum.com/api/");

        // Put data
        for ($i = 0; $i < $newsCount; $i++) {
            $randomRubrics = $this->getRandomRubrics($rubricsIds, $rubricsCount);
            $newModel = News::firstOrCreate(['title' => $titles[$i]], [
                'announce' => substr($bodies[$i], 0, 61) . '...',
                'content' => $bodies[$i]
            ]);
            foreach ($randomRubrics as $rid) {
                $newModel->rubrics()->attach($rubrics->get($rid));
            }
        }

        return 0;
    }

    /**
     * @param rubricsIds массив ID рубрик
     * @return array
     */
    private function getRandomRubrics($rubricsIds, $rubricsCount): array {
        $n = rand(1, $rubricsCount);
        $result = [];
        while (true) {
            $rnd = $rubricsIds[rand(0, $rubricsCount - 1)];
            if (empty($result[$rnd])) {
                $result[$rnd] = true;
                if (count($result) == $n) {
                    break;
                }
            }
        }
        return array_keys($result);
    }
}
