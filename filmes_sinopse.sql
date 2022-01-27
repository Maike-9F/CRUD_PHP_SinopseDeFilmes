-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `filmes_sinopse`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `filmes`
--

CREATE TABLE `filmes` (
  `id_filme` int(11) NOT NULL,
  `nome_filme` varchar(40) NOT NULL,
  `ano` int(4) NOT NULL,
  `tipo_filme` varchar(40) NOT NULL,
  `diretor` varchar(20) NOT NULL,
  `idade_filme` varchar(3) NOT NULL,
  `descricao` text NOT NULL,
  `capa` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `filmes`
--

INSERT INTO `filmes` (`id_filme`, `nome_filme`, `ano`, `tipo_filme`, `diretor`, `idade_filme`, `descricao`, `capa`, `id_usuario`) VALUES
(1, 'Transformers 3 - O lado oculto da lua', 2011, 'Ação', 'Michael Bay', '12', 'Sam Witwicky e sua nova namorada, Carly, entram na briga quando os Decepticons renovam sua guerra contra os Autobots. Optimus Prime acredita que ressuscitar o antigo Transformer Sentinel Prime, ex-líder dos Autobots, pode levar à vitória. Essa decisão tem consequências devastadoras e a guerra parece pender a favor dos Decepticons, causando um conflito épico em Chicago.', 'transformers3.png', 2),
(2, 'Toy Story 4', 2019, 'Infantil', 'Josh Cooley', 'L', 'Woody, Buzz Lightyear e o resto da turma embarcam em uma viagem com Bonnie e um novo brinquedo chamado Forky. A aventura logo se transforma em uma reunião inesperada quando o ligeiro desvio que Woody faz o leva ao seu amigo há muito perdido, Bo Peep.', 'toy4.png', 1),
(3, 'Gigantes de Aço', 2011, 'Ação', 'Shawn Levy', '10', 'Em um futuro próximo, as máquinas substituem os homens no ringue. As lutas de boxe acontecem entre robôs de alta tecnologia. Charlie, um ex-lutador frustrado, se une ao filho para construir um competidor imbatível.', 'gigantes-de-aco.jpg', 3),
(9, 'Planeta dos Macacos: A Origem', 2011, 'Ficção Cientifica', 'Rupert Wyatt', '12', 'Will Rodman (James Franco) tenta encontrar a cura do Alzheimer. Para isso, ele usa o pai (John Lithgow) e César, um filhote de macaco, como cobaias. Mas César demonstra uma inteligência fora do comum. Quando o primata é colocado em uma gaiola com outros de sua espécie, ele se revolta e lidera uma rebelião contra os humanos. Indicado ao Oscar de melhor Efeitos Visuais.', 'planeta-dos-macacos-a-origem.jpg', 3),
(21, 'Vingadores: Guerra Infinita', 2018, 'Aventura', ' Joe e Anthony Russo', '12', 'Homem de Ferro, Thor, Hulk e os Vingadores se unem para combater seu inimigo mais poderoso, o maligno Thanos. Em uma missão para coletar todas as seis pedras infinitas, Thanos planeja usá-las para infligir sua vontade maléfica sobre a realidade.', 'Avengers_Infinity_War.jpg', 1),
(22, 'Capitão América 2: O Soldado Invernal', 2014, 'Aventura', 'Joe Russo e Anthony ', '12', 'Após os eventos catastróficos em Nova York com Os Vingadores, Steve Rogers, também conhecido como Capitão América, segue tentando se ajustar ao mundo moderno. Porém, quando um colega da agência S.H.I.E.L.D. é atacado, Steve se vê preso em uma rede de intrigas que ameaça colocar o mundo em risco. Em parceria com a Viúva Negra e Falcão, seu novo aliado, o Capitão América tem que enfrentar um misterioso e inesperado inimigo, o Soldado Invernal.', 'capitao america 2.jfif', 2),
(23, 'O Resgate do Soldado Ryan', 1998, 'Ação', 'Steven Spielberg', '16', 'Ao desembarcar na Normandia, no dia 6 de junho de 1944, o Capitão Miller recebe a missão de comandar um grupo do Segundo Batalhão para o resgate do soldado James Ryan, o caçula de quatro irmãos, dentre os quais três morreram em combate. Por ordens do chefe George C. Marshall, eles precisam procurar o soldado e garantir o seu retorno, com vida, para casa.', 'o resgate do soldado ryan.jpg', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(400) NOT NULL,
  `tipo_usuario` varchar(40) DEFAULT 'comum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `tipo_usuario`) VALUES
(1, 'Mike (ADM)', 'mike99@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'ADM'),
(2, 'Bruno', 'bruno45@hotmail.com', '25d55ad283aa400af464c76d713c07ad', 'comum'),
(3, 'Carlos', 'carlos9@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'comum'),
(4, 'Paola', 'paola-s@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'comum');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id_filme`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id_filme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `filmes`
--
ALTER TABLE `filmes`
  ADD CONSTRAINT `filmes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
