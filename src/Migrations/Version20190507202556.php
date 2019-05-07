<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507202556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE leagues (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description CLOB NOT NULL, active BOOLEAN NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE matches (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tournament_id INTEGER DEFAULT NULL, dota_match_id INTEGER NOT NULL, date_played DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_62615BA33D1A3E7 ON matches (tournament_id)');
        $this->addSql('CREATE TABLE match_players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, hero_played_id INTEGER DEFAULT NULL, fantasy_points DOUBLE PRECISION NOT NULL, map_side BOOLEAN NOT NULL, role SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_51E81CC999E6F5DF ON match_players (player_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51E81CC9343CC8F7 ON match_players (hero_played_id)');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE "match"');
        $this->addSql('DROP TABLE match_player');
        $this->addSql('DROP INDEX IDX_A58F176D296CD8AE');
        $this->addSql('DROP INDEX IDX_A58F176D2ABEACD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__match_team AS SELECT match_id, team_id FROM match_team');
        $this->addSql('DROP TABLE match_team');
        $this->addSql('CREATE TABLE match_team (match_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(match_id, team_id), CONSTRAINT FK_A58F176D2ABEACD6 FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A58F176D296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO match_team (match_id, team_id) SELECT match_id, team_id FROM __temp__match_team');
        $this->addSql('DROP TABLE __temp__match_team');
        $this->addSql('CREATE INDEX IDX_A58F176D296CD8AE ON match_team (team_id)');
        $this->addSql('CREATE INDEX IDX_A58F176D2ABEACD6 ON match_team (match_id)');
        $this->addSql('DROP INDEX IDX_CF1B2EF8057B974');
        $this->addSql('DROP INDEX IDX_CF1B2EF2ABEACD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__match_match_player AS SELECT match_id, match_player_id FROM match_match_player');
        $this->addSql('DROP TABLE match_match_player');
        $this->addSql('CREATE TABLE match_match_player (match_id INTEGER NOT NULL, match_player_id INTEGER NOT NULL, PRIMARY KEY(match_id, match_player_id), CONSTRAINT FK_CF1B2EF2ABEACD6 FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CF1B2EF8057B974 FOREIGN KEY (match_player_id) REFERENCES match_players (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO match_match_player (match_id, match_player_id) SELECT match_id, match_player_id FROM __temp__match_match_player');
        $this->addSql('DROP TABLE __temp__match_match_player');
        $this->addSql('CREATE INDEX IDX_CF1B2EF8057B974 ON match_match_player (match_player_id)');
        $this->addSql('CREATE INDEX IDX_CF1B2EF2ABEACD6 ON match_match_player (match_id)');
        $this->addSql('DROP INDEX IDX_264E43A6296CD8AE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__players AS SELECT id, team_id, steam_id, name, team_role, bio_link, draft_cost FROM players');
        $this->addSql('DROP TABLE players');
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER DEFAULT NULL, steam_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL COLLATE BINARY, team_role SMALLINT NOT NULL, bio_link VARCHAR(255) DEFAULT NULL COLLATE BINARY, draft_cost INTEGER NOT NULL, CONSTRAINT FK_264E43A6296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO players (id, team_id, steam_id, name, team_role, bio_link, draft_cost) SELECT id, team_id, steam_id, name, team_role, bio_link, draft_cost FROM __temp__players');
        $this->addSql('DROP TABLE __temp__players');
        $this->addSql('CREATE INDEX IDX_264E43A6296CD8AE ON players (team_id)');
        $this->addSql('DROP INDEX IDX_E8351CEC99E6F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player_stats AS SELECT id, player_id, fantasy_points, date_recorded, match_count FROM player_stats');
        $this->addSql('DROP TABLE player_stats');
        $this->addSql('CREATE TABLE player_stats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, fantasy_points DOUBLE PRECISION NOT NULL, match_count INTEGER NOT NULL, date_recorded DATETIME NOT NULL, CONSTRAINT FK_E8351CEC99E6F5DF FOREIGN KEY (player_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO player_stats (id, player_id, fantasy_points, date_recorded, match_count) SELECT id, player_id, fantasy_points, date_recorded, match_count FROM __temp__player_stats');
        $this->addSql('DROP TABLE __temp__player_stats');
        $this->addSql('CREATE INDEX IDX_E8351CEC99E6F5DF ON player_stats (player_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournaments AS SELECT id, valve_league_id, name, start_date, end_date, fantasy_weight FROM tournaments');
        $this->addSql('DROP TABLE tournaments');
        $this->addSql('CREATE TABLE tournaments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, valve_league_id INTEGER NOT NULL, name CLOB NOT NULL COLLATE BINARY, fantasy_weight DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO tournaments (id, valve_league_id, name, start_date, end_date, fantasy_weight) SELECT id, valve_league_id, name, start_date, end_date, fantasy_weight FROM __temp__tournaments');
        $this->addSql('DROP TABLE __temp__tournaments');
        $this->addSql('DROP INDEX IDX_5A1E3D4833D1A3E7');
        $this->addSql('DROP INDEX IDX_5A1E3D4858AFC4DE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_league AS SELECT tournament_id, league_id FROM tournament_league');
        $this->addSql('DROP TABLE tournament_league');
        $this->addSql('CREATE TABLE tournament_league (tournament_id INTEGER NOT NULL, league_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, league_id), CONSTRAINT FK_5A1E3D4833D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournaments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A1E3D4858AFC4DE FOREIGN KEY (league_id) REFERENCES leagues (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tournament_league (tournament_id, league_id) SELECT tournament_id, league_id FROM __temp__tournament_league');
        $this->addSql('DROP TABLE __temp__tournament_league');
        $this->addSql('CREATE INDEX IDX_5A1E3D4833D1A3E7 ON tournament_league (tournament_id)');
        $this->addSql('CREATE INDEX IDX_5A1E3D4858AFC4DE ON tournament_league (league_id)');
        $this->addSql('DROP INDEX IDX_F36D1421296CD8AE');
        $this->addSql('DROP INDEX IDX_F36D142133D1A3E7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_team AS SELECT tournament_id, team_id FROM tournament_team');
        $this->addSql('DROP TABLE tournament_team');
        $this->addSql('CREATE TABLE tournament_team (tournament_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, team_id), CONSTRAINT FK_F36D142133D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournaments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F36D1421296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tournament_team (tournament_id, team_id) SELECT tournament_id, team_id FROM __temp__tournament_team');
        $this->addSql('DROP TABLE __temp__tournament_team');
        $this->addSql('CREATE INDEX IDX_F36D1421296CD8AE ON tournament_team (team_id)');
        $this->addSql('CREATE INDEX IDX_F36D142133D1A3E7 ON tournament_team (tournament_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE league (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, active BOOLEAN NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE "match" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tournament_id INTEGER DEFAULT NULL, dota_match_id INTEGER NOT NULL, date_played DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_7A5BC50533D1A3E7 ON "match" (tournament_id)');
        $this->addSql('CREATE TABLE match_player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, hero_played_id INTEGER DEFAULT NULL, fantasy_points DOUBLE PRECISION NOT NULL, map_side BOOLEAN NOT NULL, role SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_39768364343CC8F7 ON match_player (hero_played_id)');
        $this->addSql('CREATE INDEX IDX_3976836499E6F5DF ON match_player (player_id)');
        $this->addSql('DROP TABLE leagues');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE match_players');
        $this->addSql('DROP INDEX IDX_A58F176D2ABEACD6');
        $this->addSql('DROP INDEX IDX_A58F176D296CD8AE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__match_team AS SELECT match_id, team_id FROM match_team');
        $this->addSql('DROP TABLE match_team');
        $this->addSql('CREATE TABLE match_team (match_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(match_id, team_id), CONSTRAINT FK_A58F176D2ABEACD6 FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO match_team (match_id, team_id) SELECT match_id, team_id FROM __temp__match_team');
        $this->addSql('DROP TABLE __temp__match_team');
        $this->addSql('CREATE INDEX IDX_A58F176D2ABEACD6 ON match_team (match_id)');
        $this->addSql('CREATE INDEX IDX_A58F176D296CD8AE ON match_team (team_id)');
        $this->addSql('DROP INDEX IDX_E8351CEC99E6F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player_stats AS SELECT id, player_id, fantasy_points, date_recorded, match_count FROM player_stats');
        $this->addSql('DROP TABLE player_stats');
        $this->addSql('CREATE TABLE player_stats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, fantasy_points DOUBLE PRECISION NOT NULL, match_count INTEGER NOT NULL, date_recorded DATETIME NOT NULL)');
        $this->addSql('INSERT INTO player_stats (id, player_id, fantasy_points, date_recorded, match_count) SELECT id, player_id, fantasy_points, date_recorded, match_count FROM __temp__player_stats');
        $this->addSql('DROP TABLE __temp__player_stats');
        $this->addSql('CREATE INDEX IDX_E8351CEC99E6F5DF ON player_stats (player_id)');
        $this->addSql('DROP INDEX IDX_264E43A6296CD8AE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__players AS SELECT id, team_id, steam_id, name, team_role, bio_link, draft_cost FROM players');
        $this->addSql('DROP TABLE players');
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER DEFAULT NULL, steam_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL, team_role SMALLINT NOT NULL, bio_link VARCHAR(255) DEFAULT NULL, draft_cost INTEGER NOT NULL)');
        $this->addSql('INSERT INTO players (id, team_id, steam_id, name, team_role, bio_link, draft_cost) SELECT id, team_id, steam_id, name, team_role, bio_link, draft_cost FROM __temp__players');
        $this->addSql('DROP TABLE __temp__players');
        $this->addSql('CREATE INDEX IDX_264E43A6296CD8AE ON players (team_id)');
        $this->addSql('DROP INDEX IDX_5A1E3D4833D1A3E7');
        $this->addSql('DROP INDEX IDX_5A1E3D4858AFC4DE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_league AS SELECT tournament_id, league_id FROM tournament_league');
        $this->addSql('DROP TABLE tournament_league');
        $this->addSql('CREATE TABLE tournament_league (tournament_id INTEGER NOT NULL, league_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, league_id), CONSTRAINT FK_5A1E3D4858AFC4DE FOREIGN KEY (league_id) REFERENCES leagues (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tournament_league (tournament_id, league_id) SELECT tournament_id, league_id FROM __temp__tournament_league');
        $this->addSql('DROP TABLE __temp__tournament_league');
        $this->addSql('CREATE INDEX IDX_5A1E3D4833D1A3E7 ON tournament_league (tournament_id)');
        $this->addSql('CREATE INDEX IDX_5A1E3D4858AFC4DE ON tournament_league (league_id)');
        $this->addSql('DROP INDEX IDX_F36D142133D1A3E7');
        $this->addSql('DROP INDEX IDX_F36D1421296CD8AE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_team AS SELECT tournament_id, team_id FROM tournament_team');
        $this->addSql('DROP TABLE tournament_team');
        $this->addSql('CREATE TABLE tournament_team (tournament_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, team_id))');
        $this->addSql('INSERT INTO tournament_team (tournament_id, team_id) SELECT tournament_id, team_id FROM __temp__tournament_team');
        $this->addSql('DROP TABLE __temp__tournament_team');
        $this->addSql('CREATE INDEX IDX_F36D142133D1A3E7 ON tournament_team (tournament_id)');
        $this->addSql('CREATE INDEX IDX_F36D1421296CD8AE ON tournament_team (team_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournaments AS SELECT id, valve_league_id, name, start_date, end_date, fantasy_weight FROM tournaments');
        $this->addSql('DROP TABLE tournaments');
        $this->addSql('CREATE TABLE tournaments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, valve_league_id INTEGER NOT NULL, name CLOB NOT NULL, fantasy_weight DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO tournaments (id, valve_league_id, name, start_date, end_date, fantasy_weight) SELECT id, valve_league_id, name, start_date, end_date, fantasy_weight FROM __temp__tournaments');
        $this->addSql('DROP TABLE __temp__tournaments');
    }
}
