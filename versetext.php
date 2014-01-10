<?php
include_once('config.php');
include_once('BibleDAO.php');

$book_id = (isset($_GET['book_id'])) ? $_GET['book_id']: false;
$chapter_id = (isset($_GET['chapter_id'])) ? $_GET['chapter_id']: false;
$verse_id = (isset($_GET['verse_id'])) ? $_GET['verse_id']: false;

$defaultVerseText = BibleDAO::getVerseText($book_id, $chapter_id, $verse_id);
echo "<center><p style = 'line-height: 1.5'>".$defaultVerseText[1]['verse_text']."</p><br/></center><p style = 'margin-left:800px;margin-top:20px'>".$defaultVerseText[1]['book_name'].' '.$defaultVerseText[0]['chapter_number'].':'.$defaultVerseText[0]['verse_number'].'</p>';