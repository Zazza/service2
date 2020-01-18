<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200117135316 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE url
            (
                id serial PRIMARY KEY NOT NULL,
                url varchar(1024),
                assign varchar(8)
            );');
        $this->addSql('CREATE UNIQUE INDEX url_id_uindex ON url (id);');
        $this->addSql('CREATE UNIQUE INDEX url_assign_uindex ON url (assign);');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE url');
    }
}
