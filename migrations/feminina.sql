-- --------------------------------------------------------
-- Servidor:                     192.168.0.150
-- Versão do servidor:           8.0.29-0ubuntu0.20.04.3 - (Ubuntu)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para feminina
CREATE DATABASE IF NOT EXISTS `feminina` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `feminina`;

-- Copiando estrutura para tabela feminina.administrador
CREATE TABLE IF NOT EXISTS `administrador` (
  `idAdministrador` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `salario` double NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estadoCivil` varchar(10) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `nrcasa` varchar(45) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `contato` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`idAdministrador`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.agendamentosavaliacaofisica
CREATE TABLE IF NOT EXISTS `agendamentosavaliacaofisica` (
  `idAgendamentoAvaliacaoFisica` int NOT NULL AUTO_INCREMENT,
  `idInstrutor` int DEFAULT NULL,
  `idAdministrador` int DEFAULT NULL,
  `idProfessor` int DEFAULT NULL,
  `idAluno` int NOT NULL,
  `tipoAvaliacao` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `title` text,
  `color` varchar(45) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`idAgendamentoAvaliacaoFisica`),
  KEY `fk_AgendamentsAvaliacaoFisica_Instrutor_idx` (`idInstrutor`),
  KEY `fk_AgendamentsAvaliacaoFisica_Administrador1_idx` (`idAdministrador`),
  KEY `fk_AgendamentsAvaliacaoFisica_Professor1_idx` (`idProfessor`),
  KEY `fk_AgendamentsAvaliacaoFisica_Aluno` (`idAluno`),
  CONSTRAINT `fk_AgendamentsAvaliacaoFisica_Administrador1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`),
  CONSTRAINT `fk_AgendamentsAvaliacaoFisica_Aluno` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  CONSTRAINT `fk_AgendamentsAvaliacaoFisica_Instrutor` FOREIGN KEY (`idInstrutor`) REFERENCES `instrutor` (`idInstrutor`),
  CONSTRAINT `fk_AgendamentsAvaliacaoFisica_Professor1` FOREIGN KEY (`idProfessor`) REFERENCES `professor` (`idProfessor`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.aluno
CREATE TABLE IF NOT EXISTS `aluno` (
  `idAluno` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estadoCivil` varchar(10) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `nrcasa` varchar(45) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `contato` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  PRIMARY KEY (`idAluno`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;


-- Copiando estrutura para tabela feminina.atividadefisica
CREATE TABLE IF NOT EXISTS `atividadefisica` (
  `idAtividadeFisica` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `ativa` tinyint NOT NULL,
  PRIMARY KEY (`idAtividadeFisica`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.avaliacaofisica
CREATE TABLE IF NOT EXISTS `avaliacaofisica` (
  `idAvaliacaoFisica` int NOT NULL AUTO_INCREMENT,
  `idAgendamentoAvaliacaoFisica` int NOT NULL,
  `nivelaptidaofisica` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `peso` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `altura` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `dores` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `historicosaude` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `desviospostura` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `percentualgordura` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `percentualmassamagra` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `metas` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `objetivo` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `habitosalimentares` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `qualidadesono` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `bebidaalcoolica` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `fumante` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `medicamentos` text,
  PRIMARY KEY (`idAvaliacaoFisica`),
  KEY `fk_AvaliacaoFisica_AgendamentsAvaliacaoFisica1_idx` (`idAgendamentoAvaliacaoFisica`),
  CONSTRAINT `fk_AvaliacaoFisica_AgendamentsAvaliacaoFisica1` FOREIGN KEY (`idAgendamentoAvaliacaoFisica`) REFERENCES `agendamentosavaliacaofisica` (`idAgendamentoAvaliacaoFisica`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;


-- Copiando estrutura para tabela feminina.contrato
CREATE TABLE IF NOT EXISTS `contrato` (
  `idContrato` int NOT NULL AUTO_INCREMENT,
  `idPlano` int DEFAULT NULL,
  `idAluno` int NOT NULL,
  `idFormaPagamento` int DEFAULT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `dataContrato` date NOT NULL,
  `dataCancelamento` date DEFAULT NULL,
  `valor` double NOT NULL,
  `diaPagamento` int NOT NULL,
  PRIMARY KEY (`idContrato`),
  KEY `fk_Matricula_Plano1_idx` (`idPlano`),
  KEY `fk_Matricula_Aluno1_idx` (`idAluno`),
  KEY `fk_contrato_formaPagamento1` (`idFormaPagamento`),
  CONSTRAINT `fk_contrato_Aluno1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  CONSTRAINT `fk_contrato_formaPagamento1` FOREIGN KEY (`idFormaPagamento`) REFERENCES `formapagamento` (`idFormaPagamento`),
  CONSTRAINT `fk_contrato_Plano1` FOREIGN KEY (`idPlano`) REFERENCES `plano` (`idPlano`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.despesa
CREATE TABLE IF NOT EXISTS `despesa` (
  `idDespesa` int NOT NULL AUTO_INCREMENT,
  `idFornecedor` int NOT NULL,
  `idUsuario` int NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo` varchar(45) NOT NULL,
  `dataVencimento` date NOT NULL,
  `valorPagamento` double DEFAULT NULL,
  `dataPagamento` date DEFAULT NULL,
  `valorDespesa` double NOT NULL,
  PRIMARY KEY (`idDespesa`),
  KEY `fk_Despesa_Fornecedor1_idx` (`idFornecedor`),
  KEY `fk_Despesa_Usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_Despesa_Fornecedor1` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`),
  CONSTRAINT `fk_Despesa_Usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.exerciciofisico
CREATE TABLE IF NOT EXISTS `exerciciofisico` (
  `idExercicioFisico` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `idGrupoMuscular` int DEFAULT NULL,
  PRIMARY KEY (`idExercicioFisico`),
  KEY `fk_ExercicioFisico_GrupoMuscular1_idx` (`idGrupoMuscular`),
  CONSTRAINT `fk_ExercicioFisico_GrupoMuscular1` FOREIGN KEY (`idGrupoMuscular`) REFERENCES `grupomuscular` (`idGrupoMuscular`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.formapagamento
CREATE TABLE IF NOT EXISTS `formapagamento` (
  `idFormaPagamento` int NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `pagamentoAutomatico` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`idFormaPagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela feminina.formapagamento: ~7 rows (aproximadamente)
INSERT INTO `formapagamento` (`idFormaPagamento`, `descricao`, `pagamentoAutomatico`) VALUES
	(1, 'Crédito Recorrente', 1),
	(2, 'Crédito', 0),
	(3, 'Dinheiro', 0),
	(4, 'Cheque', 0),
	(5, 'Débito', 0),
	(6, 'Pix', 0),
	(7, 'Transfêrencia', 0);

-- Copiando estrutura para tabela feminina.fornecedor
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `idFornecedor` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `contato` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `pessoaContato` varchar(255) NOT NULL,
  PRIMARY KEY (`idFornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.grupomuscular
CREATE TABLE IF NOT EXISTS `grupomuscular` (
  `idGrupoMuscular` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idGrupoMuscular`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.informacoes_sistema
CREATE TABLE IF NOT EXISTS `informacoes_sistema` (
  `idInformacoes_Sistema` int NOT NULL AUTO_INCREMENT,
  `tituloLogin` text NOT NULL,
  `tituloNavbar` text NOT NULL,
  `nomeSistema` text NOT NULL,
  `cnpj` text NOT NULL,
  `contato` text NOT NULL,
  `email` text NOT NULL,
  `logo` text NOT NULL,
  `rua` text NOT NULL,
  `nrcasa` text NOT NULL,
  `bairro` text NOT NULL,
  `cidade` text NOT NULL,
  `uf` text NOT NULL,
  `pais` text NOT NULL,
  `cep` text NOT NULL,
  PRIMARY KEY (`idInformacoes_Sistema`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.instrutor
CREATE TABLE IF NOT EXISTS `instrutor` (
  `idInstrutor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `salario` double NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estadoCivil` varchar(10) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `nrcasa` varchar(45) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `contato` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `rg` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `dataAdmissao` date NOT NULL,
  `dataDemissao` date DEFAULT NULL,
  PRIMARY KEY (`idInstrutor`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.mensalidade
CREATE TABLE IF NOT EXISTS `mensalidade` (
  `idMensalidade` int NOT NULL AUTO_INCREMENT,
  `idContrato` int NOT NULL,
  `idFormaPagamento` int DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `dataMensalidade` date DEFAULT NULL,
  `dataPagamento` date DEFAULT NULL,
  `mensalidadeCancelada` tinyint DEFAULT '0',
  PRIMARY KEY (`idMensalidade`),
  KEY `fk_mensalidade_contrato` (`idContrato`),
  KEY `fk_mensalidade_formapagamento` (`idFormaPagamento`),
  CONSTRAINT `fk_mensalidade_contrato` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`idContrato`),
  CONSTRAINT `fk_mensalidade_formapagamento` FOREIGN KEY (`idFormaPagamento`) REFERENCES `formapagamento` (`idFormaPagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.mensalidadeatraso
CREATE TABLE IF NOT EXISTS `mensalidadeatraso` (
  `idMensalidadeAtraso` int NOT NULL AUTO_INCREMENT,
  `idAluno` int NOT NULL,
  `idMensalidade` int NOT NULL,
  PRIMARY KEY (`idMensalidadeAtraso`),
  KEY `fk_MensalidadeAtraso_Aluno1_idx` (`idAluno`),
  KEY `fk_MensalidadeAtraso_Mensalidade` (`idMensalidade`),
  CONSTRAINT `fk_MensalidadeAtraso_Aluno1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  CONSTRAINT `fk_MensalidadeAtraso_Mensalidade` FOREIGN KEY (`idMensalidade`) REFERENCES `mensalidade` (`idMensalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para evento feminina.mensalidade_atraso
DELIMITER //
CREATE EVENT `mensalidade_atraso` ON SCHEDULE EVERY 1 DAY STARTS '2022-06-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	
		DECLARE codAluno INT;
		DECLARE codMensalidade INT;
		SELECT al.idAluno from feminina.mensalidade mens
		JOIN feminina.contrato ct ON (mens.idContrato = ct.idContrato)
		JOIN feminina.aluno al ON (al.idAluno = ct.idAluno)
		WHERE dataMensalidade < DATE(NOW()) AND dataPagamento IS NULL INTO codAluno;
		
		SELECT mens.idMensalidade from feminina.mensalidade mens
		JOIN feminina.contrato ct ON (mens.idContrato = ct.idContrato)
		JOIN feminina.aluno al ON (al.idAluno = ct.idAluno)
		WHERE dataMensalidade < DATE(NOW()) AND dataPagamento IS NULL INTO codMensalidade;
		
		INSERT INTO feminina.mensalidadeatraso (idAluno,idMensalidade) VALUES (codAluno,codMensalidade);
	    
	END//
DELIMITER ;

-- Copiando estrutura para tabela feminina.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `idMenu` int NOT NULL AUTO_INCREMENT,
  `classFontAwesome` varchar(255) NOT NULL DEFAULT '0',
  `titulo` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela feminina.menu: ~3 rows (aproximadamente)
INSERT INTO `menu` (`idMenu`, `classFontAwesome`, `titulo`) VALUES
	(1, 'fas fa-tasks', 'Gerenciar'),
	(2, 'fas fa-user', 'Usuarios'),
	(3, 'fas fa-cog', 'Configurações');

-- Copiando estrutura para tabela feminina.plano
CREATE TABLE IF NOT EXISTS `plano` (
  `idPlano` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `valorPadrao` double NOT NULL,
  `percentualDesconto` text NOT NULL,
  `valorComDesconto` double NOT NULL,
  `tipoPlano` int NOT NULL,
  PRIMARY KEY (`idPlano`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;


-- Copiando estrutura para tabela feminina.plano_has_atividadefisica
CREATE TABLE IF NOT EXISTS `plano_has_atividadefisica` (
  `Plano_idPlano` int NOT NULL,
  `AtividadeFisica_idAtividadeFisica` int NOT NULL,
  PRIMARY KEY (`Plano_idPlano`,`AtividadeFisica_idAtividadeFisica`),
  KEY `fk_Plano_has_AtividadeFisica_AtividadeFisica1_idx` (`AtividadeFisica_idAtividadeFisica`),
  KEY `fk_Plano_has_AtividadeFisica_Plano1_idx` (`Plano_idPlano`),
  CONSTRAINT `fk_Plano_has_AtividadeFisica_AtividadeFisica1` FOREIGN KEY (`AtividadeFisica_idAtividadeFisica`) REFERENCES `atividadefisica` (`idAtividadeFisica`),
  CONSTRAINT `fk_Plano_has_AtividadeFisica_Plano1` FOREIGN KEY (`Plano_idPlano`) REFERENCES `plano` (`idPlano`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- Copiando estrutura para tabela feminina.professor
CREATE TABLE IF NOT EXISTS `professor` (
  `idProfessor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `salario` double NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estadoCivil` varchar(10) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `nrcasa` varchar(45) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `contato` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `rg` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `dataAdmissao` date NOT NULL,
  `dataDemissao` date DEFAULT NULL,
  PRIMARY KEY (`idProfessor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.receita
CREATE TABLE IF NOT EXISTS `receita` (
  `idReceita` int NOT NULL AUTO_INCREMENT,
  `origem` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `valor` double NOT NULL,
  `idMensalidade` int DEFAULT NULL,
  `idAgendamentoAvaliacaoFisica` int DEFAULT NULL,
  PRIMARY KEY (`idReceita`),
  KEY `fk_Receita_Mensalidade1_idx` (`idMensalidade`),
  KEY `fk_Receita_AgendamentsAvaliacaoFisica1_idx` (`idAgendamentoAvaliacaoFisica`),
  CONSTRAINT `fk_Receita_AgendamentsAvaliacaoFisica1` FOREIGN KEY (`idAgendamentoAvaliacaoFisica`) REFERENCES `agendamentosavaliacaofisica` (`idAgendamentoAvaliacaoFisica`),
  CONSTRAINT `fk_Receita_Mensalidade1` FOREIGN KEY (`idMensalidade`) REFERENCES `mensalidade` (`idMensalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.submenu
CREATE TABLE IF NOT EXISTS `submenu` (
  `idSubmenu` int NOT NULL AUTO_INCREMENT,
  `idMenu` int NOT NULL DEFAULT '0',
  `url` text NOT NULL,
  `classFontAwesome` varchar(255) NOT NULL DEFAULT '',
  `titulo` varchar(255) NOT NULL DEFAULT '',
  `permissoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`idSubmenu`),
  KEY `idMenuFK` (`idMenu`),
  CONSTRAINT `idMenuFK` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela feminina.submenu: ~14 rows (aproximadamente)
INSERT INTO `submenu` (`idSubmenu`, `idMenu`, `url`, `classFontAwesome`, `titulo`, `permissoes`) VALUES
	(1, 1, '/Gerenciar/Aluno', 'fas fa-user-graduate', 'Alunos', 'Administrador'),
	(2, 1, '/Contrato', 'fas fa-id-card', 'Contratos', 'Administrador'),
	(3, 1, '/Gerenciar/ExercicioFisico', 'fas fa-dumbbell', 'Exercicios Físicos', 'Administrador,Professor'),
	(4, 1, '/Gerenciar/AtividadeFisica', 'fas fa-running', 'Atividades Físicas', 'Administrador,Instrutor'),
	(5, 1, '/Gerenciar/Fornecedor', 'fas fa-truck-moving', 'Fornecedores', 'Administrador,Instrutor,Professor'),
	(6, 1, '/AgendamentoAvaliacao', 'fa-solid fa-calendar-days', 'Agend. Avaliação Física', 'Administrador,Instrutor,Professor'),
	(7, 1, '/Planos', 'fa-solid far fa-wallet', 'Planos', 'Administrador'),
	(8, 1, '/Treinos', 'fa-solid fa-hand-fist', 'Treinos', 'Administrador,Professor,Instrutor'),
	(9, 1, '/Despesas', 'fa-solid fa-cash-register', 'Despesas', 'Administrador'),
	(10, 2, '/Gerenciar/Professor', 'fas fa-chalkboard-teacher', 'Professores', 'Administrador'),
	(11, 2, '/Gerenciar/Instrutor', 'fas fa-chalkboard-teacher', 'Instrutores', 'Administrador'),
	(12, 2, '/Gerenciar/Administrador', 'fas fa-user-cog', 'Administradores', 'Administrador'),
	(13, 3, '/Parametrizacao', 'fas fa-cog', 'Configuração do Sistema', 'Administrador'),
	(14, 1, '/Gerenciar/AvaliacaoFisica', 'fas fa-paste', 'Avaliação Física', 'Administrador,Instrutor,Professor');

-- Copiando estrutura para tabela feminina.treino
CREATE TABLE IF NOT EXISTS `treino` (
  `idTreino` int NOT NULL AUTO_INCREMENT,
  `idContrato` int NOT NULL,
  `data` datetime NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `idAvaliacaoFisica` int DEFAULT NULL,
  PRIMARY KEY (`idTreino`),
  KEY `fk_Treino_Matricula1_idx` (`idContrato`),
  CONSTRAINT `fk_Treino_Contrato1` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`idContrato`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.treino_has_administrador
CREATE TABLE IF NOT EXISTS `treino_has_administrador` (
  `Treino_idTreino` int NOT NULL,
  `Administrador_idAdministrador` int NOT NULL,
  PRIMARY KEY (`Treino_idTreino`,`Administrador_idAdministrador`),
  KEY `fk_Treino_has_Administrador_Administrador1_idx` (`Administrador_idAdministrador`),
  KEY `fk_Treino_has_Administrador_Treino1_idx` (`Treino_idTreino`),
  CONSTRAINT `fk_Treino_has_Administrador_Administrador1` FOREIGN KEY (`Administrador_idAdministrador`) REFERENCES `administrador` (`idAdministrador`),
  CONSTRAINT `fk_Treino_has_Administrador_Treino1` FOREIGN KEY (`Treino_idTreino`) REFERENCES `treino` (`idTreino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.treino_has_exerciciofisico
CREATE TABLE IF NOT EXISTS `treino_has_exerciciofisico` (
  `Treino_idTreino` int NOT NULL,
  `ExercicioFisico_idExercicioFisico` int NOT NULL,
  `series` varchar(255) NOT NULL,
  `repeticoes` varchar(255) NOT NULL,
  `peso` varchar(255) NOT NULL,
  `dia` varchar(50) NOT NULL,
  PRIMARY KEY (`Treino_idTreino`,`ExercicioFisico_idExercicioFisico`),
  KEY `fk_Treino_has_ExercicioFisico_ExercicioFisico1_idx` (`ExercicioFisico_idExercicioFisico`),
  KEY `fk_Treino_has_ExercicioFisico_Treino1_idx` (`Treino_idTreino`),
  CONSTRAINT `fk_Treino_has_ExercicioFisico_ExercicioFisico1` FOREIGN KEY (`ExercicioFisico_idExercicioFisico`) REFERENCES `exerciciofisico` (`idExercicioFisico`),
  CONSTRAINT `fk_Treino_has_ExercicioFisico_Treino1` FOREIGN KEY (`Treino_idTreino`) REFERENCES `treino` (`idTreino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Copiando estrutura para tabela feminina.treino_has_instrutor
CREATE TABLE IF NOT EXISTS `treino_has_instrutor` (
  `Treino_idTreino` int NOT NULL,
  `Instrutor_idInstrutor` int NOT NULL,
  PRIMARY KEY (`Treino_idTreino`,`Instrutor_idInstrutor`),
  KEY `fk_Treino_has_Instrutor_Instrutor1_idx` (`Instrutor_idInstrutor`),
  KEY `fk_Treino_has_Instrutor_Treino1_idx` (`Treino_idTreino`),
  CONSTRAINT `fk_Treino_has_Instrutor_Instrutor1` FOREIGN KEY (`Instrutor_idInstrutor`) REFERENCES `instrutor` (`idInstrutor`),
  CONSTRAINT `fk_Treino_has_Instrutor_Treino1` FOREIGN KEY (`Treino_idTreino`) REFERENCES `treino` (`idTreino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Copiando dados para a tabela feminina.treino_has_instrutor: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela feminina.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `nivel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `dataCadastro` date DEFAULT NULL,
  `usuarioAtivo` tinyint DEFAULT NULL,
  `idAdministrador` int DEFAULT NULL,
  `idProfessor` int DEFAULT NULL,
  `idInstrutor` int DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_Usuario_Administrador1_idx` (`idAdministrador`),
  KEY `fk_Usuario_Professor1_idx` (`idProfessor`),
  KEY `fk_Usuario_Instrutor1_idx` (`idInstrutor`),
  CONSTRAINT `fk_Usuario_Administrador1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`),
  CONSTRAINT `fk_Usuario_Instrutor1` FOREIGN KEY (`idInstrutor`) REFERENCES `instrutor` (`idInstrutor`),
  CONSTRAINT `fk_Usuario_Professor1` FOREIGN KEY (`idProfessor`) REFERENCES `professor` (`idProfessor`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
