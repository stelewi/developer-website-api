<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824101406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galaxy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, galaxy_id INT NOT NULL, started_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, INDEX IDX_232B318CB61FAB2 (galaxy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, engine_power DOUBLE PRECISION NOT NULL, cargo_capacity DOUBLE PRECISION NOT NULL, fuel_capacity DOUBLE PRECISION NOT NULL, weapon_power DOUBLE PRECISION NOT NULL, shield_type VARCHAR(255) NOT NULL, shield_power DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planet (id INT AUTO_INCREMENT NOT NULL, star_id INT NOT NULL, name VARCHAR(255) NOT NULL, distance_from_star DOUBLE PRECISION NOT NULL, angle_to_star DOUBLE PRECISION NOT NULL, INDEX IDX_68136AA52C3B70D7 (star_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruit (id INT AUTO_INCREMENT NOT NULL, ship_id INT DEFAULT NULL, station_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, daily_rate BIGINT NOT NULL, skill_weapons INT NOT NULL, skill_engineer INT NOT NULL, skill_charm INT NOT NULL, skill_loyalty INT NOT NULL, INDEX IDX_106B2A6FC256317D (ship_id), INDEX IDX_106B2A6F21BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, name VARCHAR(255) NOT NULL, total_cargo_capacity DOUBLE PRECISION NOT NULL, total_fuel_capacity DOUBLE PRECISION DEFAULT NULL, total_engine_power DOUBLE PRECISION NOT NULL, fuel_amount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_FA30EB2499E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_module (id INT AUTO_INCREMENT NOT NULL, module_id INT NOT NULL, cost BIGINT NOT NULL, INDEX IDX_898600AAAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE star (id INT AUTO_INCREMENT NOT NULL, galaxy_id INT NOT NULL, name VARCHAR(255) NOT NULL, position_x DOUBLE PRECISION NOT NULL, position_y DOUBLE PRECISION NOT NULL, position_z DOUBLE PRECISION NOT NULL, INDEX IDX_C9DB5A14B61FAB2 (galaxy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, planet_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9F39F8B1A25E9820 (planet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CB61FAB2 FOREIGN KEY (galaxy_id) REFERENCES galaxy (id)');
        $this->addSql('ALTER TABLE planet ADD CONSTRAINT FK_68136AA52C3B70D7 FOREIGN KEY (star_id) REFERENCES star (id)');
        $this->addSql('ALTER TABLE recruit ADD CONSTRAINT FK_106B2A6FC256317D FOREIGN KEY (ship_id) REFERENCES ship (id)');
        $this->addSql('ALTER TABLE recruit ADD CONSTRAINT FK_106B2A6F21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB2499E6F5DF FOREIGN KEY (player_id) REFERENCES game_player (id)');
        $this->addSql('ALTER TABLE shop_module ADD CONSTRAINT FK_898600AAAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE star ADD CONSTRAINT FK_C9DB5A14B61FAB2 FOREIGN KEY (galaxy_id) REFERENCES galaxy (id)');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1A25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CB61FAB2');
        $this->addSql('ALTER TABLE planet DROP FOREIGN KEY FK_68136AA52C3B70D7');
        $this->addSql('ALTER TABLE recruit DROP FOREIGN KEY FK_106B2A6FC256317D');
        $this->addSql('ALTER TABLE recruit DROP FOREIGN KEY FK_106B2A6F21BDB235');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB2499E6F5DF');
        $this->addSql('ALTER TABLE shop_module DROP FOREIGN KEY FK_898600AAAFC2B591');
        $this->addSql('ALTER TABLE star DROP FOREIGN KEY FK_C9DB5A14B61FAB2');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1A25E9820');
        $this->addSql('DROP TABLE galaxy');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE planet');
        $this->addSql('DROP TABLE recruit');
        $this->addSql('DROP TABLE ship');
        $this->addSql('DROP TABLE shop_module');
        $this->addSql('DROP TABLE star');
        $this->addSql('DROP TABLE station');
    }
}
