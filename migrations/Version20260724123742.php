<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260724123742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_fidelite (id INT AUTO_INCREMENT NOT NULL, date_creation DATE NOT NULL, solde_points INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, date_commande DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, date_reception DATE NOT NULL, statut_id INT DEFAULT NULL, fournisseur_id INT DEFAULT NULL, INDEX IDX_6EEAA67DF6203804 (statut_id), INDEX IDX_6EEAA67D670C757F (fournisseur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, complement_adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, commande_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_3170B74B82EA2E54 (commande_id), UNIQUE INDEX UNIQ_3170B74BF347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ligne_vente (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prix_unitaire_ht DOUBLE PRECISION NOT NULL, prix_unitaire_ttc DOUBLE PRECISION NOT NULL, taxe_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_8B26C07C1AB947A4 (taxe_id), UNIQUE INDEX UNIQ_8B26C07CF347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mode_paiement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mode_paiement_vente (mode_paiement_id INT NOT NULL, vente_id INT NOT NULL, INDEX IDX_FF561E3F438F5B63 (mode_paiement_id), INDEX IDX_FF561E3F7DC7170A (vente_id), PRIMARY KEY (mode_paiement_id, vente_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mouvement_fidelite (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, points INT NOT NULL, motif VARCHAR(255) DEFAULT NULL, carte_fidelite_id INT DEFAULT NULL, INDEX IDX_6C5E1E3188C332DB (carte_fidelite_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE produit_categorie (produit_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_CDEA88D8F347EFB (produit_id), INDEX IDX_CDEA88D8BCF5E72D (categorie_id), PRIMARY KEY (produit_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE produits_associes (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE produits_associes_produit (produits_associes_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_6AAAACD29E697782 (produits_associes_id), INDEX IDX_6AAAACD2F347EFB (produit_id), PRIMARY KEY (produits_associes_id, produit_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE statut_paiement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stock_mouvement (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, quantite INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, type_mouvement_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_C3CC1AD66B927827 (type_mouvement_id), UNIQUE INDEX UNIQ_C3CC1AD6F347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE taxe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_mouvement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, date DATE NOT NULL, montant_total DOUBLE PRECISION NOT NULL, montant_tva DOUBLE PRECISION NOT NULL, statut_paiement_id INT DEFAULT NULL, INDEX IDX_888A2A4C53E537D1 (statut_paiement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_vente ADD CONSTRAINT FK_8B26C07C1AB947A4 FOREIGN KEY (taxe_id) REFERENCES taxe (id)');
        $this->addSql('ALTER TABLE ligne_vente ADD CONSTRAINT FK_8B26C07CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE mode_paiement_vente ADD CONSTRAINT FK_FF561E3F438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mode_paiement_vente ADD CONSTRAINT FK_FF561E3F7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mouvement_fidelite ADD CONSTRAINT FK_6C5E1E3188C332DB FOREIGN KEY (carte_fidelite_id) REFERENCES carte_fidelite (id)');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits_associes_produit ADD CONSTRAINT FK_6AAAACD29E697782 FOREIGN KEY (produits_associes_id) REFERENCES produits_associes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits_associes_produit ADD CONSTRAINT FK_6AAAACD2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_mouvement ADD CONSTRAINT FK_C3CC1AD66B927827 FOREIGN KEY (type_mouvement_id) REFERENCES type_mouvement (id)');
        $this->addSql('ALTER TABLE stock_mouvement ADD CONSTRAINT FK_C3CC1AD6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C53E537D1 FOREIGN KEY (statut_paiement_id) REFERENCES statut_paiement (id)');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE magasin');
        $this->addSql('ALTER TABLE categorie CHANGE illustration illustration VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD complement_adresse VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD date_creation DATE NOT NULL, ADD carte_fidelite_id INT DEFAULT NULL, DROP complement_dadresse, CHANGE telephone telephone VARCHAR(255) NOT NULL, CHANGE code_postal code_postal VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045588C332DB FOREIGN KEY (carte_fidelite_id) REFERENCES carte_fidelite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045588C332DB ON client (carte_fidelite_id)');
        $this->addSql('ALTER TABLE marque CHANGE logo logo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD actif TINYINT NOT NULL, ADD marque_id INT DEFAULT NULL, DROP stock, CHANGE description description LONGTEXT NOT NULL, CHANGE prix prix_ht DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC274827B9B2 ON produit (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, complement_dadresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, code_postal VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF6203804');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D670C757F');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BF347EFB');
        $this->addSql('ALTER TABLE ligne_vente DROP FOREIGN KEY FK_8B26C07C1AB947A4');
        $this->addSql('ALTER TABLE ligne_vente DROP FOREIGN KEY FK_8B26C07CF347EFB');
        $this->addSql('ALTER TABLE mode_paiement_vente DROP FOREIGN KEY FK_FF561E3F438F5B63');
        $this->addSql('ALTER TABLE mode_paiement_vente DROP FOREIGN KEY FK_FF561E3F7DC7170A');
        $this->addSql('ALTER TABLE mouvement_fidelite DROP FOREIGN KEY FK_6C5E1E3188C332DB');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8F347EFB');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8BCF5E72D');
        $this->addSql('ALTER TABLE produits_associes_produit DROP FOREIGN KEY FK_6AAAACD29E697782');
        $this->addSql('ALTER TABLE produits_associes_produit DROP FOREIGN KEY FK_6AAAACD2F347EFB');
        $this->addSql('ALTER TABLE stock_mouvement DROP FOREIGN KEY FK_C3CC1AD66B927827');
        $this->addSql('ALTER TABLE stock_mouvement DROP FOREIGN KEY FK_C3CC1AD6F347EFB');
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4C53E537D1');
        $this->addSql('DROP TABLE carte_fidelite');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE ligne_vente');
        $this->addSql('DROP TABLE mode_paiement');
        $this->addSql('DROP TABLE mode_paiement_vente');
        $this->addSql('DROP TABLE mouvement_fidelite');
        $this->addSql('DROP TABLE produit_categorie');
        $this->addSql('DROP TABLE produits_associes');
        $this->addSql('DROP TABLE produits_associes_produit');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE statut_paiement');
        $this->addSql('DROP TABLE stock_mouvement');
        $this->addSql('DROP TABLE taxe');
        $this->addSql('DROP TABLE type_mouvement');
        $this->addSql('DROP TABLE vente');
        $this->addSql('ALTER TABLE categorie CHANGE illustration illustration VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045588C332DB');
        $this->addSql('DROP INDEX UNIQ_C744045588C332DB ON client');
        $this->addSql('ALTER TABLE client ADD complement_dadresse VARCHAR(255) DEFAULT NULL, DROP complement_adresse, DROP pays, DROP date_creation, DROP carte_fidelite_id, CHANGE code_postal code_postal VARCHAR(15) NOT NULL, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE marque CHANGE logo logo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274827B9B2');
        $this->addSql('DROP INDEX IDX_29A5EC274827B9B2 ON produit');
        $this->addSql('ALTER TABLE produit ADD stock INT NOT NULL, DROP actif, DROP marque_id, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE prix_ht prix DOUBLE PRECISION NOT NULL');
    }
}
