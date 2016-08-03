-- --------------------------------------------------------
-- Servidor:                     138.68.10.225
-- Versão do servidor:           5.5.50-0+deb8u1 - (Debian)
-- OS do Servidor:               debian-linux-gnu
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para jobeval-tests
DROP DATABASE IF EXISTS `jobeval-tests`;
CREATE DATABASE `jobeval-tests` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jobeval-tests`;


-- Copiando estrutura para tabela jobeval.NickContacts
DROP TABLE IF EXISTS `NickContacts`;
CREATE TABLE IF NOT EXISTS `NickContacts` (
  `email` varchar(100) NOT NULL,
  `kind` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  PRIMARY KEY (`email`,`kind`),
  CONSTRAINT `NickContacts_ibfk_1` FOREIGN KEY (`email`) REFERENCES `Nicks` (`email`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela jobeval.Nicks
DROP TABLE IF EXISTS `Nicks`;
CREATE TABLE IF NOT EXISTS `Nicks` (
  `email` varchar(100) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
