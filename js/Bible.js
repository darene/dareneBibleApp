$(document).ready(function() {
	function getVerseText(bid, cid, vid) {
		$.ajax({
			url: 'versetext.php',
			data: {book_id: bid, chapter_id: cid, verse_id: vid},
			dataType: 'JSON',
			method: 'POST',
			success: function(response) {
				var str = '<p>&nbsp; &nbsp;' + response.book_name + '  '+ response.chapter_number + ':' + response.verse_number + '</p>';
				var str2 = "<p style = 'line-height: 1.5;'>" + response.verse_text + '</p>';
				$('#bookCHpVrs').html(str);
				$('#verse_text').html(str2);
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
			method: 'POST',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.chapters; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				var str2 = '';
				for(i = 1; i <= response.verses; i++) {
					str2 += '<option value=' + i + '>' + i + '</option>';
				}
				$('#chapters').html(str);
				$('#verses').html(str2);
				getVerseText(bid, 1, 1);
			},
			error: function(err) {
				alert('An error occured!');
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
			method: 'POST',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.verses; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#verses').html(str);
				getVerseText(bid, cid, 1);
			},
			error: function(err) {
				alert('An error occured');
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
