$(function()
{
	$('.refresh_btn').on('click',function()
	{
		var myDomain = $(this).data('domain'),
			url = 'http://www.whos.it/refresh';

		$('#content').html('<div class="row"><div class="span8"><div class="alert-success availability">Refreshing results for <strong>' + myDomain + '</strong>...</div></div></div>');

		$.ajax
		({
			type: "POST",
			url: url,
			data: { domain : myDomain },
			success : function(result)
			{
				var newContent = $(result).find('#content').html();
				$('#content').html(newContent);
			}
		});
	});
});