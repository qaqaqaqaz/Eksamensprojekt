<!--
       Denne fil skaber databasen,
-->

<?php
        //Får at connecte til databasen så forventer den et brugernavn og et password
		if(!isset($_POST['mysql_username']) or !isset($_POST['mysql_pw'])){
		echo'INGEN ADGANG';
		exit;
		}
		if($conn = mysql_connect('localhost',$_POST['mysql_username'],$_POST['mysql_pw'])) {
			echo 'Logget ind!<br />';
			echo 'Tjekker databasen bytOnline<br />';
            if(!mysql_select_db("bytOnline")) {
				echo 'Skaber database<br />';
                mysql_query("CREATE DATABASE  `bytOnline` ;") or die(mysql_error());
				echo 'Database bytOnline oprettet <br />';
                }
			else{
				echo 'Database bytOnline eksisterere allerede<br />';
			}
			/*sikkerhedsbruger
			Dette den her kode gør er at den skaber privilegier til bytOnline databasen, men ikke nogen andre databaser
			på den måde undgås det at det folk udefra kan pille ved andre databaser hvis man skulle glemme at beskytte sig mod intruders*/
			$tjekBruger = "SELECT user FROM mysql.user WHERE user='eksamensprojekt'";
			if(mysql_num_rows(mysql_query($tjekBruger)) < 1) {//tjekker om brugeren er oprettet før
			$query = "CREATE USER 'eksamensprojekt'@'localhost' IDENTIFIED BY  'kummefryser';";
			$grant = "GRANT ALL PRIVILEGES ON  `bytOnline` . * TO  'eksamensprojekt'@'localhost' WITH GRANT OPTION ;";
			mysql_query($query) or die(mysql_error());
			mysql_query($grant) or die(mysql_error());
		
			echo "Skabt bruger eksamensprojekt <br />";
		}
			
			//brugere tabel
			$tjekBrugere = "SELECT * FROM brugere;";
			$resultat = mysql_query($tjekBrugere);
			echo 'Tjekker brugere tabellen <br />';
			if(!$resultat) {
				echo 'Laver brugertabellen<br />'; //user, firstname, lastname and email is 4 time as big as allowed, so '<' and '>' can be replaced with '&lt;' and '&gt;'
				$lavBrugere = "	CREATE TABLE  `bytOnline`.`brugere` (
					`brugerID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
					`brugernavn` VARCHAR( 60 ) NOT NULL ,
					`password` VARCHAR( 50 ) NOT NULL ,
					`fornavn` VARCHAR( 120 ) NOT NULL ,
					`efternavn` VARCHAR( 120 ) NOT NULL ,
					`email` VARCHAR( 120 ) NOT NULL ,
					`isAdmin` TINYINT( 1 ) NOT NULL DEFAULT '0' ,
					PRIMARY KEY (  `brugerID` ) ,
					UNIQUE (
						`brugernavn` ,
						`email`
					)
					) ENGINE = INNODB;";
					//http://dev.mysql.com/doc/refman/5.0/en/innodb-storage-engine.html link til forklaring på INNODB
				mysql_query($lavBrugere) or die(mysql_error());
				echo 'Brugere tabel oprettet <br />';
		
				/*laver standard admin, til bestemte adminfunktioner
				$lavStandardAdmin = "INSERT INTO brugere (brugernavn,password,fornavn,efternavn,email,isAdmin) VALUES ('admin','".md5("admin")."','Admin','Admin','admin',1);";
				mysql_query($lavStandardAdmin) or die(mysql_error());
				*/
			}
			else{
				echo 'Brugere tabellen er allerede oprettet <br />';
			}
			
			//spil tabel
			$tjekSpil = "SELECT * FROM spil;";
			$resultat = mysql_query($tjekSpil);
			echo 'Tjekker spil tabel <br />';
			if(!$resultat) {
				echo 'Laver spiltabellen<br />';
				$lavSpil = "	CREATE TABLE  `bytOnline`.`spil` (
					`spilID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`brugerID` INT( 10 ) NOT NULL,
					`spilnavn` VARCHAR( 60 ) NOT NULL ,
					`spilbeskrivelse` TEXT NOT NULL ,
					`spilkategori` VARCHAR( 60 ) NOT NULL ,
					`priskategori` VARCHAR( 60 ) NOT NULL
					) ENGINE = INNODB;";
				mysql_query($lavSpil) or die(mysql_error());
				echo 'Spil tabel oprettet <br />';
			}
			else {
				echo 'Spil tabel allerede oprettet <br />';
			}
			
			
			// bud tabel
			$tjekBud = "SELECT * FROM bud;";
			$resultat = mysql_query($tjekSpil);
			echo 'Tjekker bud tabel<br />';
			if(!$resultat) {
				echo 'Laver budtabellen<br />';
				$lavBud = "	CREATE TABLE  `bytOnline`.`bud` (
					`budID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`besked` TEXT NOT NULL
					) ENGINE = INNODB;";
				mysql_query($lavBud) or die(mysql_error());
				echo 'Bud tabel oprettet <br />';
			}
			else {
				echo 'Bud tabel allerede oprettet <br />';
			}
			
			//Relationer
			echo 'laver relationer <br />';
			$brugereRelation = "ALTER TABLE  `spil` ADD INDEX (  `brugerID` )";
			$lavRelationForBruger = "ALTER TABLE  `spil` ADD FOREIGN KEY (  `spilID` ) REFERENCES  `bytOnline`.`brugere` (
						`brugerID`
						) ON DELETE CASCADE ON UPDATE CASCADE ;";
			mysql_query($brugereRelation) or die(mysql_error());
			mysql_query($lavRelationForBruger) or die(mysql_error());
			
			echo 'relation mellem bruger og spil oprettet <br />';
			
			$budRelation = "ALTER TABLE  `bud` ADD INDEX (  `koberspilID` )";
			$lavRelationForBruger = "ALTER TABLE  `spil` ADD FOREIGN KEY (  `spilID` ) REFERENCES  `bytOnline`.`brugere` (
						`brugerID`
						) ON DELETE CASCADE ON UPDATE CASCADE ;";
			//mysql_query($budRelation) or die(mysql_error());
			//echo 'hello';
			//mysql_query($lavRelationForBruger) or die(mysql_error());
		}
		//ALTER TABLE  `spil` ADD  `brugerID` INT( 10 ) NOT NULL
		/*ALTER TABLE  `spil` ADD FOREIGN KEY (  `spilID` ) REFERENCES  `bytonline`.`brugere` (
`brugerID`
) ON DELETE CASCADE ON UPDATE CASCADE ;
/*
		$checkCats = "SELECT * FROM categories;";
		$result = mysql_query($checkCats);
		echo 'Checking table categories<br />';
		if(!$result) {
			echo 'Creating table categories.<br />';
			$makeCats = "	CREATE TABLE  `miForum`.`categories` (
					`categoryID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`categoryName` VARCHAR( 30 ) NOT NULL ,
					`description` TEXT NULL ,
					UNIQUE (
						`categoryName`
					)
					) ENGINE = INNODB;";
			mysql_query($makeCats) or die(mysql_error());
			echo 'Created table categories<br />';
                
        	} else {
			// Code for checking columns of table.
		}
		$checkFora = "SELECT * FROM fora;";
		$result = mysql_query($checkFora);
		echo 'Checking table fora<br />';
		if(!$result) {
			echo 'Creating table fora.<br />';
			$makeFora = "	CREATE TABLE  `miForum`.`fora` (
					`foraID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 30 ) NOT NULL ,
					`categoryID` INT( 10 ) NOT NULL ,
					`description` TEXT NULL
					) ENGINE = INNODB;";
			mysql_query($makeFora) or die(mysql_error());
			echo 'Created table fora<br />';
                
        	} else {
			// Code for checking columns of table.
		}
		$checkThreads = "SELECT * FROM threads;";
		$result = mysql_query($checkThreads);
		echo 'Checking table threads<br />';
		if(!$result) {
			echo 'Creating table threads.<br />';
			$makeThreads = "CREATE TABLE  `miForum`.`threads` (
					`threadID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 30 ) NOT NULL ,
					`foraID` INT( 10 ) NOT NULL ,
					`userID` INT( 10 ) NOT NULL ,
					`description` TEXT NOT NULL
					) ENGINE = INNODB;";
			mysql_query($makeThreads) or die(mysql_error());
			echo 'Created table threads<br />';
                
        	} else {
			// Code for checking columns of table.
		}
		$checkPosts = "SELECT * FROM post;";
		$result = mysql_query($checkPosts);
		echo 'Checking table post<br />';
		if(!$result) {
			echo 'Creating table post.<br />';
			$makePosts = "	CREATE TABLE  `miForum`.`post` (
					`postID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`threadID` INT( 10 ) NOT NULL ,
					`userID` INT( 10 ) NOT NULL ,
					`text` LONGTEXT NOT NULL
					) ENGINE = INNODB;";
			mysql_query($makePosts) or die(mysql_error());
			echo 'Created table post<br />';
                
        	} else {
			// Code for checking columns of table.
		}
		$checkArticles = "SELECT * FROM articles;";
		$result = mysql_query($checkArticles);
		echo 'Checking table articles<br />';
		if(!$result) {
			echo 'Creating table articles.<br />';
			$makeArticles = "	CREATE TABLE  `miForum`.`articles` (
					`articleID` INT( 10 ) NOT NULL AUTO_INCREMENT ,
					`title` VARCHAR( 30 ) NOT NULL ,
					`text` LONGTEXT NOT NULL ,
					`writerID` INT( 10 ) NOT NULL ,
					INDEX (  `articleID` )
					) ENGINE = INNODB;";
			mysql_query($makeArticles) or die(mysql_error());
			echo 'Created table articles<br />';
                
        	} else {
			// Code for checking columns of table.
		}
		
		/* Create mi-site user. Dette den her kode gør er at den skaber privilegier til bytOnline databasen, men ikke nogen andre databaser
		på den måde undgås det at det folk udefra kan pille ved andre databaser/(HUSKE SLUT) 
		$checkUser = "SELECT user FROM mysql.user WHERE user='misite'";
		if(mysql_num_rows(mysql_query($checkUser)) < 1) {
			$query = "CREATE USER 'misite'@'localhost' IDENTIFIED BY  'kummefryser';";
			$grant = "GRANT ALL PRIVILEGES ON  `miForum` . * TO  'misite'@'localhost' WITH GRANT OPTION ;"; // F**king long query.
			mysql_query($query) or die(mysql_error());
			mysql_query($grant) or die(mysql_error());
			
			echo "Created user misite";
		}

		// Relations
		$alterFora = "ALTER TABLE  `fora` ADD INDEX (  `categoryID` )";
		$makeRelationForaCat = "ALTER TABLE  `fora` ADD FOREIGN KEY (  `categoryID` ) REFERENCES  `miForum`.`categories` (
						`categoryID`
						) ON DELETE CASCADE ON UPDATE CASCADE ;";
		mysql_query($alterFora) or die(mysql_error());
		mysql_query($makeRelationForaCat) or die(mysql_error());

		$alterThreads = "ALTER TABLE  `threads` ADD INDEX (  `foraID` )";
		$makeRelationThreadsFora = "ALTER TABLE  `threads` ADD FOREIGN KEY (  `foraID` ) REFERENCES  `miForum`.`fora` (
						`foraID`
						) ON DELETE CASCADE ON UPDATE CASCADE ;";
		mysql_query($alterThreads) or die(mysql_error());
		mysql_query($makeRelationThreadsFora) or die(mysql_error());

		$alterPost = "ALTER TABLE  `post` ADD INDEX (  `threadID` )";
		$makeRelationPostThreads = "ALTER TABLE  `post` ADD FOREIGN KEY (  `threadID` ) REFERENCES  `miForum`.`threads` (
						`threadID`
						) ON DELETE CASCADE ON UPDATE CASCADE ;";
		mysql_query($alterThreads) or die(mysql_error());
		mysql_query($makeRelationPostThreads) or die(mysql_error());
	}
	//mysql_select_db("bytOnline") or die("noget gik galt, kan ikke få forbindelse til databsen"); // databasen vælges
	*/
?>

<a href="index.php">Tilbage til forside</a> <!-- tilbage til forside-->
