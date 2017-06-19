$(document).ready(function() {

});
 
function thumb_up(url,post_id,user_ip) {
	var senddata = url + "ajax/thumb_up.php?post_id=" + post_id + "&user_ip=" + user_ip;
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#thumbs_up_"+post_id).load(url + "ajax/reload_thumbs.php?post_id=" + post_id + "&type=up");
			$("#thumbs_down_"+post_id).load(url + "ajax/reload_thumbs.php?post_id=" + post_id + "&type=down");
			$("#vote_text_"+post_id).html(data);
			$("#btn_t_u").attr("onclick","javascript:void(0);");
			$("#btn_t_d").attr("onclick","javascript:void(0);");
        }
    });
}

function thumb_down(url,post_id,user_ip) {
	var senddata = url + "ajax/thumb_down.php?post_id=" + post_id + "&user_ip=" + user_ip;
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#thumbs_up_"+post_id).load(url + "ajax/reload_thumbs.php?post_id=" + post_id + "&type=up");
			$("#thumbs_down_"+post_id).load(url + "ajax/reload_thumbs.php?post_id=" + post_id + "&type=down");
			$("#vote_text_"+post_id).html(data);
			$("#btn_t_u").attr("onclick","javascript:void(0);");
			$("#btn_t_d").attr("onclick","javascript:void(0);");
        }
    });
}

function load_page(url,divid,type,pagenum,custom_id) {
	$('body,html').animate({scrollTop:0},800);
	var senddata = url + "ajax/load_posts.php?type="+ type +"&page="+ pagenum + "&custom_id=" + custom_id;
	$(divid).hide("fast");
	$("#loader").show("fast");
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#loader").hide("fast");
			$(divid).html(data);
			$(divid).show("fast");
        }
    });
}
