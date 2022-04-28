<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\Launch;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class SyncArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $db_article_count = Article::count();
        $get_current_count = json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles/count'), true);

        if ($get_current_count > $db_article_count) {
            $number_of_missing_articles = $get_current_count - $db_article_count;
            
            $missing_articles = $db_article_count > 0 ? json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles?_sort=id&_start=' . $number_of_missing_articles . '&_limit=' . $get_current_count), true) : json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles?_limit=' . $get_current_count), true);

            $chunked_array = array_chunk($missing_articles, 4000);

        foreach($chunked_array as $chunk) { 
            
        $articles = array();
        $launches = array();
        $events = array();
        
        foreach($chunk as $missing_article) {
            $article = ['id' => $missing_article['id'], 'featured' => $missing_article['featured'], 'title' => $missing_article['title'], 'url' => $missing_article['url'], 'imageUrl' => $missing_article['imageUrl'], 'newsSite' => $missing_article['newsSite'], 'summary' => $missing_article['summary'], 'publishedAt' => $missing_article['publishedAt']];
            array_push($articles, $article);
            $raw_launches = $missing_article['launches'];
            $raw_events = $missing_article['events'];
            if (sizeof($raw_launches) > 0) {
                foreach ($raw_launches as $raw_launch) {
                    $launch = ['id' => $raw_launch['id'], 'provider' => $raw_launch['provider'], 'article_id' => $missing_article['id']];
                    array_push($launches, $launch);
                }
            }
            if (sizeof($raw_events) > 0) {
                foreach ($raw_events as $raw_event) {
                    $event = ['id' => $raw_event['id'], 'provider' => $raw_event['provider'], 'article_id' => $missing_article['id']];
                    array_push($events, $event);
                }
            }
        }
        Article::insert($articles);
        Launch::insert($launches);
        Event::insert($events);
            
        }
    }
    }
}
