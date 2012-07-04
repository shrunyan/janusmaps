//janusmap
//Stuart Runyan	
$(document).ready(function(){
	
$('#no-js').hide();
$.ajaxSettings.cache = false;


/*************************
	MODAL WINDOW CONTROLS 
***************************/
	//Loads the href of a link with the ajaxtrigger class through ajax
	$('.ajaxtrigger').live('click', function() {
		var url = $(this).attr('href');
		var resultsCon = $('.results');
		resultsCon.parent().fadeIn();
		resultsCon.html('<div><img src="../images/ajax-loader.gif" width="220" height="19" /></div>');
		resultsCon.load(url);
		return false;
	});
	
	//Closes all modal windows
	$('.modal .close').live('click', function(){
		modalBkgRemove();
		return false;
	});
	
	//Hide modal windows and bkg on keypress "Esc"
	$(document).keypress(function(event){
		if(event.keyCode == 27){
			$('#modal-bkg').remove();
			$('.modal').hide();
		}							  
	});
	
	//Create new trip in database and set HTML
	$('#new-trip-form').live('submit', function(){
		var data = $(this).serialize();
		modalBkgRemove();
		
		//hide all uneccessary lists
		$('#intro-list').hide();
		$('#homepage-list').hide();
		
		$('#sidebar').load('functions/create_new_list.php',data,function(){
			$('#homepage-list').hide();
			
			//Show necessary lists
			$('#list-instructions').fadeIn(600);
			$('#list-title').show();
			
			//Reset and set some values
			placeId = 0;
			map.clearOverlays();			
		});
		return false;
	});
	
	//Save List confirm
	$('#save-btn').click(function(){
		var saveMessage = $('#save-confirm');
		var listTitle = $('#list-title').find('span').html();
		var listId = $('#places-list').attr('class');
		var getId = listId.split('-');
		var id = getId[1];
		var list;
		if (id){
			list = {
				id:""+id+"", 
				title:""+listTitle+"",
				list: ""+JSON.stringify(gResults)+""
			};
		}		
		$.ajax({
			type: "POST",
			url: "functions/save_list.php",
			data: list,
			success: function(response){
				saveMessage.html(response).stop(true, true).slideDown().delay(2000).fadeOut(1200);
			}
		});
		$('.modal').hide();
		console.log(list);		
	});	
	
	
	//Open previous list
	$('#list-saved-trips .trip-name a').live('click', function(){
		var string = $(this).attr('id');
		var getId = string.split("-");
		var listId = getId[1];
		gResults = [];
		gmarkers = [];
		side_bar_html = [];
		i = 0;

		$.ajax({
			type: "POST",
			url: "functions/retrieve_list.php",
			data: {"id":listId},
			success: function(response){
				createList(response);
			}
		});
		
		return false;
	});
	
	
	//Delete list item 
	$('.delete-trip').live('click', function(){
		$(this).next('span').show();				   
	});
	$('.delete-confirm').live('click', function(){
		var string = $(this).find('a').attr('href');
		var getId = string.split("=");
		var id = getId[1];
		$('#list-saved-trips').load('functions/delete_list.php?id='+id);
		return false;
	});
	
	//Account settings
	$('#username-label .edit-user').live('click', function(){
		$('#username').toggle();		   
	});
	$('#useremail-label .edit-user').live('click', function(){
		$('#useremail').toggle();		   
	});
	
	//Display last saved list
	$('#intro-last').live('click', function(){
		$.ajax({
			type: "POST",
			url: "functions/last_list.php",
			success: function(response){
				if(response == "false"){
					$('.results').html('You have not created a list yet.')
					$('.modal').fadeIn(300).delay(1000).fadeOut(300);
				} else {
					createList(response);
				}
			}
		});
		return false;
	});


/*** Submit with AJAX forms ***************************/
$('.ajaxForm').live('submit', function(){
	var data = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "functions/form_ajax.php",
		data: data,
		success: function(response){
			//alert(response);
			//Checking against response length if less than 10 it returned the string 'success'
			if(response.length >= 10 ){
				var obj = eval('(' + response + ')');
				//Login form checking
				if(obj.form == 'login'){
					if("login_email" in obj){
						$('#login_email_error').html(obj.login_email);
					} else {
						$('#login_email_error').html('');
					}
					if("login_password" in obj){
						$('#login_password_error').html(obj.login_password);
					} else {
						$('#login_password_error').html('');
					}
					if("login" in obj){
						$('#login_error').html(obj.login);
					} else {
						$('#login_error').html('');
					}
				} 
				//Signup form checking
				else if (obj.form == 'signup'){
					if("signup_name" in obj){
						$('#signup_name_error').html(obj.signup_name);
					} else {
						$('#signup_name_error').html('');
					}
					if("signup_email" in obj){
						$('#signup_email_error').html(obj.signup_email);
					} else {
						$('#signup_email_error').html('');
					}
					if("signup_password" in obj){
						$('#signup_password_error').html(obj.signup_password);
					} else {
						$('#signup_password_error').html('');
					}
					if("signup_password_repeat" in obj){
						$('#signup_password_repeat_error').html(obj.signup_password_repeat);
					} else {
						$('#signup_password_repeat_error').html('');
					}
					if("captcha" in obj){
						$('#captcha_error').html(obj.captcha);
					} else {
						$('#captcha_error').html('');
					}
				} 
				//Contact form checking
				else if (obj.form == 'contact'){
					if("name" in obj){
						$('#name_error').html(obj.name);
					} else {
						$('#name_error').html('');
					}
					if("email" in obj){
						$('#email_error').html(obj.email);
					} else {
						$('#email_error').html('');
					}
					if("contact_message" in obj){
						$('#message_error').html(obj.contact_message);
					} else {
						$('#message_error').html('');
					}
				}
			} else if(response == "success") {
				location.href = "index.php";
			} else if (response == "error"){
				alert('Form processing failed');
			}else {
				alert('Server Error');
			}
		}
	});
	
	return false;
});	

	
	
