<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            // NFL (selected teams)
            ['team_name' => 'New England Patriots', 'sport' => 'NFL', 'abbreviation' => 'NE'],
            ['team_name' => 'Kansas City Chiefs', 'sport' => 'NFL', 'abbreviation' => 'KC'],
            ['team_name' => 'Buffalo Bills', 'sport' => 'NFL', 'abbreviation' => 'BUF'],
            ['team_name' => 'Cincinnati Bengals', 'sport' => 'NFL', 'abbreviation' => 'CIN'],
            ['team_name' => 'Philadelphia Eagles', 'sport' => 'NFL', 'abbreviation' => 'PHI'],
            ['team_name' => 'San Francisco 49ers', 'sport' => 'NFL', 'abbreviation' => 'SF'],
            ['team_name' => 'Dallas Cowboys', 'sport' => 'NFL', 'abbreviation' => 'DAL'],
            ['team_name' => 'Miami Dolphins', 'sport' => 'NFL', 'abbreviation' => 'MIA'],
            ['team_name' => 'Baltimore Ravens', 'sport' => 'NFL', 'abbreviation' => 'BAL'],
            ['team_name' => 'Detroit Lions', 'sport' => 'NFL', 'abbreviation' => 'DET'],
            
            // NBA
            ['team_name' => 'Los Angeles Lakers', 'sport' => 'NBA', 'abbreviation' => 'LAL'],
            ['team_name' => 'Boston Celtics', 'sport' => 'NBA', 'abbreviation' => 'BOS'],
            ['team_name' => 'Golden State Warriors', 'sport' => 'NBA', 'abbreviation' => 'GSW'],
            ['team_name' => 'Milwaukee Bucks', 'sport' => 'NBA', 'abbreviation' => 'MIL'],
            ['team_name' => 'Phoenix Suns', 'sport' => 'NBA', 'abbreviation' => 'PHX'],
            ['team_name' => 'Denver Nuggets', 'sport' => 'NBA', 'abbreviation' => 'DEN'],
            ['team_name' => 'Miami Heat', 'sport' => 'NBA', 'abbreviation' => 'MIA'],
            ['team_name' => 'Philadelphia 76ers', 'sport' => 'NBA', 'abbreviation' => 'PHI'],
            ['team_name' => 'Dallas Mavericks', 'sport' => 'NBA', 'abbreviation' => 'DAL'],
            ['team_name' => 'Cleveland Cavaliers', 'sport' => 'NBA', 'abbreviation' => 'CLE'],
            
            // MLB
            ['team_name' => 'New York Yankees', 'sport' => 'MLB', 'abbreviation' => 'NYY'],
            ['team_name' => 'Los Angeles Dodgers', 'sport' => 'MLB', 'abbreviation' => 'LAD'],
            ['team_name' => 'Boston Red Sox', 'sport' => 'MLB', 'abbreviation' => 'BOS'],
            ['team_name' => 'Houston Astros', 'sport' => 'MLB', 'abbreviation' => 'HOU'],
            ['team_name' => 'Atlanta Braves', 'sport' => 'MLB', 'abbreviation' => 'ATL'],
            ['team_name' => 'Chicago Cubs', 'sport' => 'MLB', 'abbreviation' => 'CHC'],
            ['team_name' => 'St. Louis Cardinals', 'sport' => 'MLB', 'abbreviation' => 'STL'],
            ['team_name' => 'San Francisco Giants', 'sport' => 'MLB', 'abbreviation' => 'SF'],
            ['team_name' => 'New York Mets', 'sport' => 'MLB', 'abbreviation' => 'NYM'],
            ['team_name' => 'Philadelphia Phillies', 'sport' => 'MLB', 'abbreviation' => 'PHI'],
            
            // NHL
            ['team_name' => 'Boston Bruins', 'sport' => 'NHL', 'abbreviation' => 'BOS'],
            ['team_name' => 'Colorado Avalanche', 'sport' => 'NHL', 'abbreviation' => 'COL'],
            ['team_name' => 'Tampa Bay Lightning', 'sport' => 'NHL', 'abbreviation' => 'TBL'],
            ['team_name' => 'Edmonton Oilers', 'sport' => 'NHL', 'abbreviation' => 'EDM'],
            ['team_name' => 'Toronto Maple Leafs', 'sport' => 'NHL', 'abbreviation' => 'TOR'],
            ['team_name' => 'New York Rangers', 'sport' => 'NHL', 'abbreviation' => 'NYR'],
            ['team_name' => 'Dallas Stars', 'sport' => 'NHL', 'abbreviation' => 'DAL'],
            ['team_name' => 'Carolina Hurricanes', 'sport' => 'NHL', 'abbreviation' => 'CAR'],
            ['team_name' => 'Florida Panthers', 'sport' => 'NHL', 'abbreviation' => 'FLA'],
            ['team_name' => 'Vegas Golden Knights', 'sport' => 'NHL', 'abbreviation' => 'VGK'],
            
            // NCAAF (College Football) - selected teams
            ['team_name' => 'Alabama Crimson Tide', 'sport' => 'NCAAF', 'abbreviation' => 'ALA'],
            ['team_name' => 'Georgia Bulldogs', 'sport' => 'NCAAF', 'abbreviation' => 'UGA'],
            ['team_name' => 'Ohio State Buckeyes', 'sport' => 'NCAAF', 'abbreviation' => 'OSU'],
            ['team_name' => 'Michigan Wolverines', 'sport' => 'NCAAF', 'abbreviation' => 'MICH'],
            ['team_name' => 'Clemson Tigers', 'sport' => 'NCAAF', 'abbreviation' => 'CLEM'],
            ['team_name' => 'LSU Tigers', 'sport' => 'NCAAF', 'abbreviation' => 'LSU'],
            ['team_name' => 'Oklahoma Sooners', 'sport' => 'NCAAF', 'abbreviation' => 'OU'],
            ['team_name' => 'Texas Longhorns', 'sport' => 'NCAAF', 'abbreviation' => 'TEX'],
            ['team_name' => 'Notre Dame Fighting Irish', 'sport' => 'NCAAF', 'abbreviation' => 'ND'],
            ['team_name' => 'USC Trojans', 'sport' => 'NCAAF', 'abbreviation' => 'USC'],
            
            // NCAAB (College Basketball) - selected teams
            ['team_name' => 'Duke Blue Devils', 'sport' => 'NCAAB', 'abbreviation' => 'DUKE'],
            ['team_name' => 'North Carolina Tar Heels', 'sport' => 'NCAAB', 'abbreviation' => 'UNC'],
            ['team_name' => 'Kentucky Wildcats', 'sport' => 'NCAAB', 'abbreviation' => 'UK'],
            ['team_name' => 'Kansas Jayhawks', 'sport' => 'NCAAB', 'abbreviation' => 'KU'],
            ['team_name' => 'Gonzaga Bulldogs', 'sport' => 'NCAAB', 'abbreviation' => 'GONZ'],
            ['team_name' => 'Villanova Wildcats', 'sport' => 'NCAAB', 'abbreviation' => 'VILL'],
            ['team_name' => 'Baylor Bears', 'sport' => 'NCAAB', 'abbreviation' => 'BAY'],
            ['team_name' => 'Houston Cougars', 'sport' => 'NCAAB', 'abbreviation' => 'HOU'],
            ['team_name' => 'Arizona Wildcats', 'sport' => 'NCAAB', 'abbreviation' => 'ARIZ'],
            ['team_name' => 'UCLA Bruins', 'sport' => 'NCAAB', 'abbreviation' => 'UCLA'],
        ];

        foreach ($teams as $team) {
            \App\Models\TeamLogo::create([
                'team_name' => $team['team_name'],
                'sport' => $team['sport'],
                'abbreviation' => $team['abbreviation'],
                'logo_path' => null, // Will be uploaded later via admin
                'is_active' => true,
            ]);
        }

        $this->command->info('Team logos seeded with ' . count($teams) . ' teams across all sports.');
    }
}
