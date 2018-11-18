<html>
	<head>
		<meta charset="UTF-8">
		<style>
			h1{color:red;font-size:60px;}
		</style>
	</head>
	<body style = "background: url(b008.jpg);" >
		<?php
			$dsn = 'データベース名';
			$user = 'ユーザー名';
			$password = 'パスワード';
			//接続状況チェック
			try{
				$pdo = new PDO($dsn,$user,$password);
			}catch(Exception $e){
				echo 'エラーがありました。';
				echo $e->getMessage;
				exit();
			}

			//テーブル作成
			$sql = "CREATE TABLE mission6onboards"
			."("
			."id INT,"
			."class char(32),"
			."subject char(32),"
			."fname TEXT,"
			."extension TEXT,"
			."picture MEDIUMBLOB,"
			."comment TEXT,"
			."date char(32)"
			.");";
			$stmt = $pdo->query($sql);
			
			$classes = $_POST['class'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];
			$day = date("Y/m/d H:i:s");
			
			
			//削除する
			$delete_num = $_POST['delete_num'];
			$sql = "SELECT * FROM mission6onboards";
			$stmt = $pdo->query($sql);
			foreach($stmt as $row1){
				if($delete_num == $row1['id']){
						$sql = "DELETE FROM mission6onboards WHERE id=:id";
						$stmt = $pdo->prepare($sql);
						$params = array(':id'=>$delete_num);
						$stmt->execute($params);
				}
			}
			
			//(編集)フォームに表示
			$edit_num = $_POST['edit_num'];;
			$sql = "SELECT * FROM mission6onboards";
			$stmt = $pdo->query($sql);
			foreach($stmt as $row2){
				if($edit_num == $row2['id']){
						$new_comment = $row2['comment'];
				}
			}
			
			//(編集)フォームから再送信
			$edit = $_POST['edit'];
			$sql = "UPDATE mission6onboards SET comment=:comment WHERE id=:id";
			$stmt = $pdo->prepare($sql);
			$param = array(':comment'=>$message,':id'=>$edit);
			$stmt->execute($param);
			
			
			
			//送信してテーブルに記入。
			if(!empty($subject) and empty($edit_num)){
				//画像アップロード
				$upfile = $_FILES["image"]["tmp_name"];
				$upfiledata = file_get_contents($upfile);
				$upfiledata = mysql_real_escape_string($upfiledata);
				
				$sql = 'SELECT COUNT(id) FROM mission6onboards';
				$stmt = $pdo->query($sql);
				$result = $stmt->fetchColumn();
				$id = ( $result == NULL ) ? 1 : $result+1;
				
				
				$sql = $pdo->prepare("INSERT INTO mission6onboards (id,class,subject,picture,comment,date) VALUES (:id,:class,:subject,:picture,:comment,:date)");
				$sql->bindParam(':id',$id,PDO::PARAM_STR);
				$sql->bindParam(':class',$classes,PDO::PARAM_STR);
				$sql->bindParam(':subject',$subject,PDO::PARAM_STR);
				$sql->bindVALUE(':picture',$upfiledata,PDO::PARAM_LOB);
				$sql->bindParam(':comment',$message,PDO::PARAM_STR);
				$sql->bindParam(':date',$day,PDO::PARAM_STR);
				$sql->execute();
				
			}
				
			//初期化する
			$reset = $_POST['reset'];
			if($reset){
				$sql = 'DELETE FROM mission6onboards';
				$stmt = $pdo->query($sql);
			}
		?>
		<center>
			<h1>〇〇教室なんでも掲示板</h1>
		</center>
		<div>
			<div style = "float: right">
			<a href="http://tt-247.99sv-coco.com/mission_6-1.php">ログアウトはこちら</a>
		</div>
		<form method = "post" action="mission_6-1_board.php" enctype = "multipart/form-data" >
			授業：<select name = "class" >
					<option value = "個別" >個別</option>
					<option value = "集団" >集団</option>
					<option value = "その他" >その他</option>
				  </select>
				<br>
			科目：<select name = "subject" >
					<option value = "英語" >英語</option>
					<option value = "数学" >数学</option>
					<option value = "現代文" >現代文</option>
					<option value = "古文" >古文</option>
					<option value = "日本史" >日本史</option>
					<option value = "世界史" >世界史</option>
					<option value = "物理" >物理</option>
					<option value = "化学" >化学</option>
					<option value = "その他">その他</option>
				  </select>
				<br>
			<textarea name = "message" cols = "75" rows = "6" placeholder = "ここに内容を記入してください。" style = "border:1px black solid;" ></textarea>
				<br>
				<input type = "file" name = "image" >
			<input type = "submit" value = "送信" >
				<br><br>
			<input type = "text" name = "delete_num" placeholder = "削除対象番号" style = "border:1px black solid;" >
			<input type = "submit" value = "削除" >
				<br><br>
			<input type = "text" name = "edit_num" placeholder = "編集対象番号" style = "border:1px black solid;" >
			<input type = "submit" value = "編集" >
			<input type = "submit" name = "reset" value = "初期化">←注意！
		</form>
		
	</body>
	<?php
		//ブラウザに出力
			$sql = "SELECT * FROM mission6onboards";
			$stmt = $pdo->query($sql);
			foreach($stmt as $row){
				echo $row['id']."：".$row['class']." ".$row['subject']." ".$row['date']."<br>".$row['comment']."<br>";
				
				//画像投稿があれば表示
				$sql = "SELECT * FROM mission6onboards ORDER BY id;";
				$stmt = $pdo->query($sql);
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					print("<img src=\"mission_6-1_image.php?id=" . $row['id'] . "\">");
				}
				echo"<br>";
			}
		?>
</html>