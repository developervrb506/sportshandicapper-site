<?php

namespace App\Support;

class TeamBranding
{
    /**
     * Team name => [abbreviation, primary color]
     */
    protected static array $teams = [
        // MLB
        'Arizona Diamondbacks' => ['ARI', '#A71930'],
        'Atlanta Braves' => ['ATL', '#CE1141'],
        'Baltimore Orioles' => ['BAL', '#DF4601'],
        'Boston Red Sox' => ['BOS', '#BD3039'],
        'Chicago Cubs' => ['CHC', '#0E3386'],
        'Chicago White Sox' => ['CWS', '#27251F'],
        'Cincinnati Reds' => ['CIN', '#C6011F'],
        'Cleveland Guardians' => ['CLE', '#00385D'],
        'Colorado Rockies' => ['COL', '#33006F'],
        'Detroit Tigers' => ['DET', '#0C2340'],
        'Houston Astros' => ['HOU', '#002D62'],
        'Kansas City Royals' => ['KC', '#004687'],
        'Los Angeles Angels' => ['LAA', '#BA0021'],
        'Los Angeles Dodgers' => ['LAD', '#005A9C'],
        'Miami Marlins' => ['MIA', '#00A3E0'],
        'Milwaukee Brewers' => ['MIL', '#12284B'],
        'Minnesota Twins' => ['MIN', '#002B5C'],
        'New York Mets' => ['NYM', '#002D72'],
        'New York Yankees' => ['NYY', '#003087'],
        'Athletics' => ['ATH', '#003831'],
        'Oakland Athletics' => ['OAK', '#003831'],
        'Philadelphia Phillies' => ['PHI', '#E81828'],
        'Pittsburgh Pirates' => ['PIT', '#FDB827'],
        'San Diego Padres' => ['SD', '#2F241D'],
        'San Francisco Giants' => ['SF', '#FD5A1E'],
        'Seattle Mariners' => ['SEA', '#0C2C56'],
        'St. Louis Cardinals' => ['STL', '#C41E3A'],
        'Tampa Bay Rays' => ['TB', '#092C5C'],
        'Texas Rangers' => ['TEX', '#003278'],
        'Toronto Blue Jays' => ['TOR', '#134A8E'],
        'Washington Nationals' => ['WSH', '#AB0003'],

        // NFL
        'Arizona Cardinals' => ['ARI', '#97233F'],
        'Atlanta Falcons' => ['ATL', '#A71930'],
        'Baltimore Ravens' => ['BAL', '#241773'],
        'Buffalo Bills' => ['BUF', '#00338D'],
        'Carolina Panthers' => ['CAR', '#0085CA'],
        'Chicago Bears' => ['CHI', '#0B162A'],
        'Cincinnati Bengals' => ['CIN', '#FB4F14'],
        'Cleveland Browns' => ['CLE', '#311D00'],
        'Dallas Cowboys' => ['DAL', '#041E42'],
        'Denver Broncos' => ['DEN', '#FB4F14'],
        'Detroit Lions' => ['DET', '#0076B6'],
        'Green Bay Packers' => ['GB', '#203731'],
        'Houston Texans' => ['HOU', '#03202F'],
        'Indianapolis Colts' => ['IND', '#002C5F'],
        'Jacksonville Jaguars' => ['JAX', '#101820'],
        'Kansas City Chiefs' => ['KC', '#E31837'],
        'Las Vegas Raiders' => ['LV', '#000000'],
        'Los Angeles Chargers' => ['LAC', '#0080C6'],
        'Los Angeles Rams' => ['LAR', '#003594'],
        'Miami Dolphins' => ['MIA', '#008E97'],
        'Minnesota Vikings' => ['MIN', '#4F2683'],
        'New England Patriots' => ['NE', '#002244'],
        'New Orleans Saints' => ['NO', '#D3BC8D'],
        'New York Giants' => ['NYG', '#0B2265'],
        'New York Jets' => ['NYJ', '#125740'],
        'Philadelphia Eagles' => ['PHI', '#004C54'],
        'Pittsburgh Steelers' => ['PIT', '#FFB612'],
        'San Francisco 49ers' => ['SF', '#AA0000'],
        'Seattle Seahawks' => ['SEA', '#002244'],
        'Tampa Bay Buccaneers' => ['TB', '#D50A0A'],
        'Tennessee Titans' => ['TEN', '#0C2340'],
        'Washington Commanders' => ['WAS', '#5A1414'],

        // NBA
        'Atlanta Hawks' => ['ATL', '#E03A3E'],
        'Boston Celtics' => ['BOS', '#007A33'],
        'Brooklyn Nets' => ['BKN', '#000000'],
        'Charlotte Hornets' => ['CHA', '#1D1160'],
        'Chicago Bulls' => ['CHI', '#CE1141'],
        'Cleveland Cavaliers' => ['CLE', '#6F263D'],
        'Dallas Mavericks' => ['DAL', '#00538C'],
        'Denver Nuggets' => ['DEN', '#0E2240'],
        'Detroit Pistons' => ['DET', '#C8102E'],
        'Golden State Warriors' => ['GSW', '#1D428A'],
        'Houston Rockets' => ['HOU', '#CE1141'],
        'Indiana Pacers' => ['IND', '#002D62'],
        'LA Clippers' => ['LAC', '#C8102E'],
        'Los Angeles Clippers' => ['LAC', '#C8102E'],
        'Los Angeles Lakers' => ['LAL', '#552583'],
        'Memphis Grizzlies' => ['MEM', '#5D76A9'],
        'Miami Heat' => ['MIA', '#98002E'],
        'Milwaukee Bucks' => ['MIL', '#00471B'],
        'Minnesota Timberwolves' => ['MIN', '#0C2340'],
        'New Orleans Pelicans' => ['NOP', '#0C2340'],
        'New York Knicks' => ['NYK', '#006BB6'],
        'Oklahoma City Thunder' => ['OKC', '#007AC1'],
        'Orlando Magic' => ['ORL', '#0077C0'],
        'Philadelphia 76ers' => ['PHI', '#006BB6'],
        'Phoenix Suns' => ['PHX', '#1D1160'],
        'Portland Trail Blazers' => ['POR', '#E03A3E'],
        'Sacramento Kings' => ['SAC', '#5A2D81'],
        'San Antonio Spurs' => ['SAS', '#8A8D8F'],
        'Toronto Raptors' => ['TOR', '#CE1141'],
        'Utah Jazz' => ['UTA', '#002B5C'],
        'Washington Wizards' => ['WAS', '#002B5C'],

        // NHL
        'Anaheim Ducks' => ['ANA', '#FC4C02'],
        'Utah Hockey Club' => ['UTA', '#71AFE5'],
        'Boston Bruins' => ['BOS', '#FFB81C'],
        'Buffalo Sabres' => ['BUF', '#002654'],
        'Calgary Flames' => ['CGY', '#C8102E'],
        'Carolina Hurricanes' => ['CAR', '#CC0000'],
        'Chicago Blackhawks' => ['CHI', '#CF0A2C'],
        'Colorado Avalanche' => ['COL', '#6F263D'],
        'Columbus Blue Jackets' => ['CBJ', '#002654'],
        'Dallas Stars' => ['DAL', '#006847'],
        'Detroit Red Wings' => ['DET', '#CE1126'],
        'Edmonton Oilers' => ['EDM', '#FF4C00'],
        'Florida Panthers' => ['FLA', '#C8102E'],
        'Los Angeles Kings' => ['LAK', '#111111'],
        'Minnesota Wild' => ['MIN', '#154734'],
        'Montreal Canadiens' => ['MTL', '#AF1E2D'],
        'Nashville Predators' => ['NSH', '#FFB81C'],
        'New Jersey Devils' => ['NJD', '#CE1126'],
        'New York Islanders' => ['NYI', '#00539B'],
        'New York Rangers' => ['NYR', '#0038A8'],
        'Ottawa Senators' => ['OTT', '#C8102E'],
        'Philadelphia Flyers' => ['PHI', '#F74902'],
        'Pittsburgh Penguins' => ['PIT', '#FCB514'],
        'San Jose Sharks' => ['SJS', '#006D75'],
        'Seattle Kraken' => ['SEA', '#99D9D9'],
        'St. Louis Blues' => ['STL', '#003087'],
        'Tampa Bay Lightning' => ['TBL', '#002868'],
        'Toronto Maple Leafs' => ['TOR', '#00205B'],
        'Vancouver Canucks' => ['VAN', '#00205B'],
        'Vegas Golden Knights' => ['VGK', '#B4975A'],
        'Washington Capitals' => ['WSH', '#C8102E'],
        'Winnipeg Jets' => ['WPG', '#041E42'],
    ];

