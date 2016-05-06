<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160506094015 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eq_mode_special_version (eq_mode_id INT NOT NULL, special_version_id INT NOT NULL, INDEX IDX_CDA048645513CB8A (eq_mode_id), INDEX IDX_CDA04864AFDC03B5 (special_version_id), PRIMARY KEY(eq_mode_id, special_version_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE special_version (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_67108F565E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eq_mode_special_version ADD CONSTRAINT FK_CDA048645513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_special_version ADD CONSTRAINT FK_CDA04864AFDC03B5 FOREIGN KEY (special_version_id) REFERENCES special_version (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eq_mode_special_version DROP FOREIGN KEY FK_CDA04864AFDC03B5');
        $this->addSql('DROP TABLE eq_mode_special_version');
        $this->addSql('DROP TABLE special_version');
    }
}
