<?php
include_once('config.php');
include_once('BibleDAO.php');

$books = BibleDAO::getBooks();
$defaultChapters = BibleDAO::getChapterNumbers(1);
$defaultVerses = BibleDAO::getVerseNumbers(1, 1);
$defaultVerseText = BibleDAO::getVerseText(1, 1, 1);
?>

<html>
<head>
	<title>King James Version Bible</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/boot-business.css">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<body background='background.jpg' bgproperties='fixed'>

	<div class='navbar-fixed-top'>
		<div class='navbar-inner'>
			<div class='nav'>
				<label>King James Version Bible</label>
				<div class = 'pull-right'>
					<label>Search Word</label>
					<input type = 'text' id = 'key' class = 'search-query' style = 'width:250px;height:30px'>
				</div>
			</div>
		</div>
	</div>

<div class='container'>
	<div class='row'>
		<div class='span3 columns'>
			
		</div>
		<center>
		<div style='margin-top:150px'>
			<div class = "box_book">
				<font size='5px'><strong>Books:</strong></font>
					<select name="books" id="books" style='width:150px'>
						<?php foreach($books as $id => $book): ?>
						<option value="<?= $id ?>"><?= $book ?></option>
						<?php endforeach ?>
					</select>



				<font size='5px'><strong>Chapter:</strong></font>
					<select name="chapters" id="chapters" style='width:150px'>
						<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
						<option value="<?= $i ?>"><?= $i ?></option>
						<?php endfor ?>
					</select>

				<font size='5px'><strong>Verses:</strong></font>
					<select name="verses" id="verses" style='width:150px'>
						<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
						<option value="<?= $i ?>"><?= $i ?></option>
						<?php endfor ?>
					</select>
					</center>
			</div>

			<div id="verse_text" style='margin-top:70px;font-size:30px'>
					<?php echo '<center>'.$defaultVerseText[1]['verse_text']."<br/></center><p style = 'margin-left:800px;margin-top:20px'>".$defaultVerseText[1]['book_name'].' '.$defaultVerseText[0]['chapter_number'].':'.$defaultVerseText[0]['verse_number'].'</p>'; ?>
			</div>
			<div  class = "container well span6 offset3" id = "result" style = "margin-top: 100px">
			</div>
		</div>
	</div>
</div>



<script type="text/javascript" src="jquery.1.10.2.js"></script>
<script type="text/javascript" src = "js/search.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	function getVerseText(bid, cid, vid) {
		$.ajax({
			url: 'versetext.php',
			data: {book_id: bid, chapter_id: cid, verse_id: vid},
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#verse_text').html(response);
			},
			error: function(err) {
				alert("Error");
			}
		});
	}

	$('#books').on('change', function() {
		var bid = $(this).val();
		$.ajax({
			url: 'chapters.php',
			data: {book_id: bid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.chapters; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#chapters').html(str);
				getVerseText(bid, 1, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#chapters').on('change', function() {
		var bid = $('#books').val();
		var cid = $(this).val();
		$.ajax({
			url: 'verses.php',
			data: {book_id: bid, chapter_id: cid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.verses; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#verses').html(str);
				getVerseText(bid, cid, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#verses').on('change', function() {
		var bid = $('#books').val();
		var cid = $('#chapters').val();
		var vid = $(this).val();
		getVerseText(bid, cid, vid);
	});
});
</script>
</body>
</html>