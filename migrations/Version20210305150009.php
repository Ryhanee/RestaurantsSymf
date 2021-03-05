<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305150009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE categorie_menu');
        $this->addSql('ALTER TABLE commande CHANGE livreur_id_id livreur_id_id INT DEFAULT NULL, CHANGE passer_id passer_id INT DEFAULT NULL, CHANGE delai_livraison delai_livraison INT DEFAULT NULL, CHANGE montant_cmd montant_cmd DOUBLE PRECISION DEFAULT NULL, CHANGE date_cmd date_cmd DATE DEFAULT NULL, CHANGE mode_de_paiment mode_de_paiment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE emplacement CHANGE consomateur_id consomateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F67A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE livraison ADD possede_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FC835AB29 FOREIGN KEY (possede_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A60C9F1FC835AB29 ON livraison (possede_id)');
        $this->addSql('ALTER TABLE livreur ADD opere_id INT DEFAULT NULL, ADD salaire DOUBLE PRECISION NOT NULL, ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DCE528B00 FOREIGN KEY (opere_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6DCE528B00 ON livreur (opere_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9367A41481');
        $this->addSql('ALTER TABLE menu ADD libelle VARCHAR(255) NOT NULL, CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9367A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE plats ADD commande_id INT DEFAULT NULL, CHANGE menus_id menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_854A620A82EA2E54 ON plats (commande_id)');
        $this->addSql('ALTER TABLE restaurant MODIFY id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE restaurant ADD adresse_resto INT DEFAULT NULL, CHANGE author_id author_id INT DEFAULT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT NULL, CHANGE id_resto id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE6612487 FOREIGN KEY (adresse_resto) REFERENCES emplacement (id_emp)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FE6612487 ON restaurant (adresse_resto)');
        $this->addSql('ALTER TABLE restaurant ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_menu (categorie_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_A2CBDC4CCD7E912 (menu_id), INDEX IDX_A2CBDC4BCF5E72D (categorie_id), PRIMARY KEY(categorie_id, menu_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categorie_menu ADD CONSTRAINT FK_A2CBDC4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_menu ADD CONSTRAINT FK_A2CBDC4CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande CHANGE livreur_id_id livreur_id_id INT DEFAULT NULL, CHANGE passer_id passer_id INT DEFAULT NULL, CHANGE delai_livraison delai_livraison INT DEFAULT NULL, CHANGE montant_cmd montant_cmd DOUBLE PRECISION DEFAULT \'NULL\', CHANGE date_cmd date_cmd DATE DEFAULT \'NULL\', CHANGE mode_de_paiment mode_de_paiment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE emplacement CHANGE consomateur_id consomateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F67A41481');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FC835AB29');
        $this->addSql('DROP INDEX UNIQ_A60C9F1FC835AB29 ON livraison');
        $this->addSql('ALTER TABLE livraison DROP possede_id');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DCE528B00');
        $this->addSql('DROP INDEX IDX_EB7A4E6DCE528B00 ON livreur');
        $this->addSql('ALTER TABLE livreur DROP opere_id, DROP salaire, DROP adresse');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9367A41481');
        $this->addSql('ALTER TABLE menu DROP libelle, CHANGE id_resto id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9367A41481 FOREIGN KEY (id_resto) REFERENCES restaurant (id_resto)');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A82EA2E54');
        $this->addSql('DROP INDEX IDX_854A620A82EA2E54 ON plats');
        $this->addSql('ALTER TABLE plats DROP commande_id, CHANGE menus_id menus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FE6612487');
        $this->addSql('DROP INDEX UNIQ_EB95123FE6612487 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE restaurant DROP adresse_resto, CHANGE author_id author_id INT NOT NULL, CHANGE specialite specialite VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE id id_resto INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD PRIMARY KEY (id_resto)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