/*** ASIDE CONTROLS ***************************/
	/* DOn't need this
	//Places click shows infoWindow 
	$('#places-list li').live('click',function(){
		var listItemId = $(this).attr('id');
		//infoWindow.open(map, marker);
		//gmarkers[0].openInfoWindowHtml(gResults[0].Placemark[0].address);
	});
	*/
	
	//Close list 
	$('#list-title .delete').live('click', function(){
		var listTitle = $('#list-title');
		var placesList = $('#places-list');
		$('#list-instructions').fadeOut(200);
		$('#scrollup').fadeOut(200);
		$('#scrolldown').fadeOut(200);
		placesList.slideUp(600, function(){			
			listTitle.slideUp(300, function(){
				
				listTitle.hide();
				listTitle.find('span').html('');
				placesList.html('');
				placesList.removeClass();
				placesList.show();
				//$(this).remove();
				map.clearOverlays();
				
				//Reset arrays
				gResults = [];
				side_bar_html = [];
				gmarkers = [];
				//gmarkersLat = [];
				//gmarkersLng = [];
				//gpoly = [];
				//htmls = [];
				
				//Reset naming system on list items
				placesId = 0;
				i = 0;

				$('#homepage-list').fadeIn(800)
				
				showSidebarScrolls();
			});
		});		
	});
	

/*** FUNCTIONS ***************************/
	//Modal Window Bkg
	function modalBkg(){
		var bkgExists = $('#modal-bkg').length;
		$('body').append('<div id="modal-bkg"></div>');	
	};
	
	function modalBkgRemove(){
		//$('#modal-bkg').remove();
		$('.modal').hide();
	};
	
	function listEmpty(){
		var subList = $('.places-sub-list li').length;
		if(subList == 1){
			$('.places-sub-list').remove();	
		};
	};
	
	function listExists(){
		var mainList = $('.places-sub-list').length;
		if(mainList == 1){
			$('.places-sub-list').parent('li').find('.more').show();
		};
	};
	listExists();
	
	//Build HTML for a previous list
	function createList(response){
		var obj = eval('(' + response + ')');			
		var list = eval('(' + obj.list_content + ')');
		var listId = obj.id
		var getListTitle = $('#list-title');
		var getList = $('#places-list');
		
		//Setup HTML
		getListTitle.find('span').html(obj.list_title);
		getList.addClass('list-'+listId);
		
		//Hide and show appropriate lists
		$('#homepage-list').fadeOut(400, function(){
			$('.modal').fadeOut(400);
			getListTitle.slideDown(600, function(){
				var listHtml = "";						
				for(j=0; j < list.length; j++){
					gResults[j] = list[j];
					if(list[j].skip == 0){
						listHtml += '';
					} else {
						listHtml += '<li id="item'+j+'">'+
							'<span class="place">'+
								'<a href="javascript:showInfoWindow(' + j + ')">' + list[j].Placemark[0].address + '</a></span>'+
							'<span class="edit">'+
								'<a href="javascript:removeMarker(' + j + ')">X</a>'+
								'<a class="more" href="JavaScript://">>></a>'+
						   '</li>';
						i++;
					}
				}
				getList.html(listHtml).fadeIn(600);
				showSidebarScrolls();
			});
		});	
	};



/*** Pulling Data from Maps API and insterting it into the DOM / Other Map functions ***************************/
	//Place delete function from map
	$('.remove-marker').live('click', function(){
		//Get class and remove both from list and map
		var i = $(this).attr('id');
		var removePlace = '#'+i;
		$(removePlace).remove();
		$(this).remove();
		return false;
	});
	
	//Set keystroke for "Enter" on the search bar
	$('#address').keypress(function(event){
		if(event.keyCode == 13){
			//some code, still need to figure out how to submit form on keypress "enter" button
		}		  
	});

	

						   
});