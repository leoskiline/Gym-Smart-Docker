DELIMITER //
CREATE 
	EVENT `mensalidade_atraso` 
	ON SCHEDULE EVERY 1 DAY STARTS DATE(NOW()) + INTERVAL 1 DAY
	DO BEGIN
	
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