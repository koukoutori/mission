<html>
	<head>
		<meta charset="UTF-8">
		<style>
			h1{color:red;font-size:50px;}
@import url(https://fonts.googleapis.com/css?family=Open+Sans:);
.login {
  width: 400px;
  margin: 16px auto;
  font-size: 16px;
}

/* Reset top and bottom margins from certain elements */
.login-header,
.login p {
  margin-top: 0;
  margin-bottom: 0;
}

/* The triangle form is achieved by a CSS hack */
.login-triangle {
  width: 0;
  margin-right: auto;
  margin-left: auto;
  border: 12px solid transparent;
  border-bottom-color: #28d;
}

.login-header {
  background: #28d;
  padding: 20px;
  font-size: 1.4em;
  font-weight: normal;
  text-align: center;
  text-transform: uppercase;
  color: #fff;
}

.login-container {
  background: #ebebeb;
  padding: 12px;
}

/* Every row inside .login-container is defined with p tags */
.login p {
  padding: 12px;
}

.login input {
  box-sizing: border-box;
  display: block;
  width: 100%;
  border-width: 1px;
  border-style: solid;
  padding: 16px;
  outline: 0;
  font-family: inherit;
  font-size: 0.95em;
}

.login input[type="text"],
.login input[type="password"] {
  background: #fff;
  border-color: #bbb;
  color: #555;
}

/* Text fields' focus effect */
.login input[type="text"]:focus,
.login input[type="password"]:focus {
  border-color: #888;
}

.login input[type="submit"] {
  background: #28d;
  border-color: transparent;
  color: #fff;
  cursor: pointer;
}

.login input[type="submit"]:hover {
  background: #17c;
}

/* Buttons' focus effect */
.login input[type="submit"]:focus {
  border-color: #05a;
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
			
			//ログイン認証
			if($_POST['login']){
				if(!empty($_POST['name']) && !empty($_POST['pass'])){
					$userid = $_POST['name'];
					$userpass = $_POST['pass'];
					
					$sql = "SELECT*FROM mission6_login";
					$stmt = $pdo->query($sql);
					foreach($stmt as $row1){
						if($userid == $row1['name'] && $userpass == $row1['password']){
								header("Location: http://tt-247.99sv-coco.com/mission_6-1_board.php");
								exit();
						}else{
							echo "IDまたはパスワードが違います。";
							header("Location: http://tt-247.99sv-coco.com/mission_6-1.php");
						}
					}
				}else if(empty($_POST['name']) or empty($_POST['pass'])){
					echo "<center>ユーザーIDまたはパスワードが未入力です。</center>";
					header("Location: http://tt-247.99sv-coco.com/mission_6-1.php");
					exit();
				}
			}
		?>
		
		<center>
			<h1>〇〇教室なんでも掲示板</h1>
			<h3>※この掲示板は関係者以外利用できません！※
				<br>～先生方へ～
				<br>この掲示板には気づいたことがあったら何でも書いていきましょう！</h3>
			</center>
			<div class = "login">
				<div class = "login-triangle"></div>
				<h2 class = "login-header">ログイン画面</h2>
			
				<form class = "login-container" method = "post" action="mission_6-1.php">
					<p><input type = "text" name = "name" placeholder = "ユーザー名" ></p>
					<p><input type = "password" name = "pass" placeholder = "パスワード" ></p>
					<p><input type = "submit" value = "ログイン" name = "login" ></p>
				</form>
				<center><a href="http://tt-247.99sv-coco.com/mission_6-1_newlogin.php">新規登録はこちら</a></center>
			</div>
	</body>
</html>