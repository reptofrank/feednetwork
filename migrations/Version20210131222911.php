<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131222911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content ADD feed_id INT NOT NULL');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A951A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id)');
        $this->addSql('CREATE INDEX IDX_FEC530A951A5BC03 ON content (feed_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A951A5BC03');
        $this->addSql('DROP INDEX IDX_FEC530A951A5BC03 ON content');
        $this->addSql('ALTER TABLE content DROP feed_id');
    }
}
