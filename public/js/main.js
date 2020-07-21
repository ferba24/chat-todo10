$(function() {
		
	ion.sound({
		sounds: [
			{name: "bell_ring"}
		],
		path: "js/sounds/",
		preload: false,
		multiplay: false,
		volume: 0.9
	});
			
			//
	 $("#searchxt").keyup(function(){
	 _this = this;
	 // Show only matching TR, hide rest of them
	 $.each($("#searchxt tbody tr"), function() {
		 if($(this).find("td:first").text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
			$(this).hide();
		 else
			$(this).show();
		 });
	 });
	 
	 //
	 /*$("#searchy").keyup(function(){
	 _this = this;
	 // Show only matching TR, hide rest of them
	 $.each($("#searchy tbody tr"), function() {
		 if($(this).find("td:first").text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
			$(this).hide();
		 else
			$(this).show();
		 });
	 });*/
	 
	 //
	 $('#search').keyup(function() {
			var filter = jQuery(this).val();
			jQuery("#users-list li").each(function () {
				if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
					jQuery(this).hide();
				} else {
					jQuery(this).show()
				}
			});
		});
		
	//
	$('#searchRooms').keyup(function() {
			var filter = jQuery(this).val();
			jQuery("#rooms-list li").each(function () {
				if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
					jQuery(this).hide();
				} else {
					jQuery(this).show()
				}
			});
		});
		
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
	
});
