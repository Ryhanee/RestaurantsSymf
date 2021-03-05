<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305020241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, prenom VARCHAR(55) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, livreur_id_id INT DEFAULT NULL, passer_id INT DEFAULT NULL, delai_livraison INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, montant_cmd DOUBLE PRECISION DEFAULT NULL, date_cmd DATE DEFAULT NULL, prix_total_liv DOUBLE PRECISION NOT NULL, mode_de_paiment VARCHAR(255) DEFAULT NULL, INDEX IDX_6EEAA67D7E0F7DE (livreur_id_id), INDEX IDX_6EEAA67D53394E8F (passer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consomateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, prenom VARCHAR(55) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, prenom VARCHAR(55) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7E0F7DE FOREIGN KEY (livreur_id_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D53394E8F FOREIGN KEY (passer_id) REFERENCES consomateur (id)');
        $this->addSql('ALTER TABLE emplacement ADD consomateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emplacement ADD CONSTRAINT FK_C0CF65F616BCBFCA FOREIGN KEY (consomateur_id) REFERENCES consomateur (id)');
        $this->addSql('CREATE INDEX IDX_C0CF65F616BCBFCA ON emplacement (consomateur_id)');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F67A41481');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F67A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE livraison ADD possede_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FC835AB29 FOREIGN KEY (possede_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A60C9F1FC835AB29 ON livraison (possede_id)');
        $this->addSql('ALTER TABLE livreur ADD opere_id INT DEFAULT NULL, ADD salaire DOUBLE PRECISION NOT NULL, ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DCE528B00 FOREIGN KEY (opere_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6DCE528B00 ON livreur (opere_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9367A41481');
        $this->addSql('ALTER TABLE menu CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9367A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE plats ADD commande_id INT DEFAULT NULL, CHANGE menus_id menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_854A620A82EA2E54 ON plats (commande_id)');
        $this->addSql('ALTER TABLE restaurant MODIFY id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE restaurant CHANGE author_id author_id INT DEFAULT NULL, CHANGE adresse_resto adresse_resto INT DEFAULT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT NULL, CHANGE id_resto id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FC835AB29');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A82EA2E54');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D53394E8F');
        $this->addSql('ALTER TABLE emplacement DROP FOREIGN KEY FK_C0CF65F616BCBFCA');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE consomateur');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP INDEX IDX_C0CF65F616BCBFCA ON emplacement');
        $this->addSql('ALTER TABLE emplacement DROP consomateur_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F67A41481');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F67A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id_resto)');
        $this->addSql('DROP INDEX UNIQ_A60C9F1FC835AB29 ON livraison');
        $this->addSql('ALTER TABLE livraison DROP possede_id');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DCE528B00');
        $this->addSql('DROP INDEX IDX_EB7A4E6DCE528B00 ON livreur');
        $this->addSql('ALTER TABLE livreur DROP opere_id, DROP salaire, DROP adresse');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9367A41481');
        $this->addSql('ALTER TABLE menu CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9367A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id_resto)');
        $this->addSql('DROP INDEX IDX_854A620A82EA2E54 ON plats');
        $this->addSql('ALTER TABLE plats DROP commande_id, CHANGE menus_id menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE restaurant CHANGE author_id author_id INT DEFAULT NULL, CHANGE adresse_resto adresse_resto INT DEFAULT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE id id_resto INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD PRIMARY KEY (id_resto)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
