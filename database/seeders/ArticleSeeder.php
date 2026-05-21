<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'NBA Betting Consensus New York Knicks vs Utah Jazz',
                'slug' => 'nba-betting-consensus-knicks-jazz',
                'excerpt' => 'In the impending clash between the New York Knicks and Utah Jazz, the total over 228 points has garnered considerable attention, with an emphatic 85.7% backing from the betting public.',
                'content' => '<p>In the impending clash between the New York Knicks and Utah Jazz, the total over 228 points has garnered considerable attention, with an emphatic 85.7% backing from the betting public.</p><p>This overwhelming support indicates widespread anticipation for a high-scoring affair, potentially fueled by the offensive prowess of both teams.</p><p>The Inspin simulation model, which simulates every NBA game thousands of times, up over 150 units over the last three years. A $100 bettor of our NBA would have netted a profit of $15,000+ and, a $1,000 bettor would have won $150,000+.</p>',
                'category' => 'consensus',
                'sport' => 'NBA',
                'author' => 'Sam Profeta',
                'is_premium' => false,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'NFL Week 13 Prime Time Public Betting Splits',
                'slug' => 'nfl-week-13-prime-time-betting-splits',
                'excerpt' => 'In Week 13 of the season, the two prime time games taking place are the Dallas Cowboys and Indianapolis Colts on Sunday Night Football.',
                'content' => '<p>In Week 13 of the season, the two prime time games taking place are the Dallas Cowboys and Indianapolis Colts on Sunday Night Football and the Tampa Bay Buccaneers and New Orleans Saints on Monday Night Football.</p><p>Looking at the splits for Sunday Night Football, the Cowboys are going into the game as 10.5-point favorites. On the spread, they are looking at a massive 93% of bets on them to cover and taking in 90% of the betting handle.</p>',
                'category' => 'trends',
                'sport' => 'NFL',
                'author' => 'Sam Profeta',
                'is_premium' => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'NBA Betting Consensus Toronto Raptors vs Miami Heat',
                'slug' => 'nba-betting-consensus-raptors-heat',
                'excerpt' => 'The Miami Heat are 7.5-point favorites (-110) as they host the Toronto Raptors, with 62% of the betting public backing Miami to cover.',
                'content' => '<p>The Miami Heat are 7.5-point favorites (-110) as they host the Toronto Raptors, with 62% of the betting public backing Miami to cover. The Heat\'s strong home-court performance and balanced roster led by Jimmy Butler and Bam Adebayo make them a formidable opponent.</p><p>On the other side, Toronto, with their defensive grit and Pascal Siakam\'s leadership, aims to keep the game competitive.</p>',
                'category' => 'consensus',
                'sport' => 'NBA',
                'author' => 'Sam Profeta',
                'is_premium' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'MLB World Series Betting Preview',
                'slug' => 'mlb-world-series-betting-preview',
                'excerpt' => 'A comprehensive look at the World Series betting markets and where the smart money is going.',
                'content' => '<p>As the World Series approaches, bettors are analyzing every angle. From pitching matchups to historical trends, there are plenty of factors to consider when placing your bets on baseball\'s biggest stage.</p><p>Our simulation model has been tracking MLB performance metrics all season and we\'re ready to share our top picks.</p>',
                'category' => 'analysis',
                'sport' => 'MLB',
                'author' => 'INSPIN Staff',
                'is_premium' => false,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'NHL Stanley Cup Playoff Betting Guide',
                'slug' => 'nhl-stanley-cup-playoff-betting-guide',
                'excerpt' => 'Everything you need to know about betting on the Stanley Cup Playoffs.',
                'content' => '<p>The Stanley Cup Playoffs offer some of the most exciting betting opportunities in sports. With best-of-seven series, there are multiple angles to approach your betting strategy.</p><p>Our expert handicappers have been tracking team performance, goaltending matchups, and home/away splits to bring you the best playoff picks.</p>',
                'category' => 'picks',
                'sport' => 'NHL',
                'author' => 'INSPIN Staff',
                'is_premium' => true,
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        Article::factory(10)->create();
    }
}
