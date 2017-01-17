jQuery(document).ready(function($){
    $("#edit").hide();
    $("#nw").on("click",function(){
    	$("#edit").show();
    	
    });
    $("#cls").on("click",function(){
    	$("#task:input").val(" ");
    	$("#edit").hide();
    	
    });
    $("#task").on("submit", function(e){
    		e.preventDefault();
    	var dts=	$(this).serialize();
    	//alert(dts);
    	jQuery.ajax({
  method: "POST",
  url: window.location.pathname,
  data: dts
})
  .done(function( msg ) {
  	$("#edit").hide();
  	//alert(msg);
  	var $data = jQuery(msg);
  	//alert($data);
  	$data =$data.find("#tbl").html();
  	alert($data);
    jQuery("#tbl").html($data);
  }).fail(function(msg){
  	alert("failed");
  });
    });
});
function getid(id){
	//e.preventDefault();
	//alert(id);
	/*alert(window.location.pathname.substr(1));
	 //"http://web/press/wp-content/plugins/fogg/form.js?ver=1.12.4"
	  $.post(window.location.pathname.substr(1), {task_id: id,del:3}, function(result){
        //$("task").html(result);
        alert(result);
    });*/
    var dts ={ task_id: id, del: "3" };
    //alert(dts.del+"\t "+dts.task_id+"\t "+window.location.pathname);
	 jQuery.ajax({
  method: "POST",
  url: window.location.pathname,
  data: dts
})
  .done(function( msg ) {
  	alert(msg);
  	var $data = jQuery(msg);
  	alert($data);
  	$data =$data.find("#tbl").html();
  	alert($data);
    jQuery("#tbl").html($data);
  }).fail(function(msg){
  	alert("failed");
  });
}
function getform(id){
	jQuery("#edit").show();
	jQuery("#task_id").val(id);
	//jQuery("#user_id").attr("type","hidden");
		//jQuery("#idse").css("display","none");
	jQuery("#task_submit").val("2");
	jQuery("#edit").prepend("<h1>Updating Task"+id+"</h1>");
}