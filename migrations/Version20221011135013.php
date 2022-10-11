<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011135013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make titles unique';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, rating, image, release_date FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(20) NOT NULL, rating INTEGER NOT NULL, image VARCHAR(255) NOT NULL, release_date DATE NOT NULL --(DC2Type:date_immutable)
        )');
        $this->addSql('INSERT INTO movie (id, title, rating, image, release_date) SELECT id, title, rating, image, release_date FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D5EF26F2B36786B ON movie (title)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, rating, image, release_date FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(20) NOT NULL, rating INTEGER NOT NULL, image VARCHAR(255) NOT NULL, release_date DATE NOT NULL --(DC2Type:date_immutable)
        )');
        $this->addSql('INSERT INTO movie (id, title, rating, image, release_date) SELECT id, title, rating, image, release_date FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
