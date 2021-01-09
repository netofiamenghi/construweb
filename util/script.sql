CREATE TABLE `cliente` (
  `cli_id` int(11) NOT NULL,
  `cli_tipo_pessoa` varchar(15) DEFAULT NULL,
  `cli_cnpj` varchar(20) DEFAULT NULL,
  `cli_cpf` varchar(15) DEFAULT NULL,
  `cli_ie` varchar(15) DEFAULT NULL,
  `cli_rg` varchar(15) DEFAULT NULL,
  `cli_emissor_rg` varchar(15) DEFAULT NULL,
  `cli_nome` varchar(200) DEFAULT NULL,
  `cli_fantasia` varchar(150) DEFAULT NULL,
  `cli_logradouro` varchar(200) DEFAULT NULL,
  `cli_numero` varchar(10) DEFAULT NULL,
  `cli_complemento` varchar(100) DEFAULT NULL,
  `cli_bairro` varchar(100) DEFAULT NULL,
  `cli_cep` varchar(10) DEFAULT NULL,
  `cli_cidade` varchar(100) DEFAULT NULL,
  `cli_contato` varchar(100) DEFAULT NULL,
  `cli_estado` varchar(50) DEFAULT NULL,
  `cli_telefone` varchar(20) DEFAULT NULL,
  `cli_celular` varchar(20) DEFAULT NULL,
  `cli_status` char(1) DEFAULT NULL,
  `cli_email` varchar(150) NOT NULL,
  `cli_tipo_cliente` varchar(60) DEFAULT NULL,
  `cli_dt_nasc` varchar(20) DEFAULT NULL
);

ALTER TABLE `cliente` ADD PRIMARY KEY (`cli_id`);

ALTER TABLE `cliente` MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

CREATE TABLE `empresa` (
  `emp_id` int(11) NOT NULL,
  `emp_fantasia` varchar(200) NOT NULL,
  `emp_razao` varchar(200) NOT NULL,
  `emp_cnpj` varchar(20) NOT NULL,
  `emp_telefone` varchar(20) NOT NULL,
  `emp_celular` varchar(20) NOT NULL,
  `emp_email` varchar(200) NOT NULL,
  `emp_logradouro` varchar(200) NOT NULL,
  `emp_complemento` varchar(200) NOT NULL,
  `emp_numero` varchar(10) NOT NULL,
  `emp_bairro` varchar(100) NOT NULL,
  `emp_cep` varchar(10) NOT NULL,
  `emp_cidade` varchar(200) NOT NULL,
  `emp_estado` varchar(50) NOT NULL,
  `emp_responsavel` varchar(150) NOT NULL,
  `emp_imagem` varchar(1000) NOT NULL,
  `emp_status` varchar(50) NOT NULL
);

ALTER TABLE `empresa` ADD PRIMARY KEY (`emp_id`);

ALTER TABLE `empresa` MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nome` varchar(200) NOT NULL,
  `usu_email` varchar(200) NOT NULL,
  `usu_senha` varchar(250) NOT NULL,
  `usu_tipo` varchar(100) NOT NULL,
  `usu_status` char(1) NOT NULL
);

ALTER TABLE `usuario` ADD PRIMARY KEY (`usu_id`);

ALTER TABLE `usuario` MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

CREATE TABLE `produto` (
  `pro_id` int(11) NOT NULL,
  `pro_descricao` varchar(200) NOT NULL,
  `pro_unidade` varchar(20) NOT NULL,
  `pro_status` char(1) NOT NULL
);

ALTER TABLE `produto` ADD PRIMARY KEY (`pro_id`); 
ALTER TABLE `produto` MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
ALTER TABLE `produto` ADD CONSTRAINT `un_produto` UNIQUE (`pro_descricao`,`pro_unidade`);

CREATE TABLE `fornecedor` (
  `for_id` int(11) NOT NULL,
  `for_tipo_pessoa` varchar(15) DEFAULT NULL,
  `for_cnpj` varchar(20) DEFAULT NULL,
  `for_cpf` varchar(15) DEFAULT NULL,
  `for_ie` varchar(15) DEFAULT NULL,
  `for_rg` varchar(15) DEFAULT NULL,
  `for_emissor_rg` varchar(15) DEFAULT NULL,
  `for_razaosocial` varchar(150) DEFAULT NULL,
  `for_fantasia` varchar(150) DEFAULT NULL,
  `for_logradouro` varchar(200) DEFAULT NULL,
  `for_numero` varchar(10) DEFAULT NULL,
  `for_complemento` varchar(100) DEFAULT NULL,
  `for_bairro` varchar(100) DEFAULT NULL,
  `for_cep` varchar(10) DEFAULT NULL,
  `for_cidade` varchar(100) DEFAULT NULL,
  `for_contato` varchar(100) DEFAULT NULL,
  `for_estado` varchar(50) DEFAULT NULL,
  `for_telefone` varchar(20) DEFAULT NULL,
  `for_celular` varchar(20) DEFAULT NULL,
  `for_status` char(1) DEFAULT NULL,
  `for_email` varchar(150) NOT NULL
);

ALTER TABLE `fornecedor` ADD PRIMARY KEY (`for_id`);

ALTER TABLE `fornecedor` MODIFY `for_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

