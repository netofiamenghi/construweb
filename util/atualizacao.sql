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