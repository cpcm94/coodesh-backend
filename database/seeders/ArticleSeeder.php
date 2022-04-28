<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Launch;
use App\Models\Event;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $get_current_count = json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles/count'), true);
        $raw_articles = json_decode(file_get_contents('https://api.spaceflightnewsapi.net/v3/articles?_limit=' . $get_current_count), true);

        $chunked_array = array_chunk($raw_articles, 4000);

        foreach($chunked_array as $chunk) {   
        $articles = array();
        $launches = array();
        $events = array();
        
        foreach($chunk as $raw_article) {
            $article = ['id' => $raw_article['id'], 'featured' => $raw_article['featured'], 'title' => $raw_article['title'], 'url' => $raw_article['url'], 'imageUrl' => $raw_article['imageUrl'], 'newsSite' => $raw_article['newsSite'], 'summary' => $raw_article['summary'], 'publishedAt' => $raw_article['publishedAt']];
            array_push($articles, $article);
            $raw_launches = $raw_article['launches'];
            $raw_events = $raw_article['events'];
            if (sizeof($raw_launches) > 0) {
                foreach ($raw_launches as $raw_launch) {
                    $launch = ['id' => $raw_launch['id'], 'provider' => $raw_launch['provider'], 'article_id' => $raw_article['id']];
                    array_push($launches, $launch);
                }
            }
            if (sizeof($raw_events) > 0) {
                foreach ($raw_events as $raw_event) {
                    $event = ['id' => $raw_event['id'], 'provider' => $raw_event['provider'], 'article_id' => $raw_article['id']];
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
