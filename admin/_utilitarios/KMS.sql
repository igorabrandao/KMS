SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `KMS` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `KMS` ;

-- -----------------------------------------------------
-- Table `KMS`.`tipoUsuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`tipoUsuario` (
  `ID_TIPO_USUARIO` INT NOT NULL AUTO_INCREMENT,
  `DESCRICAO` VARCHAR(20) NOT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_TIPO_USUARIO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`faixa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`faixa` (
  `ID_FAIXA` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(40) NOT NULL,
  `SIGNIFICADO` VARCHAR(3000) NULL,
  `TEMPO_TREINO` INT NULL COMMENT 'TEMPO DE TREINO EM MESES.',
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_FAIXA`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`estados` (
  `ID_ESTADO` INT NOT NULL AUTO_INCREMENT,
  `UF` VARCHAR(2) NOT NULL,
  `NOME` VARCHAR(50) NULL,
  `DATA_FECHA` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_ESTADO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`endereco` (
  `ID_ENDERECO` INT NOT NULL AUTO_INCREMENT,
  `CEP` VARCHAR(10) NOT NULL,
  `LOGRADOURO` VARCHAR(50) NOT NULL,
  `NUMERO` VARCHAR(6) NULL,
  `COMPLEMENTO` VARCHAR(100) NULL,
  `BAIRRO` VARCHAR(30) NOT NULL,
  `CIDADE` VARCHAR(20) NOT NULL,
  `ID_UF` INT NOT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_ENDERECO`),
  INDEX `ENDERECO_UF_FK_idx` (`ID_UF` ASC),
  CONSTRAINT `ENDERECO_UF_FK`
    FOREIGN KEY (`ID_UF`)
    REFERENCES `KMS`.`estados` (`ID_ESTADO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`usuario` (
  `ID_USUARIO` INT NOT NULL AUTO_INCREMENT,
  `ID_TIPO_USUARIO` INT NOT NULL,
  `ID_FAIXA` INT NOT NULL,
  `PRIMEIRO_NOME` VARCHAR(30) NOT NULL,
  `SOBRENOME` VARCHAR(30) NOT NULL,
  `CPF` VARCHAR(20) NOT NULL,
  `DATA_NASCIMENTO` VARCHAR(10) NOT NULL,
  `SEXO` VARCHAR(1) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(256) NOT NULL,
  `CHAVE` VARCHAR(50) NOT NULL,
  `TELEFONE` VARCHAR(15) NULL,
  `CELULAR` VARCHAR(15) NULL,
  `ID_ENDERECO` INT NOT NULL,
  `TIPO_SANGUINEO` VARCHAR(3) NULL,
  `FOTO` VARCHAR(255) NULL,
  `DATA_CADASTRO` VARCHAR(10) NOT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_USUARIO`),
  INDEX `TIPO_USUARIO_FK_idx` (`ID_TIPO_USUARIO` ASC),
  INDEX `FAIXA_USUARIO_FK_idx` (`ID_FAIXA` ASC),
  INDEX `ENDERECO_USUARIO_FK_idx` (`ID_ENDERECO` ASC),
  CONSTRAINT `TIPO_USUARIO_FK`
    FOREIGN KEY (`ID_TIPO_USUARIO`)
    REFERENCES `KMS`.`tipoUsuario` (`ID_TIPO_USUARIO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FAIXA_USUARIO_FK`
    FOREIGN KEY (`ID_FAIXA`)
    REFERENCES `KMS`.`faixa` (`ID_FAIXA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ENDERECO_USUARIO_FK`
    FOREIGN KEY (`ID_ENDERECO`)
    REFERENCES `KMS`.`endereco` (`ID_ENDERECO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`associacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`associacao` (
  `ID_ASSOCIACAO` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(50) NOT NULL,
  `DESCRICAO` VARCHAR(255) NULL,
  `ID_TELEFONE` INT NOT NULL,
  `ID_ENDERECO` INT NOT NULL,
  `FUNDADOR` VARCHAR(50) NULL,
  `DATA_FUNDACAO` VARCHAR(10) NULL,
  `LOGO` VARCHAR(255) NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_ASSOCIACAO`),
  INDEX `ENDERECO_ASSOCIACAO_FK_idx` (`ID_ENDERECO` ASC),
  CONSTRAINT `ENDERECO_ASSOCIACAO_FK`
    FOREIGN KEY (`ID_ENDERECO`)
    REFERENCES `KMS`.`endereco` (`ID_ENDERECO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`evento` (
  `ID_EVENTO` INT NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` INT NOT NULL COMMENT 'Identificação do usuário que criou o evento.',
  `NOME` VARCHAR(50) NOT NULL,
  `DESCRICAO` VARCHAR(500) NULL,
  `ID_ENDERECO` INT NOT NULL,
  `DATA_HORA` VARCHAR(20) NOT NULL,
  `TAXA_INSCRICAO` DOUBLE NOT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_EVENTO`),
  INDEX `USUARIO_EVENTO_FK_idx` (`ID_USUARIO` ASC),
  INDEX `ENDERECO_EVENTO_FK_idx` (`ID_ENDERECO` ASC),
  CONSTRAINT `USUARIO_EVENTO_FK`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `KMS`.`usuario` (`ID_USUARIO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ENDERECO_EVENTO_FK`
    FOREIGN KEY (`ID_ENDERECO`)
    REFERENCES `KMS`.`endereco` (`ID_ENDERECO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`pagamento` (
  `ID_PAGAMENTO` INT NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` INT NOT NULL COMMENT 'Identificador do usuário que efetuou o pagamento.',
  `DESCRICAO` VARCHAR(200) NULL,
  `VALOR` DOUBLE NOT NULL,
  `MULTA` DOUBLE NULL,
  `DATA_PAGAMENTO` VARCHAR(10) NOT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_PAGAMENTO`),
  INDEX `USUARIO_PAGAMENTO_FK_idx` (`ID_USUARIO` ASC),
  CONSTRAINT `USUARIO_PAGAMENTO_FK`
    FOREIGN KEY (`ID_USUARIO`)
    REFERENCES `KMS`.`usuario` (`ID_USUARIO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`aula` (
  `ID_AULA` INT NOT NULL AUTO_INCREMENT,
  `DATA_AULA` VARCHAR(10) NOT NULL,
  `CONTEUDO_MINISTRADO` VARCHAR(500) NULL,
  `ID_PROFESSOR` INT NULL,
  `DATA_FECHA` VARCHAR(20) NULL,
  PRIMARY KEY (`ID_AULA`),
  INDEX `PROFESSOR_FK_idx` (`ID_PROFESSOR` ASC),
  CONSTRAINT `PROFESSOR_FK`
    FOREIGN KEY (`ID_PROFESSOR`)
    REFERENCES `KMS`.`usuario` (`ID_USUARIO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KMS`.`frequencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KMS`.`frequencia` (
  `ID_ALUNO` INT NOT NULL,
  `ID_AULA` INT NOT NULL,
  `PRESENTE` TINYINT(1) NULL,
  PRIMARY KEY (`ID_ALUNO`, `ID_AULA`),
  INDEX `id_aula_fk_idx` (`ID_AULA` ASC),
  CONSTRAINT `id_aluno_fk`
    FOREIGN KEY (`ID_ALUNO`)
    REFERENCES `KMS`.`usuario` (`ID_USUARIO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `id_aula_fk`
    FOREIGN KEY (`ID_AULA`)
    REFERENCES `KMS`.`aula` (`ID_AULA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `KMS`.`tipoUsuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `KMS`;
INSERT INTO `KMS`.`tipoUsuario` (`ID_TIPO_USUARIO`, `DESCRICAO`, `DATA_FECHA`) VALUES (1, 'Administrador', NULL);
INSERT INTO `KMS`.`tipoUsuario` (`ID_TIPO_USUARIO`, `DESCRICAO`, `DATA_FECHA`) VALUES (2, 'Sensei', NULL);
INSERT INTO `KMS`.`tipoUsuario` (`ID_TIPO_USUARIO`, `DESCRICAO`, `DATA_FECHA`) VALUES (3, 'Aluno', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `KMS`.`faixa`
-- -----------------------------------------------------
START TRANSACTION;
USE `KMS`;
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (1, 'Faixa Branca (Shiro Obi)', 'Essa é a cor do desprendimento.\nO branco reflete todas as cores. A própria cor dessa faixa indica que o seu portador ainda possui a ingenuidade e deve procurar manter a mente limpa. Entretanto, ele tem em potencial, todas as cores das demais faixas posteriores e, assim como o fogo está na pedra, cabe a ele, fazê-lo brotar através da fricção do treino árduo.\n\nA busca nesse grau é pela purificação e transformação, diante do infinito conhecimento que tem diante de si. Essa faixa nos diz que o iniciante deve buscar a humildade e a imaginação criativa, através da limpeza e da claridade dos pensamentos. É a cor síntese do arco-íris e a mais associada ao sagrado, pois simboliza paz, pureza, perfeição e especialmente o absoluto.\n\nEla nos diz que devemos buscar a pureza, sinceridade e a verdade. Repelindo os pensamentos negativos, procurando elevá-los, para que encontremos o equilíbrio interior, segurança e desenvolvamos o instinto e a memória.\n\nO branco simboliza uma espécie de coringa, para todos os propósitos, é o substituto para qualquer cor, assim como uma tela em branco esperando para ser pintada.', 6, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (2, 'Faixa Amarela (Kiiro Obi)', 'Assim como um sol que desponta todos os dias, ela significa que é um iniciante ou um recém-nascido no Karatê, que com o tempo irá crescendo e fortalecendo-se, até chegar a maturidade que corresponde a faixa preta.\n\nAssim como o sol nascente, o conhecimento começa a aflorar para o iniciante. Agora ele pode vislumbrar um pouco da iluminação da descoberta e da realidade do que é o Karatê. Entretanto, assim como o amarelo é uma cor primária, isto é, não pode ser formado pela mistura de outras cores, ele também deve manter-se puro dentro da escola de Karatê que escolheu ainda evitando misturar outras coisas aos conhecimentos que está recebendo para não se confundir dentro da senda do verdadeiro Karatê.\n\nAssim como essa cor, essa graduação lhe traz a alegria, a vida, o calor, a força, a glória, o poder mental e representa o descobrimento. Ela lhe desperta novas esperanças no caminho, dando-lhe vivacidade, alegria, desprendimento e leveza. Agora ele deve procurar desinibir-se para desenvolver seu brilho, mas também diminuir a ansiedade e as preocupações, construindo sua confiança, energia e inteligência na solução dos problemas que surgirão.\n\nA cor dessa graduação mostra que o praticante deve reter conhecimentos e desenvolver a luz da sabedoria e da criatividade, e assim como o sol, ela deve trazer a luz para as situações difíceis.\n\nO Amarelo simboliza: criatividade, as idéias, o conhecimento, alegria, juventude e nobreza. Apesar do amarelo estar relacionado ao elemento terra, também é uma cor Yang e representa o descobrimento e a abertura para o conhecimento do Karatê.', 6, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (3, 'Faixa Vermelha (Aka Obi)', 'A cor vermelha sugere motivação, atividade e vontade. Ela atrai vida nova e pontos de partida inéditos.\n\nEssa é a cor do fogo, da paixão, do entusiasmo e dos impulsos. É a cor mais quente, ativa e estimulante. Ainda é uma cor primária que não pode ser formada pela mistura de outras cores, mostrando assim, que o praticante ainda deverá manter-se puro e fiel ao estilo de Karatê que elegeu.\n\nEssa faixa, pela sua vibração, dá mais energia física, mostrando que agora, mais do que nunca é necessária força de vontade para não desistir da conquista dos seus ideais. Persistência, força física, estímulo e poder são seus traços típicos.\n\nEmbora o vermelho represente agressividade, perigo, fogo, sangue, paixão, destruição, raiva, guerra, combate e conquista, também simboliza aquilo que deve ser contido pelo seu portador. Esta cor faz com que você se sinta mais vigoroso, expansivo e pronto para avançar adiante em algum sentido evidente. Ela tende a atrair o olhar das pessoas e chamar a atenção. Se você usar vermelho, isso pode indicar que tem ardor e paixão, ferocidade e força. As pessoas que gostam de ação e drama apreciam essa cor. É uma cor de uma energia muito forte e o praticante deve ter o cuidado e a persistência para não se deixar ser vencido por ela e desistir do caminho. Sendo a cor do sangue, o vermelho também está relacionado à vida e à força de uma energia vital máxima. Esta é uma cor Yang.', 6, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (4, 'Faixa Laranja (Daidaiiro obi)', 'Esta cor é a mistura do vermelho com o amarelo, representado que o conhecimento dos graus anteriores deve estar contido nesta graduação e trazendo as qualidades dessas duas cores. Nos diz que devemos procurar o sucesso no treino diário, agilidade, adaptabilidade, estimulação, atração e plenitude.\n\nEssa cor também simboliza aquilo que o praticante deve buscar: o encorajamento, estimulação, robustez, atração, gentileza, cordialidade e tolerância.\n\nEsta é a cor da comunicação, do calor afetivo, do equilíbrio, da segurança e da confiança. Quem chega nessa faixa deve acreditar que agora tudo é possível, pois essa cor estimula o otimismo, generosidade, entusiasmo e o encorajamento.\n\nA cor laranja mostra ao praticante que ele deve fortalecer as energias e a sua vontade de vencer. A cor laranja está situada entre o elemento fogo e o elemento terra, portanto, carrega um pouco das características dos dois elementos. Também é uma cor Yang.', 6, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (5, 'Faixa Verde (Midori Obi)', 'O verde é uma cor que representa Esperança e a Fé. É a cor mais harmoniosa e calmante de todas. Ela simboliza harmonia e equilíbrio.\n\nEssa cor, que nos chega depois das cores quentes iniciais, nos dá a impressão de que chegamos a um oásis, depois de atravessar um árduo deserto, mas devemos saber que ainda há mais deserto a vencer.\n\nEla também representa as energias da natureza, esperança, perseverança, segurança e satisfação, fertilidade. O portador deve procurar desenvolver a sua sensibilidade para se comunicar com a natureza interna e externa a si mesmo.\n\nSignifica também a harmonia em que devemos estar com ela, junto com o ar, a água e o fogo, elementos da vida que proporcionam bem-estar ao ser humano.\n\nEssa cor simboliza uma vida nova, a energia, a fertilidade, o crescimento e a saúde. Por outro lado, quando em mau aspecto, mostra um orgulho excessivo, superioridade e arrogância.\n\nO verde é ligado ao elemento madeira e a primavera.\n\nRepresenta o crescimento, desenvolvimento, natureza e saúde. Também significa a etapa da juventude, estando relacionado a este estado emocional, mostrando assim, que os conhecimentos ainda não se encontram bem claros ou maduros para os praticantes. Ainda lhes falta amadurecer mais e delineá-los melhor.', 12, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (6, 'Faixa Roxa (Murasaki Obi)', ' roxo é uma mistura das cores azul e vermelho. Essa é a cor usada pelos sacerdotes católicos para refletir santidade e humildade.\n\nEla gera sentimentos como respeito próprio, dignidade e auto-estima.\n\nEsta é uma cor metafísica. É também a cor da alquimia, das transformações e da magia. Ela é vista como a cor da energia cósmica e da inspiração espiritual.\n\nA cor violeta é excelente para purificação e cura dos níveis físico, emocional e mental.\n\nSimboliza: dignidade, devoção, piedade, sinceridade, espiritualidade, purificação e transformação. Quando em mau aspecto determina manias e fanatismo.\n\nRepresenta o mistério, expressa a sensação de individualidade, influenciando emoções e humores, mas também simboliza a dignidade, a inspiração e justiça. Gera tensão, poder, tristeza, piedade, sentimentalidade.\n\nTendo isso tudo em mente, a cor desta graduação nos indica que devemos encontrar novos caminhos e elevar nossa intuição espiritual.\n\n', 12, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (7, 'Faixa Marrom (Chairo Obi)', 'É a cor da solidificação. Representa a constância, a disciplina, a uniformidade adquirida e a observação das regras mantidas até aqui. Representa a conexão do praticante com o patrono do estilo que lhe foi passado, representado por seus mestres.\n\nPara criar essa cor, você precisa misturar o vermelho com o preto e, portanto, ela tem alguns dos seus atributos. Também representa a autocrítica e a dependência dos mestres para chegar até aqui. Significa que se está completando o processo de amadurecimento, tanto nos conhecimentos técnicos quanto no aspecto mental.\n\nEssa faixa, pela sua cor, emana a impressão de algo maciço e denso, compacto.\n\nSugere segurança e isolamento. Representa também uma poluição que deve sempre ser limpa, através da prática fiel aos princípios do Budô.\n\nUma pessoa que gosta de vestir-se com marrom por certo é extremamente dedicada e comprometida com o seu trabalho, sua família e seus amigos.\n\nA cor marrom gera organização e constância, especialmente nas responsabilidades do cotidiano. As pessoas que gostam de usar essa cor são capazes de ir “à raiz das coisas” e lidar com questões complicadas de forma simples e direta. São pessoas “sensatas”.', 24, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (8, 'Faixa Preta (Kuro Obi) – 1º Dan', 'É a junção de todas as cores. Enfim o corpo e a mente chegaram ao final de uma jornada e ao início de outra mais elevada. A faixa na cor preta, representa humildade, autocontrole, maturidade, serenidade, disciplina, responsabilidade, dignidade e conhecimento. É a cor do poder, induz a sensação de elegância e sobriedade. Onde o que está fora não entra e o que está dentro não sai.\n\nObserva-se que na maioria das sociedades ocidentais, o preto quase sempre é a cor da morte, do luto e da penitência, mostrando assim o estado mental de quem atingiu essa graduação.\n\nEm geral, essa cor é usada por pessoas que rejeitam as regras convencionais ou são regidos por outras normas sociais, como é o caso dos padres ou dos guerreiros que seguem o Budô.\n\nEssa cor também nos dá uma noção de tradição e responsabilidade. É a ausência de vibração da “não cor” que dá a sensação de proteção ou afastamento.\n\nPor outro lado, absorve, transmuta e devolve as energias negativas, transformadas em positivas.\n\nA meditação nessa cor permite a introspecção, favorece a auto-análise e permite um aprofundamento do indivíduo no seu processo existencial.\n\nRemove obstáculos, vícios e emoções não desejadas. O excesso traz melancolia, depressão, tristeza, confusão, perdas e medo. A cor preta relaciona-se ao elemento água que adapta-se a todas as formas e contorna todos os obstáculos. É o símbolo do máximo Yin.', 24, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (9, '2º. Dan (Nidan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (10, '3º. Dan (Sandan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (11, '4º. Dan (Yodan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (12, '5º. Dan (Godan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (13, '6º. Dan (Rokudan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (14, '7º. Dan (Shichidan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (15, '8º. Dan (Hachidan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (16, '9º. Dan (Kudan)', NULL, NULL, NULL);
INSERT INTO `KMS`.`faixa` (`ID_FAIXA`, `NOME`, `SIGNIFICADO`, `TEMPO_TREINO`, `DATA_FECHA`) VALUES (17, '10º. Dan (Judan)', NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `KMS`.`estados`
-- -----------------------------------------------------
START TRANSACTION;
USE `KMS`;
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (1, 'AC', 'Acre', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (2, 'AL', 'Alagoas', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (3, 'AP', 'Amapá', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (4, 'AM', 'Amazonas', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (5, 'BA', 'Bahia', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (6, 'CE', 'Ceará', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (7, 'DF', 'Distrito Federal', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (8, 'ES', 'Espirito Santo', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (9, 'GO', 'Goiás', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (10, 'MA', 'Maranhão', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (11, 'MT', 'Mato Grosso', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (12, 'MS', 'Mato Grosso do Sul', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (13, 'MG', 'Minas Gerais', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (14, 'PA', 'Pará', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (15, 'PB', 'Paraiba', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (16, 'PR', 'Paraná', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (17, 'PE', 'Pernambuco', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (18, 'PI', 'Piauí', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (19, 'RJ', 'Rio de Janeiro', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (20, 'RN', 'Rio Grande do Norte', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (21, 'RS', 'Rio Grande do Sul', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (22, 'RO', 'Rondônia', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (23, 'RR', 'Roraima', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (24, 'SC', 'Santa Catarina', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (25, 'SP', 'São Paulo', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (26, 'SE', 'Sergipe', '');
INSERT INTO `KMS`.`estados` (`ID_ESTADO`, `UF`, `NOME`, `DATA_FECHA`) VALUES (27, 'TO', 'Tocantis', '');

COMMIT;

