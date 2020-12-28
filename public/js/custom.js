$(document).ready(function() {
  
	$("#datatable").DataTable();

	$(".btn_edit").click( function() {
		
		var tmp_board = $(this).parent().siblings(".editable_boards").text();
		$(this).toggleClass('d-none');
		$(this).siblings().toggleClass('d-none');
		$(this).parent().siblings(".editable_boards").html(`<input type='text' class='w-100 update_trello_board' name='update_trello_board' value='${tmp_board}'>`)

	} )

	$(".btn_save").click(function() {
		
		$(this).toggleClass('d-none');
		$(this).siblings().toggleClass('d-none');

		var edited_data = $(this).parents('.list_invoice_index').find('.update_trello_board').val();
		var _token = $('input[name="_token"]').val()
		var id = $(this).parents('.list_invoice_index').find('input[type="hidden"]').val()
		
		$(this).parent().siblings(".editable_boards").text( edited_data );

		$.ajax({
			url: '/edit_trello_board',
			type: 'post',
			data: {
				edited_data: edited_data,
				_token: _token,
				edited_id: id
			},

			success: function(response) {
				console.log("response from Ajax: " + response)
			}
		})

    })
  
})