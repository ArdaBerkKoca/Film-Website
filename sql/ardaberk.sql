-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 07 Haz 2024, 12:45:34
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ardaberk`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `film_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) DEFAULT '0',
  `dislikes` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `diller`
--

CREATE TABLE `diller` (
  `DilID` int(11) NOT NULL,
  `DilAdi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `diller`
--

INSERT INTO `diller` (`DilID`, `DilAdi`) VALUES
(5, 'English'),
(6, 'Spanish'),
(7, 'Chinese'),
(8, 'French'),
(9, 'German'),
(10, 'Russian'),
(11, 'Portuguese'),
(12, 'Italian'),
(13, 'Japanese'),
(14, 'Dutch'),
(15, 'Korean'),
(16, 'Arabic'),
(17, 'Turkish'),
(18, 'Polish'),
(19, 'Swedish'),
(20, 'Danish'),
(21, 'Finnish'),
(22, 'Norwegian'),
(23, 'Czech'),
(24, 'Greek');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favoriler`
--

CREATE TABLE `favoriler` (
  `FavoriID` int(11) NOT NULL,
  `FilmID` int(11) NOT NULL,
  `KullaniciID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmdislikes`
--

CREATE TABLE `filmdislikes` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmler`
--

CREATE TABLE `filmler` (
  `FilmID` int(11) NOT NULL,
  `KategoriID` int(11) DEFAULT NULL,
  `Baslik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `Aciklama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci,
  `Soundtrack` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `YoutubeLink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `YayinTarihi` date DEFAULT NULL,
  `Sure` smallint(6) DEFAULT NULL,
  `IMDBPuani` decimal(3,1) DEFAULT NULL,
  `ImgPath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `OyuncuIDs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `DilID` int(11) DEFAULT NULL,
  `YönetmenID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `filmler`
--

INSERT INTO `filmler` (`FilmID`, `KategoriID`, `Baslik`, `Aciklama`, `Soundtrack`, `YoutubeLink`, `YayinTarihi`, `Sure`, `IMDBPuani`, `ImgPath`, `OyuncuIDs`, `DilID`, `YönetmenID`) VALUES
(45, 1, 'the next three days', 'Lara Brennan\\\'ın (Elizabeth Banks) bir cinayetle suçlanmasıyla evli bir çiftin hayatı altüst olur. Lara\\\'nın kocası John (Russell Crowe), cezasının üzerinden üç yıl geçtikten sonra ailesini bir arada tutmak için mücadele ediyor ve karısının durumunun kötüleştiğini fark ederek onu hapisten çıkarmaya karar veriyor.', 'https://www.youtube.com/watch?v=s7e-uoSY_yA', 'https://www.youtube.com/watch?v=NPwO8FEjL-o', '2011-02-25', 123, '7.0', 'img/73b6717baca0fea33a74afb49f2d7c15.jpeg', NULL, 17, 56),
(46, 1, 'spider-man: lotus', 'Eski kız arkadaşının trajik ölümünün (görünüşe göre onu kurtarma girişiminin neden olduğu) ardından Peter Parker (Warden Wayne), geçmişteki suçluluk duygusuna devam ediyor ve ikinci kişiliğinin lanetinin tamamen gömülmesi gerekip gerekmediğini sorguluyor. Ölümcül hasta bir çocuğun Örümcek Adam\\\'la tanışmak istediği haberiyle karşılaşan Peter, onu son günlerinde teselli etme kararını düşünür.', 'https://www.youtube.com/watch?v=rrpH-ZXZS80', 'https://www.youtube.com/watch?v=_2mj51xksVg', '2023-08-03', 120, '3.0', 'img/9e5f808a70e049d83bc87ea33f1ccce6.jpeg', NULL, 5, 57),
(47, 1, 'thor: love and thunder', 'Thor, tanrıları yok etmeyi amaçlayan Tanrı Kasabı Gorr\\\'la savaşmak için Valkyrie, Korg ve eski kız arkadaşı Jane Foster\\\'ın yardımını ister.', 'https://www.youtube.com/watch?v=8W6OD6u0Cqw', 'https://www.youtube.com/watch?v=H5QpPZGq1aQ', '2022-07-08', 106, '6.0', 'img/9aa6c2f28545ce19f1f50a0bd6a18ebf.jpeg', NULL, 17, 59),
(48, 7, 'real steel', 'Robot boksunun en iyi sporlardan biri olduğu ve ıskartaya çıkarılan bir robotta şampiyon bulduğunu düşünen zor durumdaki bir organizatörün (Jackman) merkeze alındığı, gelecekte geçen bir hikaye. Zirveye doğru umut dolu yükselişi sırasında, babasını tanımak isteyen 11 yaşında bir oğlu olduğunu da keşfeder.', 'https://www.youtube.com/watch?v=piqtK9kcxjM&list=PLCSGe26DTvHPtzfjz3Oi8ZBF7aKKMnuMg&index=2', 'https://www.youtube.com/watch?v=9aSFRs2We7M', '2011-10-07', 106, '7.0', 'img/06a528caaf5933a1fce56894cb0e1a9f.jpeg', NULL, 17, 60),
(49, 7, 'war of the worlds', 'Uzaylı istilası insanlığın geleceğini tehdit ediyor. Bu felaket kabusu, hayatta kalma mücadelesi veren Amerikalı bir ailenin gözünden anlatılıyor.', 'https://www.youtube.com/watch?v=YZWn6NBXPOw', 'https://www.youtube.com/watch?v=hBIQM6qvrrU', '2005-06-23', 106, '6.0', 'img/9f188a591eefd9bde9826570e43ff18c.jpeg', NULL, 17, 4),
(50, 7, 'transformers: rise of the beasts', '90\\\'larda Transformers\\\'ın yeni bir grubu olan Maximals, Dünya savaşında müttefik olarak Autobot\\\'lara katılır.', 'https://www.youtube.com/watch?v=qPM6yjnICDU', 'https://www.youtube.com/watch?v=DuopX6LUHi8', '2023-06-09', 106, '6.0', 'img/ab4755fa2aac2ff86970c7ca999453df.jpeg', NULL, 17, 61),
(52, 1, 'crawl', 'Genç bir kadın (Kaya Scodelario), büyük bir kasırga sırasında babasını (Barry Pepper) kurtarmaya çalışırken kendini su basan bir evde mahsur kalır ve timsahlara karşı hayatı için savaşmak zorunda kalır.', 'https://www.youtube.com/watch?v=jNj7Ku0QTAc&list=PLohYzz4btpaTDbe3ULbRYlGaQaV8Atjfh', 'https://www.youtube.com/watch?v=RpJP5YyzYy8', '2019-07-12', 117, '6.0', 'img/33aba41b4461df005984fe3dd6ea531f.jpeg', NULL, 17, 63),
(53, 1, 'uncharted', 'Sokak zekası Nathan Drake, Ferdinand Magellan\\\'ın biriktirdiği ve 500 yıl önce Moncada Hanesi tarafından kaybedilen bir serveti geri almak için deneyimli hazine avcısı Victor \\\"Sully\\\" Sullivan tarafından işe alınır.', 'https://www.youtube.com/watch?v=IfXe0PsSaF0&list=PLohYzz4btpaTSe85z-lyx4D3VK0AJ356q', 'https://www.youtube.com/watch?v=Mym_HQxijlA', '2022-02-18', 106, '6.0', 'img/bb0248757a121970969b5641fd2f1e0e.jpeg', NULL, 17, 64),
(54, 3, 'free guy', 'Bir banka memuru olan Guy, kana susamış, açık dünyalı bir video oyununda oyuncu olmayan bir karakter olduğunu öğrenince hikayenin kahramanı haline gelir ve dünyayı kurtarma sorumluluğunu üstlenir.', 'https://www.youtube.com/watch?v=i1TpRV9onfg', 'https://www.youtube.com/watch?v=06fFGqJ4i-o', '2021-08-13', 106, '7.0', 'img/4c0e9605e95dfcf700badbc0f1353cd4.jpeg', NULL, 17, 60),
(55, 1, 'meg 2: the trench', 'Bir araştırma ekibi, okyanusun derinliklerini keşfederken kötü niyetli bir madencilik operasyonu da dahil olmak üzere birçok tehditle karşılaşır.', 'https://www.youtube.com/watch?v=zbztrjEKkgs&list=PLohYzz4btpaQyt-8iPod2Uv8eW5Z4aOiu', 'https://www.youtube.com/watch?v=6JU-JCnMphE', '2023-08-04', 118, '5.0', 'img/a0d6fa7e2bf2140c817eaab9df6607c5.jpeg', NULL, 17, 65),
(56, 1, 'rampage', 'Üç farklı hayvana tehlikeli bir patojen bulaştığında, bir primatolog ve bir genetikçi, onların Chicago\\\'yu yok etmesini engellemek için bir araya gelir.', 'https://www.youtube.com/watch?v=LmaDkb6j1SE&list=PLv1udYiEW0AOBMZ754Hc7yfuTSip6JuvE', 'https://www.youtube.com/watch?v=TgEFgIEv-uk', '2018-06-13', 106, '6.0', 'img/f37a248239a4a6c2638cb13229d5971e.jpeg', NULL, 17, 66),
(57, 1, 'journey 2: the mysterious island', 'Sean Anderson, efsanevi bir adada kaybolduğu düşünülen büyükbabasını bulma görevinde annesinin kocasıyla birlikte çalışır.', 'https://www.youtube.com/watch?v=2vm_AG5Ls7c&list=OLAK5uy_mVN45Kq3iKSYSE18QCZBoqkQgvIFq_ET8', 'https://www.youtube.com/watch?v=HJSmPwkYFxs', '2012-03-09', 117, '5.0', 'img/9df094f5d578cab77feb1a0456bc4a76.jpeg', NULL, 17, 66),
(58, 10, 'inkheart', 'Genç bir kız, babasının karakterleri kitaplardan çıkarmak konusunda inanılmaz bir yeteneğe sahip olduğunu keşfeder ve babasının, teyzesinin ve bir hikaye kitabının kahramanının yardımıyla, özgür kalan kötü adamın hepsini yok etmesini engellemeye çalışması gerekir.', 'https://www.youtube.com/watch?v=o7tQCRas7-A&list=PLF444D8E7C239CFC8', 'https://www.youtube.com/watch?v=kvOk2Td6Qwk', '2008-12-11', 106, '6.0', 'img/20afa5f4fd0701599aea3d0321a96219.jpeg', NULL, 17, 67),
(59, 1, 'the mechanic', 'Seçkin bir tetikçi, önceki kurbanlarından biriyle bağlantısı olan bir çırağa mesleğini öğretir.', 'https://www.youtube.com/watch?v=cze-RfsOkkc', 'https://www.youtube.com/watch?v=cagTeHj37a0', '2011-01-25', 117, '6.0', 'img/0a9d795907de12c236fedb891fc12aaa.jpeg', NULL, 17, 68),
(60, 3, 'home alone', 'Yanlışlıkla evde yalnız bırakılan sekiz yaşındaki baş belası, Noel arifesinde evini bir çift hırsıza karşı savunmak zorundadır.', 'https://www.youtube.com/watch?v=_bVOuOnO6mY&list=PL27E4F3D865056D8D', 'https://www.youtube.com/watch?v=uTk_csH67OA', '1991-01-18', 103, '7.0', 'img/fbf8d4c27e95e43ee7423a45e4d0b9cb.jpeg', NULL, 17, 69),
(61, 1, 'the hunger games: catching fire', 'Katniss Everdeen ve Peeta Mellark, 74. Açlık Oyunları\\\'ndaki zaferlerinin Panem Bölgelerinde bir isyana yol açmasının ardından Capitol\\\'ün hedefi haline gelir.', 'https://www.youtube.com/watch?v=bqsFaez3Pnc&list=PL6bnCAKfEJbgDh-ZQu5FXsPAF8idr18Kh', 'https://www.youtube.com/watch?v=kGBvtwwYjHA', '2013-11-22', 135, '7.0', 'img/b773aa84f812581e7658f821bdda5585.jpeg', NULL, 17, 70),
(62, 6, 'pride & prejudice', 'Canlı Elizabeth Bennet bekar, zengin ve gururlu Bay Darcy ile tanıştığında kıvılcımlar uçuşur. Ancak Bay Darcy istemeden de olsa kendi sınıfından bir kadına aşık olur. Herkes kendi gururunun ve önyargısının üstesinden gelebilir mi?', 'https://www.youtube.com/watch?v=GJvFu4mmx9c&list=PL261BBBCCA23B11F4', 'https://www.youtube.com/watch?v=TH7G6PbpFLc', '2006-02-03', 84, '7.0', 'img/c27acf00e798898fd5b0f7cc6401302b.jpeg', NULL, 17, 71),
(63, 3, 'mr. morgan\\\'s last love', 'Paris\\\'te Fransızca bilmeyen bir dul. Kendisi yaşının yarısından daha küçük bir dans eğitmeni. Bir aile olabilecekler mi, yoksa görüşmediği yetişkin çocukları arkadaşlığa son mu verecek?', 'https://www.youtube.com/watch?v=OW_Fv3qfqsE&pp=ygUcRW5yaXF1ZSBKYXJyaW4gTGEgRW5nYW5hZG9yYQ%3D%3D', 'https://www.youtube.com/watch?v=PIojqC2ctBg', '2013-10-18', 108, '6.0', 'img/0261f1ba1b28fdbcc836ceeb7f1c2db8.jpeg', NULL, 17, 72),
(66, 5, 'backcountry', 'Şehirli bir çift ormanda kamp yapmaya gider ve kendilerini yırtıcı bir kara ayının bölgesinde kaybolmuş halde bulur.', 'https://www.youtube.com/watch?v=tH11f9Cryhk&list=PLL3aLW3KFyz9gmSMtU6YGPz_WR8pmyCb3', 'https://www.youtube.com/watch?v=LLRq5HDEpIg', '2015-08-14', 78, '6.0', 'img/fa8f7e617a5a33267a3b8187250cae4c.jpeg', NULL, 17, 75),
(67, 7, 'divergent', 'Tris, erdemlere dayalı gruplarla bölünmüş bir dünyada Uyumsuz olduğunu ve buraya uyum sağlamayacağını öğrenir. Uyumsuzları yok etmeye yönelik bir komplo keşfettiğinde Tris ve gizemli Dörtlü, çok geç olmadan Uyumsuzları neyin tehlikeli hale getirdiğini bulmalıdır.', 'https://www.youtube.com/watch?v=drkhv11ljEs&list=PLd9BgLiXkdWX2Rr75Kf2cc8Ecz-GgK_ll', 'https://www.youtube.com/watch?v=Nzbtq2TDLEg', '2014-04-18', 129, '6.0', 'img/02c80f2a2f9b9bcbf41bd88ba993f95b.jpeg', NULL, 5, 76),
(68, 7, 'the facility', 'Bir uyuşturucu denemesi korkunç derecede ters gittiğinde sekiz gönüllü kendilerini hayatları için savaşırken bulur.', 'https://www.youtube.com/watch?v=z-3MTfOZhYc&list=PL8v7Wra-WPgamfON-abutSknOZ8_o9efc', 'https://www.youtube.com/watch?v=iGiDRyP9g5w', '2012-06-23', 72, '4.0', 'img/d072527ddf97824083acc8d07dfef8b4.jpeg', NULL, 17, 77),
(69, 7, 'kill command', 'Yakın gelecekte, insanı ölüm makineleriyle karşı karşıya getiren, teknolojiye bağımlı bir toplumda geçiyor.', 'https://www.youtube.com/watch?v=NbbMnDJWjag&list=PLvOU2OeQiM8Va-xP6naIJHOV6NeM0ix7v', 'https://www.youtube.com/watch?v=Z3i_nZnO3bA', '2016-05-13', 91, '5.0', 'img/2b639666066609936f2264448527182e.jpeg', NULL, 17, 78),
(70, 7, 'seeking a friend for the end of the world', 'Bir asteroit Dünya\\\'ya yaklaşırken, karısının panik içinde oradan ayrılmasının ardından bir adam kendini yalnız bulur. Lise aşkıyla yeniden bir araya gelmek için bir yolculuğa çıkmaya karar verir. Ona, farkında olmadan planını bozan bir komşu eşlik etmektedir.', 'https://www.youtube.com/watch?v=3y44BJgkdZs&list=PLYeBSXoQ4Loot6OYyZFAfzr3QwdSdg4A1', 'https://www.youtube.com/watch?v=TDdGzUELvMI', '2012-09-14', 81, '6.0', 'img/38fba4a791eca2f5963f61174c84ac60.jpeg', NULL, 17, 79),
(71, 7, 'cell', 'Gizemli bir cep telefonu sinyali kıyamet kaosuna neden olunca, bir sanatçı New England\\\'da küçük oğluyla yeniden bir araya gelmeye kararlıdır.', 'https://www.youtube.com/watch?v=VgYN8CyohpE&pp=ygUVQ2VsbCBtb3ZpZSBzb3VuZHRyYWNr', 'https://www.youtube.com/watch?v=RjXoZhlnHQc', '2016-05-19', 88, '4.0', 'img/470f978bc6ee3e4c1527ab4e04d8b68e.jpeg', NULL, 17, 80),
(72, 7, 'mafia: game of survival', 'Moskova, 2072. Her birinin kendi hikayesi ve amacı olan on iki yarışmacı, televizyonda yayınlanan bir Mafya oyunu oynuyor. Elenenlerin en büyük korkularını yenmek için sanal bir gerçekliğe girmeleri ya da bunu yaparken ölmeleri gerekiyor.', 'https://www.youtube.com/watch?v=DDpSwl-fJcU&pp=ygUjU3Vydml2YWwgZ2FtZSAyMDE2IG1vdmllIHNvdW5kdHJhY2s%3D', 'https://www.youtube.com/watch?v=1ORh72MxJI0', '2016-01-01', 91, '4.0', 'img/c37077c388a4902ec4f75dd49f20f8b8.jpeg', NULL, 17, 81),
(73, 7, 'apocalypse of ice', 'Dünya felaketle sonuçlanan donma tehlikesiyle karşı karşıya, ekvatoral güvenli bölge belirlendi. İnsanlığı pandemiden ve derin dondurucudan kurtarmak için tedaviyi bulan virologun 24 saat içinde oraya ulaşması gerekiyor.', 'https://www.youtube.com/watch?v=c7F0EVn6K5M&pp=ygUcQXBvY2FseXBzZSBvZiBJY2Ugc291bmR0cmFjaw%3D%3D', 'https://www.youtube.com/watch?v=-c1wLuS6AXc', '2020-08-23', 82, '2.0', 'img/5b87fbbc1419e2b3bbe148e8ad67e601.jpeg', NULL, 17, 82),
(74, 4, 'the merchant of venice', '16.yüzyıl Venedik\\\'inde, bir tüccar, romantik hırsları olan bir arkadaşı için suiistimal edilmiş bir Yahudi tefeciden aldığı büyük krediyi temerrüde düşürmek zorunda kalınca, acı bir intikam duygusuna sahip olan alacaklı, bunun yerine korkunç bir ödeme talep eder.\\r\\n', 'https://www.youtube.com/watch?v=orCN4el9INA', 'https://www.youtube.com/watch?v=HmS1rIZBGQg', '2006-06-12', 123, '7.0', 'img/43f44b49aa9bd275a258bd6b86c23a32.jpeg', NULL, 17, 83),
(75, 4, 'julius caesar', 'Julius Caesar\\\'ın büyüyen hırsı, yakın arkadaşı Brutus için büyük bir endişe kaynağıdır. Cassius, onu Sezar\\\'a suikast düzenlemeye yönelik planına katılmaya ikna eder, ancak ikisi de Mark Antony\\\'yi fena halde hafife almıştır.', 'https://www.youtube.com/watch?v=9r9vgAomAks&list=PLNhp6FTf08LvBHS1VbgXBsCh2H4JnEyOi', 'https://www.youtube.com/watch?v=MPAhYqTELOo', '1953-06-04', 109, '7.0', 'img/3c96bffd4486161cd64305577f66959d.jpeg', NULL, 17, 84),
(76, 4, 'caught İn flight diana', 'Prenses Diana, hayatının son iki yılında son bir geçiş törenine girişir: Pakistanlı kalp cerrahı Hasnat Khan\\\'la gizli bir aşk ilişkisi.\\r\\n', 'https://www.youtube.com/watch?v=V0ETO4m7z-k', 'https://www.youtube.com/watch?v=KsupJ_ol1mk', '2013-09-20', 107, '5.0', 'img/3430e98d633194f79d9939b3d9f76101.jpeg', NULL, 17, 85),
(77, 4, 'colonia', 'Genç bir kadının kaçırılan erkek arkadaşını çaresizce araması, onu şimdiye kadar kimsenin kaçamadığı meşhur Colonia Dignidad tarikatına sürükler.\\r\\n', 'https://www.youtube.com/watch?v=9ljwSx17r-Y', 'https://www.youtube.com/embed/H1wtPglsyxM?si=m-RLyAmX4MVMbZc6', '2015-09-15', 103, '7.0', 'img/664ffcce3a68b53a0e949aecb316602d.jpeg', NULL, 17, 86),
(78, 4, 'haganenet', 'Bir anaokulu öğretmeni, beş yaşındaki bir çocukta olağanüstü bir şiir yeteneği keşfeder. Bu genç çocuktan hem etkilenip hem de ilham alarak, herkese rağmen yeteneğini korumaya karar verir.\\r\\n', 'https://www.youtube.com/watch?v=X_5hFLDW2WU&list=PLohYzz4btpaQ1M31_4FtbXES8Hl8vDEJh', 'https://www.youtube.com/watch?v=VGsAZf6SBcQ&pp=ygUKZHJhbSBmaWxtIA%3D%3D', '2014-09-10', 113, '6.0', 'img/23e417bda532c491fb2e1e949f5259c0.jpeg', NULL, 17, 87),
(79, 4, 'please stand by', 'Genç bir otistik kadın, 500 sayfalık taslağını Paramount Pictures\\\'taki bir \\\"Star Trek\\\" yazma yarışmasına göndermek amacıyla bakıcısından kaçar.\\r\\n', 'https://www.youtube.com/watch?v=oOSQwBYm9rE', 'https://www.youtube.com/embed/bB9Lcqjzx6c?si=o-Nzqz06paRCYpik', '2018-01-26', 89, '6.0', 'img/2696124596aab499acb887ac10b9579b.jpeg', NULL, 17, 88),
(80, 4, 'heidi', 'Keçi güden büyükbabasıyla İsviçre Alpleri\\\'nde yaşayan genç bir kızın hikayesi.\\r\\n', 'https://www.youtube.com/watch?v=9jmpzrPegkw', 'https://www.youtube.com/watch?v=2HoQWCxM06o', '2015-01-11', 101, '7.0', 'img/8052a77a17121b9a94dd35a358442bae.jpeg', NULL, 17, 89),
(81, 4, 'tristan + isolde', 'Britanya\\\'nın tahtının ikinci varisi ile İrlanda\\\'daki kan davasının prensesi arasındaki ilişki, genç aşıklar için felakete yol açar.\\r\\n', 'https://www.youtube.com/watch?v=6onDx3c5e1s&list=PL6A4599C679B94CEB', 'https://www.youtube.com/watch?v=dBAP3VLftO0', '2006-01-13', 114, '6.0', 'img/921441778015dd3060ec26d5b0c80385.jpeg', NULL, 17, 90),
(82, 4, 'adoration', 'Bir çift çocukluk arkadaşı ve komşu, birbirlerinin oğullarına aşık olur.', 'https://www.youtube.com/watch?v=2b7RxBgwtCs', 'https://www.youtube.com/watch?v=RFUEDP9vZyA', '2014-02-21', 98, '6.0', 'img/c2514f6a282c66403a2f69c09884eac8.jpeg', NULL, 17, 91),
(83, 4, 'benim babam bir melek', 'Dört yaşındayken annesi Sandra tarafından terk edilen Ömer, babası Ümit ve babaannesi Rıukiye ile yaşamaktadır. Ümit eşi tarafından terk edildikten sonra telden düşüp sakat kalmış bir cambazdır. Ömer annesi gittiğinden beri Kız Kulesi’nde oturmayı hayal etmekte, bunun için para biriktirmektedir. Ömer bu çaresizliğin farkındadır fakat babasıyla birlikte mutlu bir yaşam sürmekte, onu bir kahraman olarak görmektedir. Ne var ki, Sandra geri gelip Ömer’in hayallerini yıkar ve onu babasından koparıp götürmek ister. Fakat Ömer babasını ve babaannesini bırakmak, hayallerinden vazgeçmek istemez. Anne,baba ve oğul arasında yürek yakan bir çarpışma başlar.\\r\\n', 'https://www.youtube.com/watch?v=Dqjq5UVpl_s', 'https://www.youtube.com/watch?v=KVaCQ1dExh8', '2022-06-03', 133, '6.0', 'img/b7eb70eb6bd481253207d7c3fc5bd3a8.jpeg', NULL, 17, 92),
(84, 5, 'ghost house', 'Tayland\\\'a macera dolu bir tatile giden genç bir çift, Hayalet Ev\\\'e safça saygısızlık ettikten sonra kendilerini kötü niyetli bir ruhun pençesinde bulur.\\r\\n', 'https://www.youtube.com/watch?v=k52FOs5DVXQ&list=OLAK5uy_khj2WvrD-VjY7Bp5TYI90ipFOkyFQx74U', 'https://www.youtube.com/watch?v=MTlWRGWG_yE', '2017-07-21', 93, '4.0', 'img/35399039d92c14fae5a7e147a35aae2c.jpeg', NULL, 17, 93),
(85, 5, 'the hole in the ground', 'İrlanda kırsalında oğluyla birlikte yaşayan bekar bir anne, oğlunun aslında kendi oğlu olmadığından şüphelenmeye başlar ve giderek rahatsız edici hale gelen davranışının, evlerinin arkasındaki ormandaki gizemli bir çukurla bağlantılı olmasından korkar.\\r\\n', 'https://www.youtube.com/watch?v=9ZHnzHUR4M4', 'https://www.youtube.com/watch?v=_aYXDqRIRow', '2019-03-01', 77, '5.0', 'img/47cfdb032f6e6f3028f22396fbf408d3.jpeg', NULL, 17, 94),
(86, 5, 'when animals dream', '16 yaşındaki Marie, ağır hasta annesi ve ailenin bakımını üstlenen babasıyla birlikte küçük bir adada yaşıyor. Ancak aniden gizemli ölümler meydana gelir ve Marie vücudunda tuhaf bir şeyler olduğunu hisseder.\\r\\n', 'https://www.youtube.com/watch?v=Lpa9kJGlO1M', 'https://www.youtube.com/watch?v=sCpcjXOq4Bc', '2014-07-31', 76, '5.0', 'img/0a95fb7f8bc689e6da0e4761e0d26591.jpeg', NULL, 17, 95),
(87, 5, 'ghost shark', '16 yaşındaki Marie, ağır hasta annesi ve ailenin bakımını üstlenen babasıyla birlikte küçük bir adada yaşıyor. Ancak aniden gizemli ölümler meydana gelir ve Marie vücudunda tuhaf bir şeyler olduğunu hisseder.\\r\\n', 'https://www.youtube.com/watch?v=-1eFddE5OBs', 'https://www.youtube.com/watch?v=VIXKSQmVdX4', '2013-08-22', 83, '3.0', 'img/c6b7edaeee1343abca46f6fcf1142b97.jpeg', NULL, 17, 96),
(89, 5, 'zombie night', 'Geceleri zombiler ortaya çıkıyor ve iki aile sabaha kadar hayatta kalmak zorunda kalıyor.\\r\\n', 'https://www.youtube.com/watch?v=NXMuCQ-hZsg&list=PLhX4yqa5P9Mh9EXAsQsBGrouImC2UOUFk', 'https://www.youtube.com/watch?v=nRsIvHguQ-0', '2013-10-26', 66, '3.0', 'img/ff3a2f77951692df8d367c21d29202d7.jpg', NULL, 17, 97),
(90, 5, 'babil-i cin', 'Babil-i Cin, cinlerin kendisine musallat olmasıyla kabus dolu günler geçiren bir kadının hikayesini konu ediyor. Ela\\\'ya henüz çocuk yaştayken cinler musallat olur. Rüyalarında yaşlı bir kadın gören Ela, kadının kendisini oğluyla evlendirmek istediğini ve onu eski bir kiliseye çağırdığını anlatır. Ela\\\'yı yaşadığı kabustan kurtaran hoca, ona hiçbir zaman evlenmemesi gerektiğini söyler. Ancak Ela 26 yaşına gelip nişanlandığında, kabus dolu günler yeniden başlar.\\r\\n', 'https://www.youtube.com/watch?v=Jfc_6PdKapg', 'https://www.youtube.com/watch?v=JFe7Us1Uvyo', '2024-01-28', 84, '3.0', 'img/27726bdccd833f44a604762959d5f566.jpeg', NULL, 17, 98),
(91, 5, 'spirit of fear', 'Bir adam boş bir banliyö evinde hafızasını kaybetmiş ve koluna kan bulaşmış halde uyanır.\\r\\n', 'https://www.youtube.com/watch?v=k02HEz73cUM', 'https://www.youtube.com/watch?v=wTGqBmUTCMQ', '2023-02-11', 78, '3.0', 'img/b0fcc621e86deb2892fbfe997830f54e.jpeg', NULL, 5, 99),
(92, 5, 'grieve', 'Sam bir yakınını kaybetmiş, hayatı bulanık ve tanınmaz hale gelmiştir. Annesinin ormandaki tatil evinden kaçarken, ormanda asırlık bir varlığın yaşadığından habersizdir.', 'https://www.youtube.com/watch?v=ezOCLO67j38', 'https://www.youtube.com/watch?v=-TIbuRvU7Kc', '2023-05-14', 66, '4.0', 'img/61474a8c10e852e99401d98484495f11.jpeg', NULL, 5, 100),
(93, 5, 'the mare', 'Genç bir adam yavaş yavaş kendini bir rüya dünyasına ve kendi kabuslarına kaptırır. Peki ya rüyalar gerçekse?\\r\\n', 'https://www.youtube.com/watch?v=3Ix2-HV63Ek&list=PL8imCBuJx8BeXen0sGWgIEJfzhaKiSYzX', 'https://www.youtube.com/watch?v=eMtjnHTull4', '2020-04-12', 74, '4.0', 'img/e4262bbaeb6e538ec70251db28384891.jpeg', NULL, 5, 101),
(103, 3, 'Eltilerin Savaşı\r\n', 'Sosyal medyaya olan düşkünlükleriyle tanınan Gizem ve Sultan\\\'ın evlilik anlayışları farklıdır. İki kadın birbiriyle bitmek bilmeyen bir rekabete girer.\\r\\n', 'https://www.youtube.com/watch?v=WtTVbEM6iQU', 'https://www.youtube.com/embed/Opq-mGRiVSQ?si=UE2Sct_ixp7t-9Zb', '2020-01-31', 114, '5.0', 'img/3fca548887a6e283859f6a51448840cb.jpeg', NULL, 17, 103),
(104, 3, 'a.r.o.g', 'Komutan Logar, Arif\\\'i kandırıp onu 1.000.000 yıl geriye gönderir. Geçmişten günümüze gelen insanları uygarlaştırmalıdır.\\r\\n', 'https://www.youtube.com/watch?v=b6goDeTWUR8', 'https://www.youtube.com/watch?v=LhiFw_2EasE&pp=ygUZYXJvZyBmdWxsIGl6bGUgdGVrIHBhcsOnYQ%3D%3D', '2008-01-05', 120, '7.0', 'img/926b3e862e1458ca4f242f211df9fc87.jpeg', NULL, 17, 104),
(105, 3, 'Kolpaçino: Bir Şehir Efsanesi\r\n', 'Şiddetli bir çatışmanın ardından bir grup adam iki cesedi saklamak zorunda kalır.\\r\\n', 'https://www.youtube.com/watch?v=IrHgm3qGCxA&list=PL49x4Za9nhuVEtuQvUEG_Fk5_tgVDGgFk', 'https://www.youtube.com/watch?v=7xEF-dKZDTE&pp=ygUPa29tZWRpIGZpbG1sZXJp', '2009-10-29', 132, '6.0', 'img/791793676927db9e40403a2c6c207e0d.jpeg', NULL, 17, 105),
(106, 3, 'Maskeli Beşler İntikam Peşinde\r\n', '2005 yılının en çok hasılat yapan altıncı Türk filmi olan, hayatlarının en büyük soygununa kalkışan beceriksiz bir suçlu çetesini konu alan, yönetmenliğini Murat Aslan\\\'ın üstlendiği Türk komedi filmi.\\r\\n', 'https://www.youtube.com/watch?v=5y12iDiULMg', 'https://www.youtube.com/watch?v=0h6u8BQrfug&pp=ygUPa29tZWRpIGZpbG1sZXJp', '2005-10-28', 85, '4.0', 'img/d1643064048664c3f1586fd890ac91ce.jpeg', NULL, 17, 106),
(107, 3, 'Yahşi Batı\r\n', '1881 yılında iki Osmanlı Gizli Ajanı, padişahın isteği üzerine, değerli bir pırlantayı cumhurbaşkanına hediye etmek üzere ABD\\\'ye gider.\\r\\n', 'https://www.youtube.com/watch?v=zz_WgOD07Zg', 'https://www.youtube.com/embed/U_KrB31T84g?si=d27rX6TBKYPO3D72', '2010-01-01', 113, '7.0', 'img/bbc380f090da8dd2c9b9932da93c0051.jpeg', NULL, 17, 107),
(108, 3, 'Hababam Sınıfı \r\n', 'Tembel, eğitimsiz öğrenciler arasında çok yakın bir bağ vardır. En son şakalarını planladıkları yurtta birlikte yaşıyorlar. Yeni bir müdür geldiğinde öğrenciler doğal olarak onu devirmeye çalışırlar. Bunu aptalların komik bir savaşı takip ediyor.\\r\\n', 'https://www.youtube.com/watch?v=4yJoezohpAw', 'https://www.youtube.com/embed/hf2-8MRPGu8?si=xXtAa1FrLWtd_-yy', '1975-06-10', 86, '9.0', 'img/c35e7b059c27373a40688c544b0549ff.jpeg', NULL, 17, 108),
(109, 3, 'Çöpçüler Kralı', 'Basmakalıp bir mahallede günlük rutinini sürdüren bir sokak temizlikçisi, bir temizlikçi kadına aşık olur. Ne yazık ki onun için patronu da öyle.\\r\\n', 'https://www.youtube.com/watch?v=dZ0_S8UXnI4&list=RDQMz2APmL4uJd8&start_radio=1', 'https://www.youtube.com/embed/xs9XUjHvZsM?si=Z9_83rjoSznKAFjy', '1978-02-01', 79, '8.0', 'img/31c2b6f6fd030841601986be55c06a1d.jpeg', NULL, 17, 109),
(110, 10, 'ice age', 'Hikaye sıfırın altındaki kahramanlar etrafında dönüyor: yünlü bir mamut, kılıç dişli bir kaplan, bir tembel hayvan ve Scrat olarak bilinen bir sincap ile farenin tarih öncesi birleşimi.\\r\\n', 'https://www.youtube.com/watch?v=UIXmm7SUdg4&list=PLr-0bzdnd39-DT1VAEg7Xgq7BA5L8RYc3', 'https://www.youtube.com/embed/hSM539KqV6A?si=ZSOY1YsyV9PVcHiI', '2003-01-31', 81, '7.0', 'img/eb9263a20007cc2c96afdd225ec4c706.jpeg', NULL, 17, 110),
(111, 10, 'monster family', 'Ünvanına rağmen Wishbone ailesi mutlu olmaktan çok uzak. Aile olarak yeniden bağ kurmaya çalışan Anne ve Emma, ​​dışarıda eğlenceli bir gece geçirmeyi planlar. Ancak kötü bir cadı onları lanetlediğinde planı ters teper ve hepsi Canavarlara dönüşür.\\r\\n', 'https://www.youtube.com/watch?v=JzACZzWcBQs&list=PLRaZX25NRlZxQ21DmIt2oIk-p_Ka7jb5t', 'https://www.youtube.com/embed/5U4wUnj2t8A?si=hOvXEtWUE8lXgmMt', '2020-08-12', 69, '4.0', 'img/383c16cb63030b0a7068fe2eebb93cc8.jpeg', NULL, 17, 111),
(112, 10, 'pets united', 'Gösterişli kedi Belle\\\'nin liderliğindeki bir grup şımarık, bencil evcil hayvan, yaşadıkları hipermodern metropol Robo City\\\'yi işleten makineler çılgına dönüp yönetimi ele geçirince, lüks mekânları \\\'Pampered Pets\\\'te mahsur kalırlar.\\r\\n', 'https://www.youtube.com/watch?v=WrypTo3Uscs&list=PLRW80bBvVD3U_tEGmh28RgjYFi6q8siF2', 'https://www.youtube.com/embed/9ZfQK3mS3QE?si=-fJDeNrO8IX7vWiW', '2019-11-08', 92, '3.0', 'img/667e5f7fa1f00e085cb3830bae3eab5e.jpeg', NULL, 17, 112),
(113, 10, 'tea pets', 'Bir grup çay hayvanı (çay içenlere iyi şans getiren sevimli kil heykelcikler) efsanevi bir mistik bulmak için büyülü bir animasyon maceraya atılıyor.', 'https://www.youtube.com/watch?v=ZyvMUp7Vt5Q&list=PLLQyrCIfk22cxO4p3TrkCVH-DWlWK363j', 'https://www.youtube.com/embed/YQu3hQWp2RQ?si=SvhleYsOB3R2YBFH', '2017-07-21', 98, '5.0', 'img/d005e21d14f1a8b64a5ea367f783dbb6.jpeg', NULL, 17, 113),
(114, 10, 'the son of bigfoot', 'Genç bir oğlan, kayıp babasını bulmak için yola çıkar, ancak onun aslında Koca Ayak olarak bilinen efsanevi yaratık olduğunu keşfeder.', 'https://www.youtube.com/watch?v=EDj-WFQiSzw&list=PLOrSQEXqdLhOPLLbNAREfS1l-013o6zSV', 'https://www.youtube.com/embed/a8OH5Wyq0Zs?si=Jp0xKcYNrnm89RZw', '2017-09-22', 89, '6.0', 'img/e8f4174210e90ada6593127baf28d099.jpeg', NULL, 17, 114),
(115, 10, 'ainbo: spirit of the amazon', 'Muhteşem Amazon Yağmur Ormanı\\\'ndaki evlerini kurtarmak için bir göreve çıkan genç bir kahraman ve Ruh Rehberleri, sevimli ve esprili armadillo \\\"Dillo\\\" ile aptal, büyük boy tapir \\\"Vaca\\\"nın destansı yolculuğu.', 'https://www.youtube.com/watch?v=VeJ41yUb4kk', 'https://www.youtube.com/embed/Uy8WtdwlMQo?si=rMcVp9fCQaI9Hrbb', '2021-05-20', 82, '4.0', 'img/7102d66f2732efd6accf4bf2df478732.jpeg', NULL, 17, 115),
(116, 10, 'around the world in 80 days', 'Kitap tutkunu bir marmoset, açgözlü bir kurbağanın meydan okumasını kabul ettikten sonra 80 gün içinde gezegeni dolaşmak için çılgın bir maceraya atılır.', 'https://www.youtube.com/watch?v=SO9qSP8Cz1M&list=PLtrMHeX5d99nO25MmgMykJOZkqXKTtYw5', 'https://www.youtube.com/embed/1J-6AIbdasY?si=bL8ox6ZPSDKKL7mf', '2023-06-09', 83, '4.0', 'img/286418b48f21523ce15c5c8f0287ff23.jpeg', NULL, 17, 116),
(117, 10, 'the queen\\\'s corgi', 'İngiliz hükümdarının (Dame Julie Walters\\\'ın) en sevdiği köpeği sarayda kaybolur ve kendini bir köpek dövüşü kulübünde bulur. Daha sonra eve dönüş yolunu bulmak için uzun yolculuğuna başlar.', 'https://www.youtube.com/watch?v=teMtzHMpJ3E&list=PLCf0TlhBVLXBPupjA9N5hvU6PYrmq9-ji', 'https://www.youtube.com/embed/7cyrtSOzD2I?si=1SVx-rIN7f9-Bwyb', '2019-04-03', 84, '4.0', 'img/90c14852cacc82b0912234bbab07b88d.jpeg', NULL, 17, 117),
(118, 10, 'go fish', 'Gizemli siyah bir keçi, cennet gibi bir deniz altı kasabasına ulaştığında, cesur ve özverili bir papağan balığının, kaynağı bulmak ve mercan resifleri yok edilmeden önce onu düzeltmek için okyanusu geçmesi gerekir.', 'https://www.youtube.com/watch?v=wslp_-_a-i0&list=PLCAzI93ZaYPdBRoconC-wfavczlptKM51', 'https://www.youtube.com/embed/VIh4YPRwix8?si=GJCS0dSmUyIXqOwx', '2019-11-06', 73, '3.0', 'img/1ca332065a4b9c96f95f90353223d902.jpeg', NULL, 17, 118),
(119, 6, 'hadi insallah', 'Hadi İnşallah, genç bir kadın olan Pucca\\\'nın hikayesini anlatıyor. PuCCa, hayatının 4 senesini Ankara\\\'da geçirir ama o koca sene boyunca beraber olduğu sevgilisinden de ayrılırak, İzmir\\\'e ailesinin yanına döner. Zor bir ayrılık süreciyle karşı karşıyadır, mutsuzluktan eve kapanır; çalmayan telefonları bekler ve bunalımdaki pek çok kadın gibi kendisini yemeye verir! Bu arada ailesi de kendisine yeni bir iş bulup, toparlanması için baskı yapar. Hiç istemeden İzmir\\\'deki bir yerel televizyon kanalıyla iş görüşmesine gider; ve yaşamını değiştirecek yakışıklı ile o gün karşılaşır! \\\"Pekmez\\\" lakabını taktığı ve genç kadını yeniden yaşama döndüren bu yakışıklı ile ne yapıp edip beraber olmayı kafaya koyar... Ama karşısında da zorlu bir rakibesi vardır... Ali Taner Baltacı yönetmenliğinde hayata geçen komedi filminin yapımcılığını 25 Film üstleniyor. Film, yazdığı blog ile sosyal medya fenomeni olan Pucca lakaplı bir kadının, dizüstü edebiyatı kapsamında yayınladığı kitaplardan senaryolaştırıldı.', 'https://www.youtube.com/watch?v=t4Vj66SUFcs', 'https://www.youtube.com/embed/EKZu3bsH_Co?si=iHLeuxlYNd4dD2pQ', '2014-11-28', 92, '5.0', 'img/e05792a0a03358d95c2408c533d9ff4d.jpeg', NULL, 17, 119),
(120, 6, 'home again', 'Los Angeles\\\'ta bekar bir annenin hayatı, üç gencin yanına taşınmasına izin vermesiyle beklenmedik bir hal alır.', 'https://www.youtube.com/watch?v=dYle0GtkxsA&list=PLohYzz4btpaTCA5J6D5iz-1Ht8tlXJhBh', 'https://www.youtube.com/watch?v=-5nFP3Nqg7w', '2017-09-08', 92, '5.0', 'img/40e11c5c614c4de08bff742f024a1fef.jpeg', NULL, 17, 120),
(121, 6, 'Aşk Tesadüfleri Sever\r\n', 'Yıl 1977, bir Eylül sabahı Ankara\\\'da... Yılmaz, hamile karısı Neriman\\\'ı hastaneye yetiştirmeye çalışırken Ömer\\\'in arabasına çarpar. Bu kaza Ömer\\\'in arka koltukta oturan hamile eşi İnci\\\'nin erken doğum yapmasına neden olur. Bebekler aynı gün doğarlar. Birbirlerini ilk kez görüyorlar.', 'https://www.youtube.com/watch?v=NpchNS3_ugg&list=PLN7Mz22vezPZJ1HUeBxTO83vmAQQwQBf8', 'https://www.youtube.com/embed/qJYljBrFNs0?si=9Nq7JG_sM1-VRRfw', '2006-11-17', 122, '7.0', 'img/057266687e952ec73aaf67772b46b946.jpeg', NULL, 17, 107),
(122, 6, 'ask bu mu?', 'Umut çocukluğundan beri hırsızdır. Sürekli hayatının ve ailesinin fırsatını arar. O da bulamıyor. Gülüm, hayatında hiçbir sorunu olmayan, okulunu zamanında bitirmiş, hayallerine sadece bir adım uzaklıkta olan bir genç kızdır. Ancak hayallerine doğru o adımı atmadan önce asılı kalır ve düşer.', 'https://www.youtube.com/watch?v=x7KSR3S7Yq4&list=PLGq8JCkcsJKDMee3tfxXpSpyGmv5v5qMy', 'https://www.youtube.com/embed/D8t7j7PAOUc?si=MI7IWcBdDb8ggvB9', '2018-12-11', 104, '4.0', 'img/77e1f04728f27a9972aff46d78d406c8.jpeg', NULL, 17, 122),
(123, 6, 'Bu İşte Bir Yalnızlık Var\r\n', 'Emekli bir gitarist, kızıyla vakit geçirip çocuklara gitar çalmayı öğreterek orta yaş krizinden kurtulmayı başarıyor. Ancak ancak yeni bir kız arkadaş edinene kadar nihayet krizine bir çözüm bulabilir.', 'https://www.youtube.com/watch?v=9oo-94t3fzM', 'https://www.youtube.com/watch?v=-6jLCcPAI-I&pp=ygURcm9tYW50aWsgZmlsbWxlcmk%3D', '2016-05-23', 113, '5.0', 'img/e0a2938977c7fd0a0cf432e8f925c901.jpeg', NULL, 17, 123),
(124, 6, 'engelli ask', 'Ayşe, üniversitede sinema okuyan varlıklı bir aileden gelen inançlı ve modern bir kızdır. Çocukluğundan beri şeker hastası olan Ayşe ailesi tarafından tam olarak büyütüldü. Üniversitede Ayşe\\\'den hoşlanan iki genç Cenk ve Fatih, Ayşe\\\'nin arkadaşı Melis aracılığıyla onunla tanışmak isterler. Cenk, Fatih\\\'ten önce davranıp Ayşe\\\'yle önceden buluşmak için arabalarını koydukları otoparkta küçük bir park kazası düzenler. Neşeli, yaramaz ve aynı zamanda zengin bir yapıya sahip olan Cenk, aynı zamanda mesafeli ve kibar davranarak Ayşe\\\'nin dikkatini çekmeyi de başarıyor. Ayşe ve Cenk birbirlerinden etkilenseler de aslında dünyaları çok farklıdır.', 'https://www.youtube.com/watch?v=3fHCJtaWHbw', 'https://www.youtube.com/embed/oxTi7gHgXw4?si=IzgCnJexZoI9gyBI', '2023-07-03', 100, '3.0', 'img/422c4f3876a8e368fa1f5ad72b338646.jpeg', NULL, 17, 124),
(125, 6, 'mutluluk zaman', 'Gerçek aşk kusursuzlukla ilgili değildir, kusurlarda gizlidir. Mert kendi geçmişiyle yüzleşmeden mükemmel hayatını yaratırken Ada da geçmişteki tüm kişisel deneyimlerinden yola çıkarak kendi yaşam tarzını inşa ediyor.', 'https://www.youtube.com/watch?v=8qzxBqEgMPs', 'https://www.youtube.com/watch?v=RNTMIhnGWSs', '2017-11-09', 105, '5.0', 'img/986fb4ad3ece9050b4ff93bc4e823833.jpeg', NULL, 17, 125),
(126, 6, 'Kendime İyi Bak\r\n', 'İçine kapanık bir romantik, ölen eski sevgilisinin tuzağına düştüğünü öğrendikten sonra gerçekleri araştırmaya başlar. Kız arkadaşından ayrılır ve sorularına yanıt aramaya başlar.', 'https://www.youtube.com/watch?v=6LeJyEUMvDE', 'https://www.youtube.com/watch?v=77cTBkoZreg&pp=ygURcm9tYW50aWsgZmlsbWxlcmk%3D', '2013-11-09', 88, '6.0', 'img/2186e2c8d9d5cd215e1f910b80618c64.jpeg', NULL, 17, 126),
(127, 6, 'sadece sen', 'Eski bir boksör kör bir kadına aşık olur ve yeni bir hayat kurmaya başlar, ancak karanlık geçmişi ikisini de tehlikeye atacak şekilde geri döner.', 'https://www.youtube.com/watch?v=pF67g5a_iak', 'https://www.youtube.com/embed/7c3WQ8gF0QI?si=gZrn7zkYQ9VaBdSc', '2014-03-14', 101, '7.0', 'img/a847cf3cb5898c300c07eb06ffbdc8dd.jpeg', NULL, 17, 127);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmlikes`
--

CREATE TABLE `filmlikes` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmoyuncular`
--

CREATE TABLE `filmoyuncular` (
  `FilmID` int(11) NOT NULL,
  `OyuncuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `filmoyuncular`
--

INSERT INTO `filmoyuncular` (`FilmID`, `OyuncuID`) VALUES
(49, 17),
(45, 20),
(47, 27),
(61, 31),
(47, 33),
(71, 36),
(53, 38),
(45, 41),
(57, 42),
(63, 42),
(47, 44),
(48, 46),
(45, 60),
(45, 61),
(45, 62),
(45, 63),
(45, 64),
(45, 65),
(46, 66),
(46, 67),
(46, 68),
(48, 69),
(48, 70),
(49, 72),
(50, 73),
(50, 74),
(50, 75),
(56, 76),
(57, 76),
(52, 80),
(52, 81),
(52, 82),
(53, 83),
(53, 84),
(54, 85),
(54, 86),
(54, 87),
(55, 88),
(59, 88),
(55, 89),
(55, 90),
(56, 91),
(56, 92),
(57, 93),
(61, 93),
(58, 94),
(58, 95),
(58, 96),
(59, 97),
(59, 98),
(60, 99),
(60, 100),
(60, 101),
(61, 102),
(62, 103),
(70, 103),
(62, 104),
(62, 105),
(63, 106),
(63, 107),
(66, 114),
(66, 115),
(66, 116),
(67, 117),
(67, 118),
(68, 121),
(68, 122),
(68, 123),
(69, 124),
(69, 125),
(69, 126),
(70, 127),
(70, 128),
(71, 129),
(71, 130),
(72, 132),
(72, 133),
(72, 134),
(73, 135),
(73, 136),
(73, 137),
(74, 138),
(74, 139),
(74, 140),
(75, 141),
(75, 142),
(75, 143),
(76, 144),
(82, 144),
(76, 145),
(76, 146),
(77, 147),
(77, 148),
(77, 149),
(78, 150),
(78, 151),
(78, 152),
(79, 153),
(79, 154),
(79, 155),
(80, 156),
(80, 157),
(80, 158),
(81, 159),
(81, 160),
(81, 161),
(82, 163),
(82, 164),
(83, 165),
(83, 166),
(83, 167),
(84, 168),
(84, 169),
(84, 170),
(85, 171),
(85, 172),
(85, 173),
(86, 174),
(86, 175),
(86, 176),
(87, 177),
(87, 178),
(87, 179),
(89, 180),
(89, 181),
(89, 182),
(90, 183),
(90, 184),
(90, 185),
(91, 186),
(91, 187),
(91, 188),
(92, 189),
(92, 190),
(92, 191),
(93, 192),
(93, 193),
(93, 194),
(103, 196),
(103, 197),
(103, 198),
(104, 199),
(107, 199),
(104, 200),
(104, 201),
(105, 202),
(105, 203),
(106, 203),
(105, 204),
(106, 205),
(106, 206),
(107, 207),
(107, 208),
(108, 209),
(109, 209),
(108, 210),
(108, 211),
(109, 212),
(109, 213),
(110, 214),
(110, 215),
(110, 216),
(111, 217),
(111, 218),
(111, 219),
(112, 220),
(112, 221),
(112, 222),
(113, 223),
(113, 224),
(113, 225),
(114, 226),
(114, 227),
(114, 228),
(115, 229),
(115, 230),
(115, 231),
(116, 232),
(116, 233),
(116, 234),
(117, 235),
(117, 236),
(117, 237),
(118, 238),
(118, 239),
(118, 240),
(119, 241),
(119, 242),
(119, 243),
(120, 244),
(120, 245),
(120, 246),
(121, 247),
(121, 248),
(121, 249),
(122, 250),
(122, 251),
(122, 252),
(123, 254),
(123, 255),
(123, 256),
(124, 257),
(124, 258),
(124, 259),
(125, 260),
(125, 261),
(125, 262),
(126, 263),
(126, 264),
(126, 265),
(127, 266),
(127, 267),
(127, 268);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `KategoriID` int(11) NOT NULL,
  `KategoriAdi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`KategoriID`, `KategoriAdi`) VALUES
(1, 'Aksiyon'),
(3, 'Komedi'),
(4, 'Dram'),
(5, 'Korku'),
(6, 'Romantik'),
(7, 'Bilim Kurgu'),
(10, 'Çocuk');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `KullaniciID` int(11) NOT NULL,
  `KullaniciAdi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `Sifre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `TelefonNo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyuncular`
--

CREATE TABLE `oyuncular` (
  `OyuncuID` int(11) NOT NULL,
  `AdSoyad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `oyuncular`
--

INSERT INTO `oyuncular` (`OyuncuID`, `AdSoyad`) VALUES
(6, 'Robert De Niro'),
(7, 'Leonardo DiCaprio'),
(8, 'Tom Hanks'),
(9, 'Johnny Depp'),
(10, 'Brad Pitt'),
(11, 'Meryl Streep'),
(13, 'Morgan Freeman'),
(14, 'Denzel Washington'),
(15, 'Harrison Ford'),
(16, 'Jack Nicholson'),
(17, 'Tom Cruise'),
(18, 'Will Smith'),
(19, 'Matt Damon'),
(20, 'Russell Crowe'),
(21, 'Angelina Jolie'),
(22, 'Scarlett Johansson'),
(23, 'Julia Roberts'),
(24, 'Charlize Theron'),
(25, 'Nicole Kidman'),
(26, 'Cate Blanchett'),
(27, 'Christian Bale'),
(28, 'Joaquin Phoenix'),
(29, 'Daniel Day-Lewis'),
(30, 'Emma Stone'),
(31, 'Jennifer Lawrence'),
(32, 'Amy Adams'),
(33, 'Natalie Portman'),
(35, 'Anne Hathaway'),
(36, 'Samuel L. Jackson'),
(37, 'Ryan Gosling'),
(38, 'Mark Wahlberg'),
(39, 'Keanu Reeves'),
(40, 'Clint Eastwood'),
(41, 'Liam Neeson'),
(42, 'Michael Caine'),
(43, 'Robert Downey Jr.'),
(44, 'Chris Hemsworth'),
(45, 'Chris Evans'),
(46, 'Hugh Jackman'),
(47, 'Jake Gyllenhaal'),
(48, 'Javier Bardem'),
(49, 'Benicio del Toro'),
(50, 'Edward Norton'),
(51, 'Heath Ledger'),
(52, 'Philip Seymour Hoffman'),
(53, 'Jeff Bridges'),
(54, 'Sean Penn'),
(55, 'Tom Hardy'),
(58, 'Sylvester Stallone'),
(59, 'Arnold Schwarzenegger'),
(60, 'Elizabeth Banks'),
(61, 'Olivia Wilde'),
(62, 'RZA'),
(63, 'Jonathan Tucker'),
(64, 'Brian Dennehy'),
(65, 'Lennie James'),
(66, ' Warden Wayne'),
(67, 'Sean Thomas Reid'),
(68, 'Moriah Brooklyn'),
(69, 'Evangeline Lilly'),
(70, 'Dakota Goyo'),
(72, 'Tim Robbins'),
(73, ' Anthony Ramos'),
(74, 'Dominique Fishback'),
(75, 'Luna Lauren Velez'),
(76, ' Dwayne Johnson'),
(77, 'Karen Gillan'),
(78, 'Kevin Hart'),
(80, 'Kaya Scodelario'),
(81, 'Barry Pepper'),
(82, 'Morfydd Clark'),
(83, 'Tom Holland'),
(84, 'Antonio Banderas'),
(85, 'Ryan Reynolds'),
(86, 'Jodie Comer'),
(87, 'Taika Waititi'),
(88, ' Jason Statham'),
(89, 'Jing Wu'),
(90, 'Shuya Sophia Cai'),
(91, 'Naomie Harris'),
(92, 'Malin Akerman'),
(93, 'Josh Hutcherson'),
(94, ' Brendan Fraser'),
(95, 'Andy Serkis'),
(96, 'Eliza Bennett'),
(97, 'Ben Foster'),
(98, 'Donald Sutherland'),
(99, 'Macaulay Culkin'),
(100, 'Joe Pesci'),
(101, 'Daniel Stern'),
(102, 'Liam Hemsworth'),
(103, 'Keira Knightley'),
(104, 'Matthew Macfadyen'),
(105, 'Brenda Blethyn'),
(106, 'Michelle Goddet'),
(107, 'Jane Alexander'),
(108, 'LeBron James'),
(109, 'Romeo Travis'),
(110, 'Dru Joyce'),
(111, 'Bruce Lee'),
(112, 'Bruce Li'),
(113, 'Ryong Keo'),
(114, ' Jeff Roop'),
(115, 'Missy Peregrym'),
(116, 'Nicholas Campbell'),
(117, ' Shailene Woodley'),
(118, 'Theo James'),
(119, 'Kate Winslet'),
(121, 'Aneurin Barnard'),
(122, 'Chris Larkin'),
(123, 'Amit Shah'),
(124, 'Thure Lindhardt'),
(125, 'Vanessa Kirby'),
(126, 'David Ajala'),
(127, 'Steve Carell'),
(128, 'Melanie Lynskey'),
(129, 'Isabelle Fuhrman'),
(130, ' John Cusack'),
(131, 'Samuel L. Jackson'),
(132, 'Vadim Tsallati'),
(133, 'Violetta Getmanskaya'),
(134, 'Venyamin Smekhov'),
(135, 'Ramiro Leal'),
(136, 'Emily Killian'),
(137, 'Tom Sizemore'),
(138, 'Joseph Fiennes'),
(139, 'Lynn Collins'),
(140, 'Al Pacino'),
(141, 'Louis Calhern'),
(142, 'Marlon Brando'),
(143, 'James Mason'),
(144, 'Naomi Watts'),
(145, 'Cas Anvar'),
(146, 'Naveen Andrews'),
(147, 'Emma Watson'),
(148, 'Daniel Brühl'),
(149, 'Michael Nyqvist'),
(150, 'Sarit Larry'),
(151, 'Avi Shnaidman'),
(152, 'Lior Raz'),
(153, 'Dakota Fanning'),
(154, 'Alice Eve'),
(155, 'Toni Collette'),
(156, 'Anuk Steffen'),
(157, 'Anna Schinz'),
(158, 'Lilian Naef'),
(159, 'James Franco'),
(160, 'Sophia Myles'),
(161, 'Rufus Sewell'),
(162, 'Naomi Watts'),
(163, 'Robin Wright'),
(164, 'Xavier Samuel'),
(165, 'Aybars Kartal Özson'),
(166, 'Olgun Toker'),
(167, 'Meral Çetinkaya'),
(168, 'Scout Taylor-Compton'),
(169, 'James Landry Hébert'),
(170, 'Mark Boone Junior'),
(171, 'Seána Kerslake'),
(172, 'James Quinn Markey'),
(173, 'Kati Outinen'),
(174, 'Sonia Suhl'),
(175, 'Lars Mikkelsen'),
(176, 'Sonja Richter'),
(177, 'Robert Aberdeen'),
(178, 'Jayme Bohn'),
(179, 'Eliot Brasseaux'),
(180, 'Anthony Michael Hall'),
(181, 'Daryl Hannah'),
(182, 'Alan Ruck'),
(183, 'Tugba Duygu'),
(184, 'Gülfem Egilmez'),
(185, 'Ersin Özkan'),
(186, 'Christopher Lee Page'),
(187, 'Kevin Bohleber'),
(188, 'Jordinn Ballenger'),
(189, 'Joseph Casey'),
(190, 'Danielle Keaton'),
(191, 'Madeleine Koestner'),
(192, 'Kim Kvamme'),
(193, 'Karoline Stemre'),
(194, 'Grethe Mikaelsen'),
(195, '-'),
(196, 'Gupse Özay'),
(197, 'Merve Dizdar'),
(198, 'Ferit Aktug'),
(199, 'Cem Yilmaz'),
(200, 'Özge Özberk'),
(201, 'Zafer Algöz'),
(202, 'Aydemir Akbas'),
(203, 'Safak Sezer'),
(204, 'Ali Çatalbas'),
(205, 'Peker Açikalin'),
(206, 'Cengiz Küçükayvaz'),
(207, 'Ozan Güven'),
(208, 'Demet Evgar'),
(209, 'Kemal Sunal'),
(210, 'Münir Özkul'),
(211, 'Halit Akçatepe'),
(212, 'Aysen Gruda'),
(213, 'Sener Sen'),
(214, 'Denis Leary'),
(215, 'John Leguizamo'),
(216, 'Ray Romano'),
(217, 'Dirk Stollberg'),
(218, 'Emily Watson'),
(219, 'Jason Isaacs'),
(220, 'Felix Auer'),
(221, 'Natalie Dormer'),
(222, 'Patrick Roche'),
(223, 'Aurora Jane Baldovini'),
(224, 'Hung Huang'),
(225, 'Guanlin Ji'),
(226, 'Cinda Adams'),
(227, 'Kirk Thornton'),
(228, 'Mari Devon'),
(229, 'Lola Raie'),
(230, 'Naomi Serrano'),
(231, 'Dino Andrade'),
(232, 'Damien Frette'),
(233, 'Julien Crampon'),
(234, 'Kaycie Chase'),
(235, 'Rusty Shackleford'),
(236, 'Jo Wyatt'),
(237, 'Leo Barakat'),
(238, 'Harmony O\'Reilly'),
(239, 'Phoenix O\'Reilly'),
(240, 'Elijah Dhavvan'),
(241, 'Büsra Pekin'),
(242, 'Müjde Uzman'),
(243, 'Murat Boz'),
(244, 'Reese Witherspoon'),
(245, 'Candice Bergen'),
(246, 'Michael Sheen'),
(247, 'Mehmet Günsür'),
(248, 'Altan Erkekli'),
(249, 'Belçim Bilgin'),
(250, 'Kubilay Aka'),
(251, 'Afra Saraçoglu'),
(252, 'Salih Kalyon'),
(254, 'Özgü Namal'),
(255, 'Engin Altan Düzyatan'),
(256, 'Emin Gürsoy'),
(257, 'Melis Lebig'),
(258, 'Omer Ayaz'),
(259, 'Tarik Tanrisever'),
(260, 'Elçin Sangu'),
(261, 'Baris Arduç'),
(262, 'Cengiz Bozkurt'),
(263, 'Çagdas Onur Öztürk'),
(264, 'Asli Tandogan'),
(265, 'Begüm Birgören'),
(266, 'Belçim Bilgin'),
(267, 'Ibrahim Celikkol'),
(268, 'Kerem Can');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reply_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `soundtrack`
--

CREATE TABLE `soundtrack` (
  `SoundID` int(11) NOT NULL,
  `FilmID` int(11) NOT NULL,
  `MuzikAdi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yönetmenler`
--

CREATE TABLE `yönetmenler` (
  `YönetmenID` int(11) NOT NULL,
  `YönetmenAdi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `yönetmenler`
--

INSERT INTO `yönetmenler` (`YönetmenID`, `YönetmenAdi`) VALUES
(4, 'Steven Spielberg'),
(5, 'Martin Scorsese'),
(6, 'Quentin Tarantino'),
(7, 'Christopher Nolan'),
(8, 'Alfred Hitchcock'),
(9, 'Francis Ford Coppola'),
(10, 'Stanley Kubrick'),
(11, 'James Cameron'),
(12, 'Ridley Scott'),
(13, 'Peter Jackson'),
(14, 'Tim Burton'),
(15, 'George Lucas'),
(16, 'Clint Eastwood'),
(17, 'David Fincher'),
(18, 'Sergio Leone'),
(19, 'Woody Allen'),
(20, 'Akira Kurosawa'),
(21, 'Joel Coen'),
(22, 'Ethan Coen'),
(23, 'Wes Anderson'),
(24, 'Guillermo del Toro'),
(25, 'Brian De Palma'),
(26, 'Roman Polanski'),
(27, 'Oliver Stone'),
(28, 'Orson Welles'),
(29, 'Billy Wilder'),
(30, 'Hayao Miyazaki'),
(31, 'John Carpenter'),
(32, 'Ingmar Bergman'),
(33, 'Sam Raimi'),
(34, 'Robert Zemeckis'),
(35, 'John Huston'),
(36, 'Ang Lee'),
(37, 'Paul Thomas Anderson'),
(38, 'Darren Aronofsky'),
(39, 'Spike Lee'),
(40, 'Terrence Malick'),
(41, 'Jean-Luc Godard'),
(42, 'David Lynch'),
(43, 'Michael Mann'),
(44, 'Denis Villeneuve'),
(45, 'Michael Bay'),
(46, 'Richard Linklater'),
(47, 'Ron Howard'),
(48, 'Robert Altman'),
(49, 'Alejandro González Iñárritu'),
(50, 'John Ford'),
(51, 'Howard Hawks'),
(52, 'Fritz Lang'),
(53, 'Federico Fellini'),
(55, 'Mikael Håfström'),
(56, 'Paul Haggis'),
(57, 'Gavin J. Konop'),
(58, ' Taika Waititi'),
(59, 'Taika Waititi'),
(60, 'Shawn Levy'),
(61, 'Steven Caple Jr.'),
(62, 'Jake Kasdan'),
(63, ' Alexandre Aja'),
(64, ' Ruben Fleischer'),
(65, ' Ben Wheatley'),
(66, ' Brad Peyton'),
(67, ' Iain Softley'),
(68, ' Simon West'),
(69, ' Chris Columbus'),
(70, 'Francis Lawrence'),
(71, ' Joe Wright'),
(72, 'Sandra Nettelbeck'),
(73, 'Kristopher Belman'),
(74, ' Shi-hyeon Kim'),
(75, 'Adam MacDonald'),
(76, 'Neil Burger'),
(77, 'Ian Clark'),
(78, 'Steven Gomez'),
(79, ' Lorene Scafaria'),
(80, 'Tod Williams'),
(81, 'Sarik Andreasyan'),
(82, ' Maximilian Elfeldt'),
(83, 'Michael Radford'),
(84, 'Joseph L. Mankiewicz'),
(85, 'Oliver Hirschbiegel'),
(86, 'Florian Gallenberger'),
(87, 'Nadav Lapid'),
(88, 'Ben Lewin'),
(89, 'Alain Gsponer'),
(90, 'Kevin Reynolds'),
(91, 'Anne Fontaine'),
(92, 'Emrah Saltik'),
(93, 'Rich Ragsdale'),
(94, 'Lee Cronin'),
(95, 'Jonas Alexander Arnby'),
(96, 'Griff Furst'),
(97, 'John Gulager'),
(98, 'Ahmet Yasar Gümüs'),
(99, 'Alex Davidson'),
(100, 'Robbie Smith'),
(101, 'René Bjerregaard'),
(102, '-'),
(103, 'Onur Bilgetay'),
(104, 'Cem Yilmaz'),
(105, 'Atil Inaç'),
(106, 'Murat Aslan'),
(107, 'Ömer Faruk Sorak'),
(108, 'Ertem Egilmez'),
(109, 'Zeki Ökten'),
(110, 'Chris Wedge'),
(111, 'Holger Tappe'),
(112, 'Reinhard Klooss'),
(113, 'Gary Wang'),
(114, 'Jérémie Degruson'),
(115, 'Richard Claus'),
(116, 'Samuel Tourneux'),
(117, 'Vincent Kesteloot'),
(118, 'Sean Patrick O\'Reilly'),
(119, 'Ali Taner Baltaci'),
(120, 'Hallie Meyers-Shyer'),
(121, 'Ömer Faruk Sorak'),
(122, 'Ömer Ugur'),
(123, 'Ketche'),
(124, 'Mehmet Tanrisever'),
(125, 'Senol Sönmez'),
(126, 'Ruhi Yapici'),
(127, 'Hakan Yonat');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `diller`
--
ALTER TABLE `diller`
  ADD PRIMARY KEY (`DilID`);

--
-- Tablo için indeksler `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `favoriler`
--
ALTER TABLE `favoriler`
  ADD PRIMARY KEY (`FavoriID`),
  ADD KEY `FilmID` (`FilmID`),
  ADD KEY `KullaniciID` (`KullaniciID`);

--
-- Tablo için indeksler `filmdislikes`
--
ALTER TABLE `filmdislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `filmler`
--
ALTER TABLE `filmler`
  ADD PRIMARY KEY (`FilmID`),
  ADD KEY `KategoriID` (`KategoriID`),
  ADD KEY `FK_Oyuncu` (`OyuncuIDs`),
  ADD KEY `FK_Dil` (`DilID`),
  ADD KEY `FK_Yönetmen` (`YönetmenID`);

--
-- Tablo için indeksler `filmlikes`
--
ALTER TABLE `filmlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `filmoyuncular`
--
ALTER TABLE `filmoyuncular`
  ADD PRIMARY KEY (`FilmID`,`OyuncuID`),
  ADD KEY `OyuncuID` (`OyuncuID`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`KategoriID`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`KullaniciID`),
  ADD UNIQUE KEY `email_unique` (`Email`),
  ADD UNIQUE KEY `phone_unique` (`TelefonNo`);

--
-- Tablo için indeksler `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `oyuncular`
--
ALTER TABLE `oyuncular`
  ADD PRIMARY KEY (`OyuncuID`);

--
-- Tablo için indeksler `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `soundtrack`
--
ALTER TABLE `soundtrack`
  ADD PRIMARY KEY (`SoundID`),
  ADD KEY `FilmID` (`FilmID`);

--
-- Tablo için indeksler `yönetmenler`
--
ALTER TABLE `yönetmenler`
  ADD PRIMARY KEY (`YönetmenID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `diller`
--
ALTER TABLE `diller`
  MODIFY `DilID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `favoriler`
--
ALTER TABLE `favoriler`
  MODIFY `FavoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Tablo için AUTO_INCREMENT değeri `filmdislikes`
--
ALTER TABLE `filmdislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Tablo için AUTO_INCREMENT değeri `filmler`
--
ALTER TABLE `filmler`
  MODIFY `FilmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Tablo için AUTO_INCREMENT değeri `filmlikes`
--
ALTER TABLE `filmlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `KategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `KullaniciID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Tablo için AUTO_INCREMENT değeri `oyuncular`
--
ALTER TABLE `oyuncular`
  MODIFY `OyuncuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- Tablo için AUTO_INCREMENT değeri `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `soundtrack`
--
ALTER TABLE `soundtrack`
  MODIFY `SoundID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `yönetmenler`
--
ALTER TABLE `yönetmenler`
  MODIFY `YönetmenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `filmler` (`FilmID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dislikes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `dislikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `favoriler`
--
ALTER TABLE `favoriler`
  ADD CONSTRAINT `favoriler_ibfk_1` FOREIGN KEY (`FilmID`) REFERENCES `filmler` (`FilmID`),
  ADD CONSTRAINT `favoriler_ibfk_2` FOREIGN KEY (`KullaniciID`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `filmdislikes`
--
ALTER TABLE `filmdislikes`
  ADD CONSTRAINT `filmdislikes_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `filmler` (`FilmID`),
  ADD CONSTRAINT `filmdislikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `filmler`
--
ALTER TABLE `filmler`
  ADD CONSTRAINT `FK_Dil` FOREIGN KEY (`DilID`) REFERENCES `diller` (`DilID`),
  ADD CONSTRAINT `FK_Yönetmen` FOREIGN KEY (`YönetmenID`) REFERENCES `yönetmenler` (`YönetmenID`),
  ADD CONSTRAINT `filmler_ibfk_1` FOREIGN KEY (`KategoriID`) REFERENCES `kategoriler` (`KategoriID`);

--
-- Tablo kısıtlamaları `filmlikes`
--
ALTER TABLE `filmlikes`
  ADD CONSTRAINT `filmlikes_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `filmler` (`FilmID`),
  ADD CONSTRAINT `filmlikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `filmoyuncular`
--
ALTER TABLE `filmoyuncular`
  ADD CONSTRAINT `filmoyuncular_ibfk_1` FOREIGN KEY (`FilmID`) REFERENCES `filmler` (`FilmID`) ON DELETE CASCADE,
  ADD CONSTRAINT `filmoyuncular_ibfk_2` FOREIGN KEY (`OyuncuID`) REFERENCES `oyuncular` (`OyuncuID`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`);

--
-- Tablo kısıtlamaları `soundtrack`
--
ALTER TABLE `soundtrack`
  ADD CONSTRAINT `soundtrack_ibfk_1` FOREIGN KEY (`FilmID`) REFERENCES `filmler` (`FilmID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
