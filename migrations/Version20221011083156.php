<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221011083156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create genre and movie tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(20) NOT NULL)');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(20) NOT NULL, rating INTEGER NOT NULL, image VARCHAR(255) NOT NULL, release_date DATE NOT NULL --(DC2Type:date_immutable)
        )');
        $this->addSql('CREATE TABLE movie_genre (movie_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY(movie_id, genre_id), CONSTRAINT FK_FD1229648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FD1229644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FD1229648F93B6FC ON movie_genre (movie_id)');
        $this->addSql('CREATE INDEX IDX_FD1229644296D31F ON movie_genre (genre_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_genre');
    }
}
