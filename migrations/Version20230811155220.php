<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230811155220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_player (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, player_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E52CD7ADA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_player_score (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, value INT NOT NULL, date_created DATETIME NOT NULL, UNIQUE INDEX UNIQ_633B787999E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_player ADD CONSTRAINT FK_E52CD7ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_player_score ADD CONSTRAINT FK_633B787999E6F5DF FOREIGN KEY (player_id) REFERENCES game_player (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_player DROP FOREIGN KEY FK_E52CD7ADA76ED395');
        $this->addSql('ALTER TABLE game_player_score DROP FOREIGN KEY FK_633B787999E6F5DF');
        $this->addSql('DROP TABLE game_player');
        $this->addSql('DROP TABLE game_player_score');
    }
}
