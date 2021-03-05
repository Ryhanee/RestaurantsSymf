<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304230454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livreurs_commandes DROP FOREIGN KEY FK_3781F8098BF5C2E6');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A8BF5C2E6');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CCD98CC79');
        $this->addSql('ALTER TABLE livreurs_commandes DROP FOREIGN KEY FK_3781F809908EE9D4');
        $this->addSql('ALTER TABLE livreurs_livraison DROP FOREIGN KEY FK_A4594F3A908EE9D4');
        $this->addSql('CREATE TABLE emplacement (id_emp INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id_emp)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_categorie (menu_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_503DB100CCD7E912 (menu_id), INDEX IDX_503DB100BCF5E72D (categorie_id), PRIMARY KEY(menu_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_categorie ADD CONSTRAINT FK_503DB100CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_categorie ADD CONSTRAINT FK_503DB100BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE consommateurs');
        $this->addSql('DROP TABLE livreurs');
        $this->addSql('DROP TABLE livreurs_commandes');
        $this->addSql('DROP TABLE livreurs_livraison');
        $this->addSql('DROP TABLE personne');
        $this->addSql('ALTER TABLE livraison ADD id_emp INT NOT NULL, ADD code_emp DOUBLE PRECISION NOT NULL, ADD region VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FAFAF5C55 FOREIGN KEY (id_emp) REFERENCES emplacement (id_emp)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A60C9F1FAFAF5C55 ON livraison (id_emp)');
        $this->addSql('ALTER TABLE menu ADD libelle VARCHAR(255) NOT NULL, CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620ABF396750');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620AC54C8C93');
        $this->addSql('DROP INDEX IDX_854A620AC54C8C93 ON plats');
        $this->addSql('DROP INDEX IDX_854A620A8BF5C2E6 ON plats');
        $this->addSql('ALTER TABLE plats ADD menus_id INT DEFAULT NULL, DROP type_id, DROP commandes_id');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A14041B84 FOREIGN KEY (menus_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_854A620A14041B84 ON plats (menus_id)');
        $this->addSql('ALTER TABLE restaurant ADD adresse_resto INT DEFAULT NULL, CHANGE author_id author_id INT DEFAULT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE6612487 FOREIGN KEY (adresse_resto) REFERENCES emplacement (id_emp)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FE6612487 ON restaurant (adresse_resto)');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FAFAF5C55');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FE6612487');
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, tel BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, consommateurs_id INT NOT NULL, livraison_id INT NOT NULL, delais_livraison INT NOT NULL, datecmd DATE NOT NULL, modepaiement VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, montant_cmd DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_35D4282CCD98CC79 (consommateurs_id), INDEX IDX_35D4282C8E54FB25 (livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE consommateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, tel BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livreurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, tel BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livreurs_commandes (livreurs_id INT NOT NULL, commandes_id INT NOT NULL, INDEX IDX_3781F8098BF5C2E6 (commandes_id), INDEX IDX_3781F809908EE9D4 (livreurs_id), PRIMARY KEY(livreurs_id, commandes_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livreurs_livraison (livreurs_id INT NOT NULL, livraison_id INT NOT NULL, INDEX IDX_A4594F3A8E54FB25 (livraison_id), INDEX IDX_A4594F3A908EE9D4 (livreurs_id), PRIMARY KEY(livreurs_id, livraison_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, tel BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CCD98CC79 FOREIGN KEY (consommateurs_id) REFERENCES consommateurs (id)');
        $this->addSql('ALTER TABLE livreurs_commandes ADD CONSTRAINT FK_3781F8098BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livreurs_commandes ADD CONSTRAINT FK_3781F809908EE9D4 FOREIGN KEY (livreurs_id) REFERENCES livreurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livreurs_livraison ADD CONSTRAINT FK_A4594F3A8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livreurs_livraison ADD CONSTRAINT FK_A4594F3A908EE9D4 FOREIGN KEY (livreurs_id) REFERENCES livreurs (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu_categorie');
        $this->addSql('DROP INDEX UNIQ_A60C9F1FAFAF5C55 ON livraison');
        $this->addSql('ALTER TABLE livraison DROP id_emp, DROP code_emp, DROP region');
        $this->addSql('ALTER TABLE menu DROP libelle, CHANGE id_resto id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A14041B84');
        $this->addSql('DROP INDEX IDX_854A620A14041B84 ON plats');
        $this->addSql('ALTER TABLE plats ADD type_id INT NOT NULL, ADD commandes_id INT NOT NULL, DROP menus_id');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A8BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620ABF396750 FOREIGN KEY (id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620AC54C8C93 FOREIGN KEY (type_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_854A620AC54C8C93 ON plats (type_id)');
        $this->addSql('CREATE INDEX IDX_854A620A8BF5C2E6 ON plats (commandes_id)');
        $this->addSql('DROP INDEX UNIQ_EB95123FE6612487 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP adresse_resto, CHANGE author_id author_id INT NOT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user DROP username');
    }
}