    /**
     * Fallback colors by sport, used when a team isn't in the map above
     * (mainly college teams, which are too numerous to hard-code).
     */
    protected static array $sportFallback = [
        'NFL' => '#3b82f6',
        'NBA' => '#ef4444',
        'MLB' => '#22c55e',
        'NHL' => '#a855f7',
        'NCAAF' => '#22d3ee',
        'NCAAB' => '#22d3ee',
    ];

    /**
     * Get branding info for a team: 2-4 letter badge text, background color,
     * and a readable foreground color for that background.
     */
    public static function forTeam(string $teamName, string $sportTitle): array
    {
        if (isset(self::$teams[$teamName])) {
            [$abbr, $bg] = self::$teams[$teamName];
        } else {
            $abbr = self::guessAbbreviation($teamName);
            $bg = self::$sportFallback[$sportTitle] ?? '#6366F1';
        }

        return [
            'abbr' => $abbr,
            'bg' => $bg,
            'fg' => self::readableTextColor($bg),
        ];
    }

    protected static function guessAbbreviation(string $teamName): string
    {
        $words = preg_split('/\s+/', trim($teamName));

        // An all-caps word (e.g. "USC", "UCLA", "SMU") makes a good abbreviation on its own.
        foreach ($words as $word) {
            $letters = preg_replace('/[^A-Za-z]/', '', $word);
            if ($letters !== '' && $letters === strtoupper($letters) && strlen($letters) >= 2 && strlen($letters) <= 4) {
                return $letters;
            }
        }

        if (count($words) >= 2) {
            $initials = array_map(fn ($w) => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $w), 0, 1)), $words);
            $initials = array_filter($initials);

            return strtoupper(substr(implode('', $initials), 0, 4));
        }

        return strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $teamName), 0, 3));
    }

    protected static function readableTextColor(string $hexColor): string
    {
        $hex = ltrim($hexColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.6 ? '#0a0a0a' : '#F0F0FF';
    }
}
