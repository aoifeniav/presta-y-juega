<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210904094930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_request (id INT AUTO_INCREMENT NOT NULL, borrower_id INT NOT NULL, lender_id INT NOT NULL, game_id INT NOT NULL, request_date DATETIME NOT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX IDX_AE55F0B011CE312B (borrower_id), INDEX IDX_AE55F0B0855D3E3D (lender_id), INDEX IDX_AE55F0B0E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_request ADD CONSTRAINT FK_AE55F0B011CE312B FOREIGN KEY (borrower_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_request ADD CONSTRAINT FK_AE55F0B0855D3E3D FOREIGN KEY (lender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_request ADD CONSTRAINT FK_AE55F0B0E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_request');
    }
}
