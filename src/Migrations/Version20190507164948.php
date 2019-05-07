<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507164948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE heroes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(80) NOT NULL, img VARCHAR(128) DEFAULT NULL, img_tiny VARCHAR(128) DEFAULT NULL)');
        $this->addSql('CREATE TABLE "match" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tournament_id INTEGER DEFAULT NULL, dota_match_id INTEGER NOT NULL, date_played DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_7A5BC50533D1A3E7 ON "match" (tournament_id)');
        $this->addSql('CREATE TABLE match_team (match_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(match_id, team_id))');
        $this->addSql('CREATE INDEX IDX_A58F176D2ABEACD6 ON match_team (match_id)');
        $this->addSql('CREATE INDEX IDX_A58F176D296CD8AE ON match_team (team_id)');
        $this->addSql('CREATE TABLE match_match_player (match_id INTEGER NOT NULL, match_player_id INTEGER NOT NULL, PRIMARY KEY(match_id, match_player_id))');
        $this->addSql('CREATE INDEX IDX_CF1B2EF2ABEACD6 ON match_match_player (match_id)');
        $this->addSql('CREATE INDEX IDX_CF1B2EF8057B974 ON match_match_player (match_player_id)');
        $this->addSql('CREATE TABLE match_player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, hero_played_id INTEGER DEFAULT NULL, fantasy_points DOUBLE PRECISION NOT NULL, map_side BOOLEAN NOT NULL, role SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_3976836499E6F5DF ON match_player (player_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_39768364343CC8F7 ON match_player (hero_played_id)');
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER DEFAULT NULL, steam_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL, team_role SMALLINT NOT NULL, bio_link VARCHAR(255) DEFAULT NULL, draft_cost INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_264E43A6296CD8AE ON players (team_id)');
        $this->addSql('CREATE TABLE player_stats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, fantasy_points DOUBLE PRECISION NOT NULL, date_recorded DATETIME NOT NULL, match_count INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E8351CEC99E6F5DF ON player_stats (player_id)');
        $this->addSql('CREATE TABLE teams (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(80) NOT NULL, logo VARCHAR(128) DEFAULT NULL)');
        $this->addSql('CREATE TABLE tournaments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, valve_league_id INTEGER NOT NULL, name CLOB NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, fantasy_weight DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE tournament_team (tournament_id INTEGER NOT NULL, team_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, team_id))');
        $this->addSql('CREATE INDEX IDX_F36D142133D1A3E7 ON tournament_team (tournament_id)');
        $this->addSql('CREATE INDEX IDX_F36D1421296CD8AE ON tournament_team (team_id)');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('CREATE TEMPORARY TABLE __temp__league AS SELECT id, name, description, active, start_date, end_date FROM league');
        $this->addSql('DROP TABLE league');
        $this->addSql('CREATE TABLE league (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, active BOOLEAN NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO league (id, name, description, active, start_date, end_date) SELECT id, name, description, active, start_date, end_date FROM __temp__league');
        $this->addSql('DROP TABLE __temp__league');
        $this->addSql('DROP INDEX IDX_5A1E3D4858AFC4DE');
        $this->addSql('DROP INDEX IDX_5A1E3D4833D1A3E7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_league AS SELECT tournament_id, league_id FROM tournament_league');
        $this->addSql('DROP TABLE tournament_league');
        $this->addSql('CREATE TABLE tournament_league (tournament_id INTEGER NOT NULL, league_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, league_id), CONSTRAINT FK_5A1E3D4833D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournaments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A1E3D4858AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tournament_league (tournament_id, league_id) SELECT tournament_id, league_id FROM __temp__tournament_league');
        $this->addSql('DROP TABLE __temp__tournament_league');
        $this->addSql('CREATE INDEX IDX_5A1E3D4858AFC4DE ON tournament_league (league_id)');
        $this->addSql('CREATE INDEX IDX_5A1E3D4833D1A3E7 ON tournament_league (tournament_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, steam_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL COLLATE BINARY, team_role SMALLINT NOT NULL, bio_link VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('CREATE TABLE tournament (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, valve_league_id INTEGER NOT NULL, name CLOB NOT NULL COLLATE BINARY, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('DROP TABLE heroes');
        $this->addSql('DROP TABLE "match"');
        $this->addSql('DROP TABLE match_team');
        $this->addSql('DROP TABLE match_match_player');
        $this->addSql('DROP TABLE match_player');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE player_stats');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE tournaments');
        $this->addSql('DROP TABLE tournament_team');
        $this->addSql('CREATE TEMPORARY TABLE __temp__league AS SELECT id, name, description, active, start_date, end_date FROM league');
        $this->addSql('DROP TABLE league');
        $this->addSql('CREATE TABLE league (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description CLOB NOT NULL, active BOOLEAN NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO league (id, name, description, active, start_date, end_date) SELECT id, name, description, active, start_date, end_date FROM __temp__league');
        $this->addSql('DROP TABLE __temp__league');
        $this->addSql('DROP INDEX IDX_5A1E3D4833D1A3E7');
        $this->addSql('DROP INDEX IDX_5A1E3D4858AFC4DE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_league AS SELECT tournament_id, league_id FROM tournament_league');
        $this->addSql('DROP TABLE tournament_league');
        $this->addSql('CREATE TABLE tournament_league (tournament_id INTEGER NOT NULL, league_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, league_id), CONSTRAINT FK_5A1E3D4833D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournaments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tournament_league (tournament_id, league_id) SELECT tournament_id, league_id FROM __temp__tournament_league');
        $this->addSql('DROP TABLE __temp__tournament_league');
        $this->addSql('CREATE INDEX IDX_5A1E3D4833D1A3E7 ON tournament_league (tournament_id)');
        $this->addSql('CREATE INDEX IDX_5A1E3D4858AFC4DE ON tournament_league (league_id)');
    }
}
