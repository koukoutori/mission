		<?php
			$dsn = 'データベース名';
			$user = 'ユーザー名';
			$password = 'パスワード';
			//接続状況チェック
			try{
				$pdo = new PDO($dsn,$user,$password);
				//画像取得
				$sql = $pdo->query("SELECT * FROM mission6onboards WHERE id = '".$_GET['id']."'");
				$row = mysql_fetch_row($sql);
			
				header("Content-type: image/jpeg");
				echo $row['picture'];
			}catch(Exception $e){
				echo 'エラーがありました。';
				echo $e->getMessage;
				exit();
			}
		?>