-- MySQL Script generated by MySQL Workbench
-- Tue Aug 13 11:55:21 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `anexo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `anexo` (
  `cd_anexo` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_titulo` VARCHAR(150) NULL DEFAULT NULL,
  `ds_descricao` TEXT NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  `vl_espacamento` DECIMAL(10,0) NOT NULL,
  PRIMARY KEY (`cd_anexo`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estado` (
  `cd_estado` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_estado` VARCHAR(45) NULL DEFAULT NULL,
  `sg_estado` VARCHAR(2) NULL DEFAULT NULL,
  `ic_estado` ENUM('0', '1') NULL,
  PRIMARY KEY (`cd_estado`))
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade` (
  `cd_cidade` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_estado` INT(11) NOT NULL,
  `ds_cidade` VARCHAR(45) NULL DEFAULT NULL,
  `ic_cidade` ENUM('0', '1') NULL,
  PRIMARY KEY (`cd_cidade`),
  INDEX `fk_tcidade_testado1_idx1` (`cd_estado` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 9715
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `documento` (
  `cd_documento` INT(11) NOT NULL,
  `ds_titulo` VARCHAR(150) NULL DEFAULT NULL,
  `ds_descricao` TEXT NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_documento`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `local`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `local` (
  `cd_local` INT(11) NOT NULL,
  `ds_titulo` VARCHAR(100) NOT NULL,
  `ds_descricao` TEXT NOT NULL,
  PRIMARY KEY (`cd_local`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `cd_tipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `nm_tipo_usuario` VARCHAR(45) NOT NULL,
  `status_tipo_usuario` ENUM('0', '1') NOT NULL,
  `ic_profissional` ENUM('sim', 'nao') NULL,
  `ds_tipo_usuario` VARCHAR(255) NULL,
  PRIMARY KEY (`cd_tipo_usuario`),
  UNIQUE INDEX `nm_tipo_usuario_UNIQUE` (`nm_tipo_usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `cd_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_tipo_usuario` INT NOT NULL,
  `cd_chefia` INT(11) NULL,
  `cd_cidade` INT(11) NOT NULL,
  `ic_usuario` ENUM('0','1') NOT NULL DEFAULT '0',
  `nm_usuario` VARCHAR(150) NOT NULL,
  `nm_email` VARCHAR(45) NOT NULL,
  `nm_login` VARCHAR(45) NOT NULL,
  `cd_senha` VARCHAR(50) NULL DEFAULT NULL,
  `ds_telefone` VARCHAR(45) NULL DEFAULT NULL,
  `ds_celular` VARCHAR(45) NULL DEFAULT NULL,
  `cd_cpf` VARCHAR(15) NULL DEFAULT NULL,
  `cd_cnpj` VARCHAR(45) NULL,
  `cd_rg` VARCHAR(15) NULL DEFAULT NULL,
  `dt_nascimento` VARCHAR(10) NULL DEFAULT NULL,
  `ds_endereco` VARCHAR(100) NULL DEFAULT NULL,
  `nm_bairro` VARCHAR(45) NULL,
  `cd_cep` VARCHAR(45) NULL,
  `dt_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ds_crea` VARCHAR(20) NULL DEFAULT NULL,
  `ds_foto_crea` VARCHAR(255) NULL DEFAULT NULL,
  `nm_responsavel` VARCHAR(45) NULL,
  `cd_inscricao_estadual` VARCHAR(45) NULL,
  `ds_material` TEXT NULL,
  `dt_login` DATE NULL,
  `cd_recuperar_senha` VARCHAR(255) NULL,
  `cd_auth` VARCHAR(45) NULL,
  `cd_ip` VARCHAR(45) NULL,
  PRIMARY KEY (`cd_usuario`),
  INDEX `fk_usuario_tipo_usuario1_idx` (`cd_tipo_usuario` ASC),
  INDEX `fk_usuario_usuario1_idx` (`cd_chefia` ASC),
  INDEX `fk_usuario_tcidade1_idx` (`cd_cidade` ASC),
  UNIQUE INDEX `nm_login_UNIQUE` (`nm_login` ASC),
  UNIQUE INDEX `cd_cpf_UNIQUE` (`cd_cpf` ASC),
  UNIQUE INDEX `cd_cnpj_UNIQUE` (`cd_cnpj` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 60
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `pdf_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pdf_config` (
  `cd_pdf_config` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_tipo_config` INT(11) NOT NULL DEFAULT '1',
  `ds_titulo` VARCHAR(150) NOT NULL,
  `ds_rodape` TEXT NOT NULL,
  `ds_cabecalho` TEXT NOT NULL,
  `ds_conteudo` LONGTEXT NOT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_pdf_config`))
ENGINE = InnoDB
AUTO_INCREMENT = 172
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tipo_servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_servico` (
  `cd_tipo_servico` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_pdf_config` INT(11) NOT NULL,
  `cd_modelo_proposta` INT(11) NULL,
  `ds_titulo` VARCHAR(150) NULL DEFAULT NULL,
  `ds_descricao` TEXT NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  `ds_ajuda` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`cd_tipo_servico`),
  INDEX `idx_1` (`cd_situacao` ASC, `cd_tipo_servico` ASC),
  INDEX `fk_ttiposervico_tpdfconfig1_idx` (`cd_pdf_config` ASC),
  INDEX `fk_ttiposervico_tmodeloproposta1_idx` (`cd_modelo_proposta` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 136
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `servico` (
  `cd_servico` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_titulo` VARCHAR(150) NULL DEFAULT NULL,
  `ds_descricao` LONGTEXT NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  `lg_telhado_metalico` SMALLINT(6) NOT NULL DEFAULT '2',
  `lg_estrutura_metalica` SMALLINT(6) NOT NULL DEFAULT '2',
  `lg_terminal_aereo` SMALLINT(6) NOT NULL DEFAULT '2',
  `ds_ajuda` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cd_servico`),
  INDEX `idx_1` (`cd_servico` ASC, `cd_situacao` ASC, `lg_estrutura_metalica` ASC, `lg_telhado_metalico` ASC, `lg_terminal_aereo` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 719
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tipo_edificio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_edificio` (
  `cd_tipo_edificio` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_titulo` VARCHAR(100) NOT NULL,
  `cd_situacao` INT(11) NOT NULL COMMENT '0-inativo, 1-ativo',
  PRIMARY KEY (`cd_tipo_edificio`))
ENGINE = InnoDB
AUTO_INCREMENT = 67
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `modelo_proposta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `modelo_proposta` (
  `cd_modelo_proposta` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_anexo` INT(11) NOT NULL,
  `cd_documento` INT(11) NOT NULL,
  `cd_tipo_servico` INT(11) NOT NULL,
  `cd_local` INT(11) NOT NULL,
  `cd_pdf_config` INT(11) NOT NULL,
  `cd_servico` INT(11) NOT NULL,
  `cd_tipo_edificio` INT(11) NOT NULL,
  `ds_titulo` VARCHAR(150) NOT NULL,
  `ds_forma_pagto` VARCHAR(45) NULL DEFAULT NULL,
  `ds_prazo_inicio` VARCHAR(45) NULL DEFAULT NULL,
  `ds_condicao_pagto` TEXT NOT NULL,
  `ds_prazo_execucao` VARCHAR(45) NULL DEFAULT NULL,
  `ds_impostos` VARCHAR(45) NULL DEFAULT NULL,
  `ds_garantia` VARCHAR(45) NULL DEFAULT NULL,
  `vl_proposta` VARCHAR(20) NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_modelo_proposta`),
  INDEX `fk_tmodeloproposta_tanexo1_idx1` (`cd_anexo` ASC),
  INDEX `fk_tmodeloproposta_tdocumento1_idx1` (`cd_documento` ASC),
  INDEX `fk_tmodeloproposta_ttiposervico1_idx1` (`cd_tipo_servico` ASC),
  INDEX `fk_tmodeloproposta_tlocal1_idx` (`cd_local` ASC),
  INDEX `fk_tmodeloproposta_tpdfconfig1_idx` (`cd_pdf_config` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `proposta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposta` (
  `cd_proposta` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_modelo_proposta` INT(11) NOT NULL,
  `cd_anexo` INT(11) NOT NULL,
  `cd_local` INT(11) NOT NULL,
  `cd_documento` INT(11) NOT NULL,
  `cd_profissional` INT(11) NOT NULL,
  `cd_cliente` INT(11) NOT NULL,
  `cd_tipo_edificio` INT(11) NOT NULL,
  `ic_proposta` ENUM('aberta', 'fechada', 'cancelada') NOT NULL,
  `cd_representante` INT(11) NOT NULL,
  `cd_consideracao` INT(11) NOT NULL,
  `ds_forma_pagto` VARCHAR(255) NULL DEFAULT NULL,
  `ds_prazo_inicio` VARCHAR(255) NULL DEFAULT NULL,
  `ds_prazo_execucao` VARCHAR(255) NULL DEFAULT NULL,
  `ds_impostos` VARCHAR(255) NULL DEFAULT NULL,
  `ds_garantia` VARCHAR(255) NULL DEFAULT NULL,
  `dt_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `vl_proposta` VARCHAR(20) NULL DEFAULT '0',
  `dt_abertura` DATE NULL DEFAULT NULL,
  `dt_fechamento` DATE NULL DEFAULT NULL,
  `dt_cancelamento` DATE NULL DEFAULT NULL,
  `ds_condicao_pagto` TEXT NOT NULL,
  `ds_path_proposta_pdf` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cd_proposta`),
  INDEX `fk_tproposta_tanexo1_idx1` (`cd_anexo` ASC),
  INDEX `fk_tproposta_tlocal1_idx` (`cd_local` ASC),
  INDEX `fk_tproposta_tdocumento1_idx1` (`cd_documento` ASC),
  INDEX `fk_tproposta_tprofissional1_idx1` (`cd_profissional` ASC),
  INDEX `fk_tproposta_tmodeloproposta1_idx` (`cd_modelo_proposta` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3066
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `historico_pdf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `historico_pdf` (
  `cd_historico_pdf` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_proposta` INT(11) NOT NULL,
  `ds_path_pdf` VARCHAR(255) NOT NULL,
  `dt_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cd_historico_pdf`),
  INDEX `fk_thistoricopdf_tproposta_idx` (`cd_proposta` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `area` (
  `cd_area` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_titulo` VARCHAR(150) NOT NULL,
  `ds_cabecalho` TEXT NULL DEFAULT NULL,
  `ds_rodape` TEXT NULL DEFAULT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_area`),
  INDEX `idx_1` (`cd_area` ASC, `cd_situacao` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 979
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `condicao_pagto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `condicao_pagto` (
  `cd_condicao_pagto` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_titulo` VARCHAR(150) NOT NULL,
  `ds_descricao` TEXT NOT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_condicao_pagto`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `config` (
  `cd_config` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_assistente_situacao_inicial` INT(11) NOT NULL,
  `cd_servico_descida` INT(11) NOT NULL,
  PRIMARY KEY (`cd_config`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `followup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `followup` (
  `cd_followup` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_cliente` INT(11) NOT NULL,
  `cd_proposta` INT(11) NOT NULL,
  `dt_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_contato` DATE NOT NULL,
  `ds_assunto` TEXT NULL DEFAULT NULL,
  `ds_resultado` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`cd_followup`),
  INDEX `dtcontato` (`dt_contato` ASC),
  INDEX `fk_tfollowup_tproposta1_idx` (`cd_proposta` ASC),
  INDEX `fk_tfollowup_usuario1_idx` (`cd_cliente` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tipo_laudo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_laudo` (
  `cd_tipo_laudo` INT(11) NOT NULL AUTO_INCREMENT,
  `ds_tipo_laudo` VARCHAR(50) NOT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cd_tipo_laudo`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `laudo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `laudo` (
  `cd_laudo` INT(11) NOT NULL,
  `cd_tipo_laudo` INT(11) NOT NULL,
  `cd_profissional` INT(11) NOT NULL,
  `cd_cliente` INT(11) NOT NULL,
  `cd_cidade` INT(11) NOT NULL,
  `cd_pdf_config` INT(11) NOT NULL,
  `cd_filial` INT(11) NOT NULL,
  `cd_tipo_edificio` INT(11) NOT NULL,
  `cd_engenheiro` INT(11) NOT NULL,
  `dt_cadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_inspecao` DATETIME NULL DEFAULT NULL,
  `ds_endereco` VARCHAR(100) NULL DEFAULT NULL,
  `ds_bairro` VARCHAR(100) NOT NULL COMMENT 'descri????o do local onde se localiza a edifica????o',
  `cd_cep` VARCHAR(10) NULL DEFAULT NULL,
  `ds_local` VARCHAR(100) NULL DEFAULT NULL,
  `ds_inspecao` TEXT NULL DEFAULT NULL,
  `ds_inspecao_vistoria` TEXT NULL DEFAULT NULL,
  `ds_componentes_instalados` TEXT NULL DEFAULT NULL,
  `ds_interpretacao_resultado` TEXT NULL DEFAULT NULL,
  `ds_medidas_eletricas` TEXT NULL DEFAULT NULL,
  `ds_medicoes_eletricas` TEXT NULL DEFAULT NULL,
  `ds_analise_medicoes` TEXT NULL DEFAULT NULL,
  `ds_certificado_calibracao` TEXT NULL DEFAULT NULL,
  `ds_art` TEXT NULL DEFAULT NULL,
  `dsartboleto` VARCHAR(5000) NOT NULL,
  `dsartpagamento` VARCHAR(5000) NULL DEFAULT NULL,
  `dscertificadoconclusao` TEXT NULL DEFAULT NULL,
  `dt_certificado` DATETIME NULL DEFAULT NULL,
  `ds_foto_capa` VARCHAR(255) NULL DEFAULT NULL,
  `ds_path_laudo_pdf` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`cd_laudo`),
  INDEX `fk_tlaudo_ttipolaudo1_idx` (`cd_tipo_laudo` ASC),
  INDEX `fk_tlaudo_tprofissional1_idx` (`cd_profissional` ASC),
  INDEX `fk_tlaudo_tcidade1_idx` (`cd_cidade` ASC),
  INDEX `fk_tlaudo_tpdfconfig1_idx` (`cd_pdf_config` ASC),
  INDEX `fk_tlaudo_cidade1_idx` (`cd_filial` ASC),
  INDEX `fk_tlaudo_usuario1_idx` (`cd_cliente` ASC),
  INDEX `fk_tlaudo_ttipoedificio1_idx` (`cd_tipo_edificio` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `laudo_andamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `laudo_andamento` (
  `cd_laudo` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_laudo_etapa` INT(11) NOT NULL,
  `cd_profissional` INT(11) NOT NULL,
  `dt_realizado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cd_laudo_etapa`, `cd_laudo`),
  INDEX `fk_tlaudoandamento_tprofissional1_idx` (`cd_profissional` ASC),
  INDEX `fk_tlaudoandamento_tlaudo1_idx` (`cd_laudo` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `laudomedicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `laudomedicao` (
  `cd_laudo_medicao` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_laudo` INT(11) NOT NULL,
  `ds_medida` VARCHAR(255) NOT NULL COMMENT 'valor da medi????o (3,5 ohms)',
  `ds_path_foto` VARCHAR(255) NULL DEFAULT NULL,
  `ds_path_foto2` VARCHAR(255) NULL DEFAULT NULL,
  `ds_observacoes` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cd_laudo_medicao`),
  INDEX `fk_tlaudomedicao_tlaudo1_idx` (`cd_laudo` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `laudo_pdf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `laudo_pdf` (
  `cd_laudo_pf` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_laudo` INT(11) NOT NULL,
  `ds_path_pdf` VARCHAR(255) NOT NULL,
  `dt_register` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cd_laudo_pf`),
  INDEX `fk_laudo_pdf_laudo1_idx` (`cd_laudo` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `modelo_proposta_area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `modelo_proposta_area` (
  `cd_proposta_area` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_proposta` INT(11) NOT NULL,
  `cd_area` INT(11) NOT NULL,
  `ds_cabecalho` TEXT NOT NULL,
  `ds_rodape` TEXT NOT NULL,
  `cd_indice` INT(11) NOT NULL,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo 1-ativo ',
  PRIMARY KEY (`cd_proposta_area`),
  INDEX `fk_tmodelopropostaarea_tproposta1_idx` (`cd_proposta` ASC),
  INDEX `fk_tmodelopropostaarea_tarea1_idx` (`cd_area` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `propostaetapa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `propostaetapa` (
  `cd_proposta_etapa` INT(11) NOT NULL,
  `ds_etapa` VARCHAR(50) NULL DEFAULT NULL,
  `cd_ordem` SMALLINT(6) NULL DEFAULT NULL,
  `cd_cor` VARCHAR(6) NULL DEFAULT NULL,
  PRIMARY KEY (`cd_proposta_etapa`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `proposta_andamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposta_andamento` (
  `cd_proposta_andamento` INT NOT NULL AUTO_INCREMENT,
  `cd_proposta` INT(11) NOT NULL,
  `cd_profissional` INT(11) NOT NULL,
  `cd_proposta_etapa` INT(11) NOT NULL,
  `dt_realizado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_tpropostaandamento_tproposta1_idx` (`cd_proposta` ASC),
  INDEX `fk_tpropostaandamento_tprofissional1_idx` (`cd_profissional` ASC),
  INDEX `fk_tpropostaandamento_tpropostaetapa1_idx` (`cd_proposta_etapa` ASC),
  PRIMARY KEY (`cd_proposta_andamento`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `proposta_area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposta_area` (
  `cd_proposta_area` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_area` INT(11) NOT NULL,
  `cd_proposta` INT(11) NOT NULL,
  `cd_anexo` INT(11) NOT NULL,
  `cd_indice` INT(11) NOT NULL,
  `ds_cabecalho` TEXT NOT NULL,
  `ds_rodape` TEXT NOT NULL,
  `cd_telhado_metalico` SMALLINT(6) NOT NULL,
  `cd_estrutura_metalica` SMALLINT(6) NOT NULL,
  `ds_base_calculo` VARCHAR(50) NOT NULL,
  `vl_base_calculo_valor` DECIMAL(8,2) NOT NULL,
  `vl_resultado` DECIMAL(8,2) NOT NULL,
  `lg_estrutura_metalica` SMALLINT(6) NOT NULL DEFAULT '0',
  `lg_telhado_metalico` SMALLINT(6) NOT NULL DEFAULT '0',
  `lg_terminal_aereo` SMALLINT(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cd_proposta_area`),
  INDEX `fk_tpropostaarea_tarea1_idx` (`cd_area` ASC),
  INDEX `fk_tpropostaarea_tproposta1_idx` (`cd_proposta` ASC),
  INDEX `fk_tpropostaarea_tanexo1_idx` (`cd_anexo` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4593
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tpropostaareaservico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpropostaareaservico` (
  `cdpropostaareaservico` INT(11) NOT NULL,
  `cdservico` INT(11) NOT NULL,
  `cdpropostaarea` INT(11) NOT NULL,
  `nrqtde` INT(11) NOT NULL,
  `dsdimensao` VARCHAR(200) NOT NULL,
  `dsobservacao` VARCHAR(500) NOT NULL,
  `cdindice` INT(11) NOT NULL,
  PRIMARY KEY (`cdpropostaareaservico`),
  INDEX `idx_1` (`cdpropostaarea` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 46440
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `proposta_pdf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposta_pdf` (
  `cd_proposta_pdf` INT(11) NOT NULL AUTO_INCREMENT,
  `cd_proposta` INT(11) NOT NULL,
  `ds_path_pdf` VARCHAR(100) NOT NULL,
  `dt_register` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cd_situacao` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '0-inativo, 1-ativo',
  PRIMARY KEY (`cd_proposta_pdf`),
  INDEX `fk_tpropostapdf_tproposta1_idx` (`cd_proposta` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 7627
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `proposta_servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposta_servico` (
  `cd_proposta` INT(11) NOT NULL,
  `cd_servico` INT(11) NOT NULL,
  `nr_qtde` INT(11) NULL DEFAULT '0',
  `ds_dimensao` VARCHAR(200) NOT NULL,
  `ds_observacao` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cd_proposta`, `cd_servico`),
  INDEX `fk_tpropostaservico_tservico1_idx` (`cd_servico` ASC),
  INDEX `fk_tpropostaservico_tproposta1_idx` (`cd_proposta` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `modulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `modulo` (
  `cd_modulo` INT NOT NULL AUTO_INCREMENT,
  `nm_modulo` VARCHAR(45) NULL,
  `ds_modulo` VARCHAR(255) NULL,
  `ic_modulo` ENUM('0', '1') NULL,
  PRIMARY KEY (`cd_modulo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tipo_usuario_modulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_usuario_modulo` (
  `cd_tipo_usuario_modulo` INT NOT NULL AUTO_INCREMENT,
  `tipo_usuario_cd_tipo_usuario` INT NOT NULL,
  `modulo_cd_modulo` INT NOT NULL,
  `nivel_acesso` ENUM('0', '1', '2', '3', '4') NOT NULL DEFAULT '0',
  PRIMARY KEY (`cd_tipo_usuario_modulo`),
  INDEX `fk_tipo_usuario_modulo_tipo_usuario1_idx` (`tipo_usuario_cd_tipo_usuario` ASC),
  INDEX `fk_tipo_usuario_modulo_modulo1_idx` (`modulo_cd_modulo` ASC),
  CONSTRAINT `fk_tipo_usuario_modulo_tipo_usuario1`
    FOREIGN KEY (`tipo_usuario_cd_tipo_usuario`)
    REFERENCES `tipo_usuario` (`cd_tipo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipo_usuario_modulo_modulo1`
    FOREIGN KEY (`modulo_cd_modulo`)
    REFERENCES `modulo` (`cd_modulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
