$(document).ready(function(){

});

var WIReview = {};

WIReview.reviewSave = function(){
	var review = $("#new-review").val();
}

WIReview.showRating = function(){
	var rating = '';

}

WIReview.starMark = function(item){

	var rating = '';
	var count = item.id[0];
	rating = count;
	var subid = item.id.substring(2);

	for (var 1=0;i<5;i++)
	{
		if(i<count)
		{
		document.getElementById((i+1)+subid).sttyle.color="orange";
		}else{
		document.getElementById((i+1)+subid).style.color="black";
	}
}




