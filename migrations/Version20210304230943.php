<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304230943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle_cat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, id_compte INT NOT NULL, pseudo VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id_emp INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id_emp)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, id_resto INT NOT NULL, name_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, INDEX IDX_C53D045F67A41481 (id_resto), INDEX IDX_C53D045F71179CD6 (name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, id_emp INT NOT NULL, code_emp DOUBLE PRECISION NOT NULL, region VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A60C9F1FAFAF5C55 (id_emp), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, id_resto INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_7D053A9367A41481 (id_resto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_categorie (menu_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_503DB100CCD7E912 (menu_id), INDEX IDX_503DB100BCF5E72D (categorie_id), PRIMARY KEY(menu_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plats (id INT AUTO_INCREMENT NOT NULL, menus_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, prix_unitaire NUMERIC(10, 3) NOT NULL, INDEX IDX_854A620A14041B84 (menus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id_resto INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, adresse_resto INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, tel BIGINT NOT NULL, email VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, specialite VARCHAR(255) DEFAULT NULL, INDEX IDX_EB95123FF675F31B (author_id), UNIQUE INDEX UNIQ_EB95123FE6612487 (adresse_resto), PRIMARY KEY(id_resto)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel BIGINT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F67A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id_resto)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F71179CD6 FOREIGN KEY (name_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FAFAF5C55 FOREIGN KEY (id_emp) REFERENCES emplacement (id_emp)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9367A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id_resto)');
        $this->addSql('ALTER TABLE menu_categorie ADD CONSTRAINT FK_503DB100CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_categorie ADD CONSTRAINT FK_503DB100BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A14041B84 FOREIGN KEY (menus_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE6612487 FOREIGN KEY (adresse_resto) REFERENCES emplacement (id_emp)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE menu_categorie DROP FOREIGN KEY FK_503DB100BCF5E72D');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FAFAF5C55');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FE6612487');
        $this->addSql('ALTER TABLE menu_categorie DROP FOREIGN KEY FK_503DB100CCD7E912');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A14041B84');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F67A41481');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9367A41481');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F71179CD6');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FF675F31B');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_categorie');
        $this->addSql('DROP TABLE plats');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE user');
    }
}
