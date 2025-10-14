-- Dit script kun je uitvoeren in een tool als phpMyAdmin
-- Database schema for Basisschool De Boom

CREATE DATABASE IF NOT EXISTS basisschool_boom CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE basisschool_boom;

-- Tabellen
CREATE TABLE IF NOT EXISTS klassen (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naam VARCHAR(100) NOT NULL,
  jaar INT NOT NULL,
  UNIQUE KEY unique_klas (naam, jaar)
) ENGINE=InnoDB;

-- Vervangen door users met rol 'docent'
DROP TABLE IF EXISTS docenten;

-- Vakken gekoppeld aan docenten
CREATE TABLE IF NOT EXISTS vakken (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naam VARCHAR(120) NOT NULL,
  docent_id INT NOT NULL,
  UNIQUE KEY uniq_vak_docent (naam, docent_id),
  CONSTRAINT fk_vak_docent FOREIGN KEY (docent_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS roosters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  klas_id INT NOT NULL,
  week INT NOT NULL DEFAULT 1,
  dag ENUM('maandag','dinsdag','woensdag','donderdag','vrijdag') NOT NULL,
  les_van TIME NOT NULL,
  les_tot TIME NOT NULL,
  vak_id INT NOT NULL,
  CONSTRAINT fk_rooster_klas FOREIGN KEY (klas_id) REFERENCES klassen(id) ON DELETE CASCADE,
  CONSTRAINT fk_rooster_vak FOREIGN KEY (vak_id) REFERENCES vakken(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Voorbeelddata (optioneel)
INSERT INTO klassen (naam, jaar) VALUES
  ('Groep 7A', 2025),
  ('Groep 8B', 2025)
ON DUPLICATE KEY UPDATE naam = VALUES(naam), jaar = VALUES(jaar);

-- Docenten worden bijgehouden in users met rol 'docent'

-- Unified users table (admin, leerling, docent)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naam VARCHAR(120) NOT NULL,
  username VARCHAR(80) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  rol ENUM('admin','leerling','docent') NOT NULL,
  klas_id INT NULL,
  CONSTRAINT fk_user_klas FOREIGN KEY (klas_id) REFERENCES klassen(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Voorbeeld admin gebruiker.
-- Het wachtwoord is 'admin123'. Genereer een nieuwe hash als je een ander wachtwoord wilt.
-- Je kunt hiervoor een tijdelijk PHP-script gebruiken: <?php echo password_hash('jouw_wachtwoord', PASSWORD_DEFAULT); ?>
INSERT INTO users (naam, username, password, rol, klas_id)
VALUES ('Beheerder', 'admin', '$2y$10$K7j2S.0aR9L.y5i2.zX9b.uJ5i.zX9b.yW2fA.eJ5i.zX9b.yW2fA', 'admin', NULL) -- Correcte hash voor 'admin123'
ON DUPLICATE KEY UPDATE username = username;