<!-- カレンダーの情報 -->
<?php // 変数の設定
	$weeks = array("日", "月", "火", "水", "木", "金", "土");
	$countWeeks = count($weeks);
	$br = "<br>";
	$day = 1;
	$year = 0;
	$month = 0;
?>

<?php // リンクの値を取得
	if (isset($_GET['y'])) {
		$year = (int)$_GET['y'];
	}
	if (isset($_GET['m'])) {
		$month = (int)$_GET['m'];
	}
?>

<?php	// yとmの値を確認してDateTimeのインスタンスを生成
	if ($year == 0 || $month == 0) {
		$date = new DateTime("Asia/Tokyo"); // 現在の年月
	}	else { 
		$date = new Datetime("{$year}-{$month}-1"); // 表示する月
	}
?>

<?php // 日付情報の取得
	//年月を取得
	$ym = $date->format('Y年m月');
	$year = $date->format('Y');
	$month = $date->format('m');
?>

<?php // 現在月の情報の取得
	// 1日の曜日を取得するために日付を"1"で取得
	$date->setDate($year, $month, 1);
	// 曜日の取得
	$firstDay = (int)$date->format('w');
	// 日数の取得
	$lastDay = (int)$date->format('t');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>カレンダー</title>
	<link rel="stylesheet" href="./css/normalize.css" type="text/css">
	<link rel="stylesheet" href="./css/main.css" type="text/css">
</head>
<body>
<div class="container">
	<!-- 前月と翌月のリンク -->	
	<select name="selcter" id="select-main">
		<option value="calendar">カレンダー</option>
		<option value="list">予定リスト</option>
		<option value="todo">ToDo</option>
		<option value="trip">観光</option>
		<option value="divelog">ダイブログ</option>
	</select>

	<ul class="navi">
		<?php $date->modify('-1 month'); ?>
    <li id="navi-left"><button>
			<a href="./?y=<?= $date->format('Y') ?>&m=<?= $date->format('m') ?>"> << </a>
			</button></li>

		<?php $date->modify('+2 month'); ?>
    <li id="navi-center"><button>
			<a href="./?y=<?= $date->format('Y')?>&m=<?= $date->format('m') ?>"> >> </a>
			</button></li>

		<li id="navi-right"><button><a href="./">今日</a></button></li>
	</ul>

	<h2> <?php echo $br.$ym;
			if ($year == date("Y") && $month == date("m") ) {
				echo " (".date("j")."日".")";
			} ?>
 </h2>


 <!-- ●テーブルの作成 -->
	<table class="container">
	 <!-- 曜日の文字 -->
		<tr>
			<?php	for($i=0; $i<$countWeeks; $i++) { ?>
				<?php if ($i==0) { ?>
				<th class="th-sun"> <?php echo $weeks[$i]; ?> </th>
				<?php } else if ($i==6) { ?>
				<th class="th-sat"> <?php echo $weeks[$i]; ?> </th>
				<?php } else { ?>
					<th class="th-week"> <?php echo $weeks[$i]; ?> </th>
				<?php }	?>
			<?php } ?>
		</tr>

		<!-- 1日目が日曜までの数日分を空白で埋める -->
		<?php for ($j=0; $j<$firstDay; $j++) { ?>
			<td > </td>
		<?php } ?>

		<!-- テーブルのセル数設定 -->
		<?php 
			$sum = $firstDay+$lastDay;
			$period = ceil($sum/7)*7;
		?>

		<!-- カレンダーの表示設定 -->
		<?php for ($k=$firstDay; $k<$period; $k++) {
			// 日曜日に改行
			if ($k % 7 == 0) { ?>
				<tr> </tr>
			<?php } ?>

			<!-- 日付を出力 -->
			<?php if ($day <= $lastDay) { ?>
				<td> <?php echo "&nbsp".$day; ?> </td>
			<!-- 最終日を過ぎれば空白で埋める -->	
			<?php } else { ?>
				<td > </td>
			<!-- 日付の日数を追加 -->	
			<?php } $day++; ?>
		<?php } ?>
	</table>
	<br>

</div>

</body>
</html>
