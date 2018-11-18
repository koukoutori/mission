<html>
	<head>
		<meta charset="UTF-8">
		<style>
			h1{color:red;font-size:50px;text-align: center;padding: 1em 0;}
/* Fonts */
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400);

/* fontawesome */
@import url(http://weloveiconfonts.com/api/?family=fontawesome);
[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
}

/* Simple Reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

/* body */
body {
  background: #e9e9e9;
  color: #5e5e5e;
  font: 400 87.5%/1.5em 'Open Sans', sans-serif;
}

/* Form Layout */
.form-wrapper {
  background: #fafafa;
  margin: 3em auto;
  padding: 0 1em;
  max-width: 370px;
}

form {
  padding: 0 1.5em;
}

.form-item {
  margin-bottom: 0.75em;
  width: 100%;
}

.form-item input {
  background: #fafafa;
  border: none;
  border-bottom: 2px solid #e9e9e9;
  color: #666;
  font-family: 'Open Sans', sans-serif;
  font-size: 1em;
  height: 50px;
  transition: border-color 0.3s;
  width: 100%;
}

.form-item input:focus {
  border-bottom: 2px solid #c0c0c0;
  outline: none;
}

.button-panel {
  margin: 2em 0 0;
  width: 100%;
}

.button-panel .button {
  background: #f16272;
  border: none;
  color: #fff;
  cursor: pointer;
  height: 50px;
  font-family: 'Open Sans', sans-serif;
  font-size: 1.2em;
  letter-spacing: 0.05em;
  text-align: center;
  text-transform: uppercase;
  transition: background 0.3s ease-in-out;
  width: 100%;
}

.button:hover {
  background: #ee3e52;
}

.form-footer {
  font-size: 1em;
  padding: 2em 0;
  text-align: center;
}

.form-footer a {
  color: #8c8c8c;
  text-decoration: none;
  transition: border-color 0.3s;
}

.form-footer a:hover {
  border-bottom: 1px dotted #8c8c8c;
}
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
		
			//同名のテーブルがなければ作成
			$sql = "CREATE TABLE IF NOT EXISTS mission6_login"
			."("
			."name char(32),"
			."password char(32)"
			.");";
			$stmt = $pdo->query($sql);
			
			
			//新規登録
			if($_POST['newlogin']){
				if(!empty($_POST['newname']) && !empty($_POST['newpass'])){
					$newid = $_POST['newname'];
					$newpass = $_POST['newpass'];
					
					$sql = $pdo->prepare("INSERT INTO mission6_login (name,password) VALUES (:name,:password)");
					$sql->bindParam(':name',$newid,PDO::PARAM_STR);
					$sql->bindParam(':password',$newpass,PDO::PARAM_STR);
					$sql->execute();
					
					header("Location: http://tt-247.99sv-coco.com/mission_6-1.php");
					
				}else{
					header("Location: http://tt-247.99sv-coco.com/mission_6-1_newlogin.php");
					exit();
				}
			}
		?>
		
		<center>
			<h1>〇〇教室なんでも掲示板</h1>
			<h2><br>※この掲示板は関係者以外利用できません！※
				<br><br>～初めての方へ～
				<br>まずはここでユーザー登録しましょう</h2>
		</center>
			<div class = "form-wrapper">
				<form method = "post" action="mission_6-1_newlogin.php">
					<div class = "form-item">
						<label for = "ユーザー名"></label>
						<input type = "text" name = "newname" placeholder = "ユーザー名" ></input>
					</div>
					<div class = "form-item">
						<label for = "パスワード"></label>
						<input type = "text"  name = "newpass" placeholder = "パスワード" ></input>
					</div>
					<div class = "button-panel">
						<input type = "submit" class = "button" value = "新規登録" name = "newlogin" ></input>
					</div>
				</form>
				<div class = "form-footer">
					<p><a href="http://tt-247.99sv-coco.com/mission_6-1.php">ログインはこちら</a></p>
				</div>
			</div>
	</body>
</html>