<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160505130311 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eq_mode_accuracy (eq_mode_id INT NOT NULL, accuracy_id INT NOT NULL, INDEX IDX_FECD54715513CB8A (eq_mode_id), INDEX IDX_FECD5471A8A986A6 (accuracy_id), PRIMARY KEY(eq_mode_id, accuracy_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eq_mode_accuracy ADD CONSTRAINT FK_FECD54715513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_accuracy ADD CONSTRAINT FK_FECD5471A8A986A6 FOREIGN KEY (accuracy_id) REFERENCES accuracy (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE eq_mode_accuracy');
    }
}
