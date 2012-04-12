<!--
       Denne fil skaber databasen
-->

<?php
	//Får at connecte til databasen så forventer den et brugernavn og et password
	if(!isset($_POST['mysql_username']) or !isset($_POST['mysql_pw'])){ //sørger for at uønskede ikke kan rode ved oprettelse af databasen
		echo'<span style="color:red">INGEN ADGANG</span>';
		exit;
	}
	if($conn = mysql_connect('localhost',$_POST['mysql_username'],$_POST['mysql_pw'])) {
		echo 'Logget ind!<br />';
		echo 'Tjekker databasen bytOnline<br />';
		if(!mysql_select_db("bytOnline")) {
			echo 'Skaber database<br />';
			mysql_query("CREATE DATABASE  `bytOnline` ;") or die(mysql_error());
			//mysql_select_db('bytOnline') or die;
			mysql_select_db("bytOnline") or die("Der kan ikke oprettes forbindelsen til databasen"); // databasen vælges
			echo 'Database bytOnline oprettet<br />';
		} else{
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
			echo "eksamensprojekt bruger oprettet <br />";
		}
		
		//brugere tabel
		$tjekBrugere = "SELECT * FROM brugere;";
		$resultat = mysql_query($tjekBrugere);
		echo 'Tjekker brugere tabellen <br />';
		if(!$resultat) {
			echo 'Laver brugertabellen<br />'; //bruger, fornavn, efternavn og email er 4 gange så stor så '<' and '>' kan erstattes med '&lt;' og '&gt;'
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
		} else{
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
				`spilnavn` VARCHAR( 120 ) NOT NULL ,
				`spilbeskrivelse` TEXT NOT NULL ,
				`spilkategori` VARCHAR( 30 ) NOT NULL ,
				`priskategori` VARCHAR( 30 ) NOT NULL
				) ENGINE = INNODB;";
			mysql_query($lavSpil) or die(mysql_error());
			echo 'Spil tabel oprettet <br />';
		} else {
			echo 'Spil tabel allerede oprettet <br />';
		}
		
		// bud tabel
		$tjekBud = "SELECT * FROM bud;";
		$resultat = mysql_query($tjekBud);
		echo 'Tjekker bud tabel<br />';
		if(!$resultat) {
			echo 'Laver budtabellen<br />';
			$lavBud = "	CREATE TABLE  `bytOnline`.`bud` (
				`budID` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`besked` TEXT NOT NULL ,
				`selgerID` INT(10) NOT NULL ,
				`koberID` INT(10) NOT NULL
				) ENGINE = INNODB;";
			mysql_query($lavBud) or die(mysql_error());
			echo 'Bud tabel oprettet <br />';
		} else {
			echo 'Bud tabel allerede oprettet <br />';
		}
		//Relationer
		echo 'laver relationer <br />';
		
		//Spil
		$brugereRelation = "ALTER TABLE  `spil` ADD INDEX (  `brugerID` )";
		$lavRelationForBruger = "ALTER TABLE  `spil` ADD FOREIGN KEY (  `brugerID` ) REFERENCES  `bytOnline`.`brugere` (
					`brugerID`
					) ON DELETE CASCADE ON UPDATE CASCADE ;";
		mysql_query($brugereRelation) or die(mysql_error());
		mysql_query($lavRelationForBruger) or die(mysql_error());
		
		//Bud
		$budSelgerRelation = "ALTER TABLE  `bud` ADD INDEX (  `selgerID` )";
		$budKoberRelation = "ALTER TABLE  `bud` ADD INDEX (  `koberID` )";
		mysql_query($budSelgerRelation) or die(mysql_error());
		mysql_query($budKoberRelation) or die(mysql_error());
		
		$lavRelationForSelgerBud = "ALTER TABLE  `bud` ADD FOREIGN KEY (  `selgerID` ) REFERENCES  `bytOnline`.`spil` (
					`spilID`
					) ON DELETE CASCADE ON UPDATE CASCADE ;";
		mysql_query($lavRelationForSelgerBud) or die(mysql_error());
		
		$lavRelationForKoberBud = "ALTER TABLE  `bud` ADD FOREIGN KEY (  `koberID` ) REFERENCES  `bytonline`.`spil` (
					`spilID`
					) ON DELETE CASCADE ON UPDATE CASCADE;";
		mysql_query($lavRelationForKoberBud) or die(mysql_error());
		
		echo 'relationer er oprettet<br />';
	}
?>
<br /><a href="index.php">Return to Index page</a> <!-- tilbage til forside link-->
