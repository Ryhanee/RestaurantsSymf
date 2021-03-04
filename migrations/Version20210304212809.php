<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304212809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_menu (categorie_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_A2CBDC4BCF5E72D (categorie_id), INDEX IDX_A2CBDC4CCD7E912 (menu_id), PRIMARY KEY(categorie_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_menu ADD CONSTRAINT FK_A2CBDC4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_menu ADD CONSTRAINT FK_A2CBDC4CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu DROP libelle, CHANGE id_resto id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FE6612487');
        $this->addSql('DROP INDEX UNIQ_EB95123FE6612487 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP adresse_resto, CHANGE author_id author_id INT NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE categorie_menu');
        $this->addSql('ALTER TABLE menu ADD libelle VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD adresse_resto INT DEFAULT NULL, CHANGE author_id author_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE6612487 FOREIGN KEY (adresse_resto) REFERENCES emplacement (id_emp)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FE6612487 ON restaurant (adresse_resto)');
    }
}
