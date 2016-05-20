<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160516094422 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE body_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(10) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D95AEB4B5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eq_mode_body_type (eq_mode_id INT NOT NULL, body_type_id INT NOT NULL, INDEX IDX_8A84F02C5513CB8A (eq_mode_id), INDEX IDX_8A84F02C2CBA3505 (body_type_id), PRIMARY KEY(eq_mode_id, body_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE special_version_body_type (special_version_id INT NOT NULL, body_type_id INT NOT NULL, INDEX IDX_AB8A3087AFDC03B5 (special_version_id), INDEX IDX_AB8A30872CBA3505 (body_type_id), PRIMARY KEY(special_version_id, body_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eq_mode_body_type ADD CONSTRAINT FK_8A84F02C5513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_body_type ADD CONSTRAINT FK_8A84F02C2CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE special_version_body_type ADD CONSTRAINT FK_AB8A3087AFDC03B5 FOREIGN KEY (special_version_id) REFERENCES special_version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE special_version_body_type ADD CONSTRAINT FK_AB8A30872CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eq_mode_body_type DROP FOREIGN KEY FK_8A84F02C2CBA3505');
        $this->addSql('ALTER TABLE special_version_body_type DROP FOREIGN KEY FK_AB8A30872CBA3505');
        $this->addSql('DROP TABLE body_type');
        $this->addSql('DROP TABLE eq_mode_body_type');
        $this->addSql('DROP TABLE special_version_body_type');
    }
}
