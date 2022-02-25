DELETE FROM `campeonatotimes`;
INSERT INTO `times` (`id`, `nome`, `sigla`, `dt_cadastro`) VALUES
(1, 'Arizona Cardinals', 'ARI', '2022-02-24 00:10:18'),
(2, 'Baltimore Ravens', 'BAL', '2022-02-24 00:11:30'),
(3, 'Buffalo Bills', 'BUF', '2022-02-24 00:11:33'),
(4, 'Carolina Panthers', 'CAR', '2022-02-24 00:11:40'),
(5, 'Cincinnati Bengals', 'CIN', '2022-02-24 01:19:03'),
(6, 'Dallas Cowboys', 'DAL', '2022-02-24 01:27:14'),
(7, 'Atlanta Falcons', 'ATL', '2022-02-24 01:27:36'),
(8, 'Chicago Bears', 'CHI', '2022-02-24 01:28:00'),
(9, 'Detroit Lions', 'DET', '2022-02-24 01:29:36'),
(10, 'Denver Broncos', 'DEN', '2022-02-24 01:30:06'),
(11, 'Cleveland Browns', 'CLE', '2022-02-24 01:30:44');

DELETE FROM `campeonatos`;
INSERT INTO `campeonatos` (`id`, `nome`) VALUES
(1, 'NFL'),(2, 'BRASILEIRO');


DELETE FROM `campeonatotimes`;
INSERT INTO `campeonatotimes` (`id`, `id_campeonato`, `id_time`, `pontuacao`) VALUES
(1, 1, 1, 0),
(2, 1, 8,0),
(3, 1, 2, 0),
(4, 1, 7, 0),
(5, 1, 3, 0),
(6, 1, 6,0),
(7, 1, 4,0),
(8, 1, 5,0);