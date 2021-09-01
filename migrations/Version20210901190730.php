<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901190730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, min_players SMALLINT DEFAULT NULL, max_players SMALLINT DEFAULT NULL, min_age SMALLINT DEFAULT NULL, min_playtime SMALLINT DEFAULT NULL, max_playtime SMALLINT DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, year_published INT DEFAULT NULL, INDEX IDX_232B318C7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, borrower_id INT NOT NULL, lender_id INT NOT NULL, game_id INT NOT NULL, operation_id INT NOT NULL, recall_date DATE NOT NULL, due_date DATE NOT NULL, return_date DATE DEFAULT NULL, INDEX IDX_1981A66D11CE312B (borrower_id), INDEX IDX_1981A66D855D3E3D (lender_id), INDEX IDX_1981A66DE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(255) NOT NULL, rating INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D11CE312B FOREIGN KEY (borrower_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D855D3E3D FOREIGN KEY (lender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DE48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7E3C61F9');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D11CE312B');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D855D3E3D');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE user');
    }
}
