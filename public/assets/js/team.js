$(document).ready(function() {

	var base_url = window.location.origin;

	$(".accordion").on("click", ".clicks", function(evt) {

	var id = evt.currentTarget.id;
	var icon = evt.currentTarget.childNodes[0];

	if(evt.currentTarget.childNodes[0].className == "si-minus si"){
		if(evt.currentTarget.offsetParent.nextElementSibling){
			evt.currentTarget.offsetParent.nextElementSibling.remove();
			evt.currentTarget.innerHTML = "<i class='si si si-plus'></i>";
			return false;
		}

	}

	if(evt.currentTarget.childNodes[0].className == "si si si-plus"){
		evt.currentTarget.innerHTML = "<i class='si-minus si'></i>";

	}
	else{
		evt.currentTarget.innerHTML = "<i class='si-minus si'></i>";
	}

		$.ajax({
			url:"/ekibimgetir/"+id,
			type:"get",
			beforeSend: function() {
				$(evt.currentTarget).parent("li").after("<img class='spinnerx' src='https://panel.opibot.io/assets/img/loader.svg' style='width: 20px !important;'>");
      },
			success:function(r){
			    console.log(r);
				$(evt.currentTarget).parent("li").after(r);
				$(".spinnerx").remove();
			}
		});

	});

});