CREATE TABLE `funcionario` (
  `fun_id` int(11) NOT NULL,
  `fun_nome` varchar(150) DEFAULT NULL,
  `fun_sexo` char(1) DEFAULT NULL,
  `fun_cpf` varchar(15) DEFAULT NULL,
  `fun_funcao` varchar(100) DEFAULT NULL,
  `fun_est_civil` varchar(45) DEFAULT NULL,
  `fun_num_pasta` varchar(20) DEFAULT NULL,
  `fun_cep` varchar(10) DEFAULT NULL,
  `fun_logradouro` varchar(200) DEFAULT NULL,
  `fun_numero` varchar(10) DEFAULT NULL,
  `fun_complemento` varchar(100) DEFAULT NULL,
  `fun_bairro` varchar(100) DEFAULT NULL,
  `fun_cidade` varchar(100) DEFAULT NULL,
  `fun_estado` varchar(50) DEFAULT NULL,
  `fun_status` char(1) DEFAULT NULL
);

ALTER TABLE `funcionario` ADD PRIMARY KEY (`fun_id`);

ALTER TABLE `funcionario` MODIFY `fun_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `funcionario` ADD CONSTRAINT `un_funcionario` UNIQUE (`fun_cpf`);

CREATE TABLE `obra` (
  `obra_id` int(11) NOT NULL,
  `obra_nome` varchar(150) DEFAULT NULL,
  `obra_tipo` varchar(100) DEFAULT NULL,
  `obra_tipo_contrato` varchar(100) DEFAULT NULL,
  `obra_resp_tecnico` int(11) DEFAULT NULL,
  `obra_resp_projeto` int(11) DEFAULT NULL,
  `obra_art` varchar(150) DEFAULT NULL,
  `obra_dt_inicio` varchar(10) DEFAULT NULL,
  `obra_dt_final` varchar(10) DEFAULT NULL,
  `obra_valor` decimal(10,2) NOT NULL,
  `obra_num_contrato` varchar(45) DEFAULT NULL,
  `obra_logradouro` varchar(200) DEFAULT NULL,
  `obra_numero` varchar(10) DEFAULT NULL,
  `obra_complemento` varchar(100) DEFAULT NULL,
  `obra_bairro` varchar(100) DEFAULT NULL,
  `obra_cep` varchar(10) DEFAULT NULL,
  `obra_cidade` varchar(100) DEFAULT NULL,
  `obra_estado` varchar(50) NOT NULL,
  `cliente_cli_id` int(11) NOT NULL,
  `obra_status` char(1) NOT NULL
);

ALTER TABLE `obra`
  ADD PRIMARY KEY (`obra_id`),
  ADD KEY `fk_obra_cliente1` (`cliente_cli_id`),
  ADD KEY `fk_obra_func` (`obra_resp_tecnico`),
  ADD KEY `fk_obra_funcp` (`obra_resp_projeto`); 

ALTER TABLE `obra` MODIFY `obra_id` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `obra`
  ADD CONSTRAINT `fk_obra_cliente1` FOREIGN KEY (`cliente_cli_id`) REFERENCES `cliente` (`cli_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_obra_func` FOREIGN KEY (`obra_resp_tecnico`) REFERENCES `funcionario` (`fun_id`),
  ADD CONSTRAINT `fk_obra_funcp` FOREIGN KEY (`obra_resp_projeto`) REFERENCES `funcionario` (`fun_id`);

CREATE TABLE `questionario` (
  `que_id` int(11) NOT NULL,
  `que_moram` int(11) DEFAULT NULL,
  `que_garagem` int(11) DEFAULT NULL,
  `que_quartos` int(11) DEFAULT NULL,
  `que_integracao` char(1) DEFAULT NULL,
  `que_escritorio` char(1) DEFAULT NULL,
  `que_acabamento` char(1) DEFAULT NULL,
  `que_banheiro` int(11) DEFAULT NULL,
  `que_lavabo` char(1) DEFAULT NULL,
  `que_pne` char(1) DEFAULT NULL,
  `que_tamBanheiro` char(1) DEFAULT NULL,
  `que_armazenamento` char(1) DEFAULT NULL,
  `que_lavanderia` char(1) DEFAULT NULL,
  `que_areaLazer` varchar(1000) DEFAULT NULL,
  `que_vegetacao` char(1) DEFAULT NULL,
  `que_alarme` char(1) DEFAULT NULL,
  `que_camera` char(1) DEFAULT NULL,
  `que_porteiro` char(1) DEFAULT NULL,
  `que_observacao` varchar(1000) DEFAULT NULL,
  `que_status` char(1) DEFAULT NULL,
  `cli_id` int(11) DEFAULT NULL 
);

ALTER TABLE `questionario` ADD PRIMARY KEY (`que_id`); 

ALTER TABLE `questionario` MODIFY `que_id` int(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `questionario` ADD CONSTRAINT `fk_questionario_cliente` FOREIGN KEY (`cli_id`) REFERENCES `cliente` (`cli_id`) ON DELETE NO ACTION ON UPDATE NO ACTION; 


CREATE TABLE `nf_entrada` ( 
  `nfent_id` int(11) NOT NULL,
  `nfent_tipo` char(1) DEFAULT NULL,
  `nfent_numero` varchar(200) DEFAULT NULL,
  `nfent_fornecedor_id` int(11) NOT NULL,
  `nfent_obra_id` int(11) NOT NULL,
  `nfent_dt_emissao` date DEFAULT NULL,
  `nfent_dt_lancamento` date DEFAULT NULL,
  `nfent_desc_por` decimal(10,2) DEFAULT NULL,
  `nfent_desc_vl` decimal(10,2) DEFAULT NULL,
  `nfent_subtotal` decimal(10,2) DEFAULT NULL,
  `nfent_total` decimal(10,2) DEFAULT NULL,
  `nfent_status` char(1) NOT NULL
);

ALTER TABLE `nf_entrada` ADD PRIMARY KEY (`nfent_id`);
ALTER TABLE `nf_entrada` MODIFY `nfent_id` int(11) NOT NULL AUTO_INCREMENT; 
ALTER TABLE `nf_entrada` ADD CONSTRAINT `fk_nfentrada_fornecedor1` FOREIGN KEY (`nfent_fornecedor_id`) REFERENCES `fornecedor` (`for_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `nf_entrada` ADD CONSTRAINT `fk_nfentrada_obra1` FOREIGN KEY (`nfent_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `nf_entrada` ADD CONSTRAINT `un_nfentrada` UNIQUE (`nfent_numero`, `nfent_fornecedor_id`);

CREATE TABLE `itens_nf_entrada`(
  `it_nfent_id` int(11) NOT NULL,
  `it_nfent_nf_entrada_id` int(11) NOT NULL,
  `it_nfent_produto_id` int(11) NOT NULL,
  `it_nfent_obra_id` int(11) NOT NULL,
  `it_nfent_quantidade` int(11) NOT NULL,
  `it_nfent_valor_unitario` decimal(10,2) DEFAULT NULL,
  `it_nfent_valor_total` decimal(10,2) DEFAULT NULL
);

ALTER TABLE `itens_nf_entrada` ADD PRIMARY KEY (`it_nfent_id`); 

ALTER TABLE `itens_nf_entrada` MODIFY `it_nfent_id` int(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `itens_nf_entrada`
  ADD CONSTRAINT `fk_itens_nfentrada_nf_entrada1` FOREIGN KEY (`it_nfent_nf_entrada_id`) REFERENCES `nf_entrada` (`nfent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itens_nfentrada_produto1` FOREIGN KEY (`it_nfent_produto_id`) REFERENCES `produto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itens_nfentrada_obra1` FOREIGN KEY (`it_nfent_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `itens_nf_entrada` ADD CONSTRAINT `un_itens_nf_entrada` UNIQUE (`it_nfent_nf_entrada_id`, `it_nfent_produto_id`);  


CREATE TABLE `pagar`(
  `pagar_id` int(11) NOT NULL,
  `pagar_numero` varchar(200) DEFAULT NULL,
  `pagar_sequencia` int(11) DEFAULT NULL,
  `pagar_fornecedor_id` int(11) NOT NULL,
  `pagar_obra_id` int(11) NOT NULL,
  `pagar_nf_entrada_id` int(11) NULL,
  `pagar_dt_venc` varchar(10) DEFAULT NULL,
  `pagar_dt_pagto` varchar(10) DEFAULT NULL,
  `pagar_vl_orig` decimal(10,2) DEFAULT NULL,
  `pagar_vl_acresc` decimal(10,2) DEFAULT NULL,
  `pagar_vl_final` decimal(10,2) DEFAULT NULL,
  `pagar_historico` varchar(500) DEFAULT NULL,
  `pagar_status` char(1) NOT NULL
);

ALTER TABLE `pagar` ADD PRIMARY KEY (`pagar_id`); 
ALTER TABLE `pagar` MODIFY `pagar_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pagar` ADD CONSTRAINT `un_pagar` UNIQUE (`pagar_numero`, `pagar_sequencia`, `pagar_fornecedor_id`);
ALTER TABLE `pagar` ADD CONSTRAINT `fk_pagar_fornecedor` FOREIGN KEY (`pagar_fornecedor_id`) REFERENCES `fornecedor` (`for_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `pagar` ADD CONSTRAINT `fk_pagar_obra` FOREIGN KEY (`pagar_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `pagar` ADD CONSTRAINT `fk_pagar_nf_entrada` FOREIGN KEY (`pagar_nf_entrada_id`) REFERENCES `nf_entrada` (`nfent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


CREATE TABLE `receber`(
  `receber_id` int(11) NOT NULL,
  `receber_numero` varchar(200) DEFAULT NULL,
  `receber_sequencia` int(11) DEFAULT NULL,
  `receber_cliente_id` int(11) NOT NULL,
  `receber_obra_id` int(11) NOT NULL,
  `receber_dt_venc` varchar(10) DEFAULT NULL,
  `receber_dt_pagto` varchar(10) DEFAULT NULL,
  `receber_vl_orig` decimal(10,2) DEFAULT NULL,
  `receber_vl_final` decimal(10,2) DEFAULT NULL,
  `receber_historico` varchar(500) DEFAULT NULL,
  `receber_status` char(1) NOT NULL
);

ALTER TABLE `receber` ADD PRIMARY KEY (`receber_id`); 
ALTER TABLE `receber` MODIFY `receber_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `receber` ADD CONSTRAINT `un_receber` UNIQUE (`receber_numero`, `receber_sequencia`, `receber_cliente_id`);
ALTER TABLE `receber` ADD CONSTRAINT `fk_receber_cliente` FOREIGN KEY (`receber_cliente_id`) REFERENCES `cliente` (`cli_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `receber` ADD CONSTRAINT `fk_receber_obra` FOREIGN KEY (`receber_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;



CREATE TABLE `devolucao` (
  `dev_id` int(11) NOT NULL,
  `dev_tipo` char(1) DEFAULT NULL,
  `dev_numero` varchar(200) DEFAULT NULL,
  `dev_fornecedor_id` int(11) NOT NULL,
  `dev_obra_id` int(11) NOT NULL,
  `dev_dt_emissao` date DEFAULT NULL,
  `dev_dt_lancamento` date DEFAULT NULL,
  `dev_total` decimal(10,2) DEFAULT NULL,
  `dev_status` char(1) NOT NULL
);

ALTER TABLE `devolucao` ADD PRIMARY KEY (`dev_id`);
ALTER TABLE `devolucao` MODIFY `dev_id` int(11) NOT NULL AUTO_INCREMENT; 
ALTER TABLE `devolucao` ADD CONSTRAINT `fk_devolucao_fornecedor1` FOREIGN KEY (`dev_fornecedor_id`) REFERENCES `fornecedor` (`for_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `devolucao` ADD CONSTRAINT `fk_devolucao_obra1` FOREIGN KEY (`dev_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `devolucao` ADD CONSTRAINT `un_devolucao` UNIQUE (`dev_numero`, `dev_fornecedor_id`);



CREATE TABLE `itens_devolucao`(
  `it_dev_id` int(11) NOT NULL,
  `it_dev_dev_id` int(11) NOT NULL,
  `it_dev_produto_id` int(11) NOT NULL,
  `it_dev_obra_id` int(11) NOT NULL,
  `it_dev_quantidade` int(11) NOT NULL,
  `it_dev_valor_unitario` decimal(10,2) DEFAULT NULL,
  `it_dev_valor_total` decimal(10,2) DEFAULT NULL
);

ALTER TABLE `itens_devolucao` ADD PRIMARY KEY (`it_dev_id`); 

ALTER TABLE `itens_devolucao` MODIFY `it_dev_id` int(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `itens_devolucao`
  ADD CONSTRAINT `fk_itens_dev_devolucao1` FOREIGN KEY (`it_dev_dev_id`) REFERENCES `devolucao` (`dev_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itens_dev_produto1` FOREIGN KEY (`it_dev_produto_id`) REFERENCES `produto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itens_dev_obra1` FOREIGN KEY (`it_dev_obra_id`) REFERENCES `obra` (`obra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `itens_devolucao` ADD CONSTRAINT `un_itens_devolucao` UNIQUE (`it_dev_dev_id`, `it_dev_produto_id`);

CREATE TABLE `tipo_art` (
  `tipo_id` int(11) NOT NULL,
  `tipo_descricao` varchar(200) NOT NULL
);

ALTER TABLE `tipo_art` ADD PRIMARY KEY (`tipo_id`); 
ALTER TABLE `tipo_art` MODIFY `tipo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
ALTER TABLE `tipo_art` ADD CONSTRAINT `un_tipo_art` UNIQUE (`tipo_descricao`);


CREATE TABLE `art` (
  `art_id` int(11) NOT NULL,
  `art_obra_id` int(11) NOT NULL,
  `art_tipo_art_id` int(11) NOT NULL,
  `art_numero` varchar(200) NOT NULL,
  `art_data` date DEFAULT NULL,
  `art_valor` decimal(10,2) DEFAULT NULL,
  `art_arquivo` varchar(1000) NULL
);

ALTER TABLE `art` ADD PRIMARY KEY (`art_id`);
ALTER TABLE `art` MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `art`
  ADD CONSTRAINT `fk_art_obra` FOREIGN KEY (`art_obra_id`) REFERENCES `obra` (`obra_id`),
  ADD CONSTRAINT `fk_art_tipo` FOREIGN KEY (`art_tipo_art_id`) REFERENCES `tipo_art` (`tipo_id`);

  ALTER TABLE `art` ADD CONSTRAINT `un_art` UNIQUE (`art_obra_id`, `art_numero`);  


  CREATE TABLE `conta` (
  `conta_id` int(11) NOT NULL,
  `conta_nome` varchar(200) NOT NULL,
  `conta_saldo` decimal(10,2) DEFAULT NULL
);

ALTER TABLE `conta` ADD PRIMARY KEY (`conta_id`);
ALTER TABLE `conta` MODIFY `conta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

INSERT INTO `conta` (`conta_nome`,`conta_saldo`) VALUES ('CAIXA','0');

CREATE TABLE `lancamento` (
  `lancamento_id` int(11) NOT NULL,
  `lancamento_conta_id` int(11) NOT NULL,
  `lancamento_documento` varchar(200) DEFAULT NULL,
  `lancamento_valor` decimal(10,2) DEFAULT NULL,
  `lancamento_tipo` char(1) NOT NULL,
  `lancamento_data` date DEFAULT NULL,
  `lancamento_observacao` varchar(1000) DEFAULT NULL,
  `lancamento_pagar_id` int(11) DEFAULT NULL,
  `lancamento_receber_id` int(11) DEFAULT NULL
);

ALTER TABLE `lancamento` ADD PRIMARY KEY (`lancamento_id`);
ALTER TABLE `lancamento` MODIFY `lancamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `lancamento`
  ADD CONSTRAINT `fk_lancamento_conta` FOREIGN KEY (`lancamento_conta_id`) REFERENCES `conta` (`conta_id`);