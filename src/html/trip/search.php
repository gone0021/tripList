<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>検索結果</title>
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
    <header>
			<div class="title">
				<h1>検索結果</h1>
			</div>
			<div class="login_info">
				<ul>
					<li>ようこそ○○さん</li>
					<li>
						<form>
							<input type="button" value="ログアウト" onclick="location.href='../account/';">
						</form>
					</li>
				</ul>
			</div>
    </header>

    <main>
		<div class="main-header">
			<form action="./search.html" method="post">
				<div class="entry">
					<input type="button" name="entry-button" id="entry-button" class="entry-button" value="作業登録" onclick="location.href='./entry.html'">
				</div>
				<div class="search">
					<input type="text" name="search-button" id="search-button" class="search-button">
						<input type="submit" value="🔍検索">
				</div>
			</form>
		</div>

			<table class="list">
				<tr>
					<th>項目名</th>
					<th>担当者</th>
					<th>登録日</th>
					<th>期限日</th>
					<th>完了日</th>
					<th>操作</th>
				</tr>
				<tr class="warning">
					<td class="align-left">
						test1を実施する
					</td>
					<td class="align-left">
						テスト1
					</td>
					<td>
						2019-01-30
					</td>
					<td>
						2019-01-30
					</td>
					<td>
						未
					</td>
					<td>
						<form action="#" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="完了">
						</form>
						<form action="edit.html" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="更新">
						</form>
						<form action="delete.html" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="削除">
						</form>
					</td>
				</tr>

				<tr class="even">
					<td class="align-left">
						test2の結果を報告する
					</td>
					<td class="align-left">
						テスト2
					</td>
					<td>
						2019-01-30
					</td>
					<td>
						2019-05-10
					</td>
					<td>
						2019-05-10
					</td>
					<td>
						<form action="#" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="完了">
						</form>
						<form action="edit.html" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="更新">
						</form>
						<form action="delete.html" method="post">
							<input type="hidden" name="item_id" value="1">
							<input type="submit" value="削除">
						</form>
					</td>
				</tr>

					<tr class="odd">
						<td class="align-left">
							test3はどうなっているのか尋ねる
						</td>
						<td class="align-left">
							テスト3
						</td>
						<td>
							2019-01-30
						</td>
						<td>
							2019-05-10
						</td>
						<td>
							2019-05-10
						</td>
						<td>
							<form action="#" method="post">
								<input type="hidden" name="item_id" value="1">
								<input type="submit" value="完了">
							</form>
							<form action="edit.html" method="post">
								<input type="hidden" name="item_id" value="1">
								<input type="submit" value="更新">
							</form>
							<form action="delete.html" method="post">
								<input type="hidden" name="item_id" value="1">
								<input type="submit" value="削除">
							</form>
						</td>
					</tr>
			</table>

			<div class="main-footer">
				<form>
					<div class="goback">
						<input type="button" value="戻る" onclick="location.href='./index.html';">
					</div>
				</form>
			</div>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>