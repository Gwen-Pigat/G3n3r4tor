setTimeout(function(){
    loadProjects("ajax/loadProjects.php");
},500);

setTimeout(function(){
    $(".title_fade").css("opacity","1").addClass("slideInDown");
    $("form").addClass("slideInUp").css("opacity","1");
    $("form input").focus();
},1000);

/* BLOC MESSAGE DE RETOUR AJAX */
function msgbox(div,error,errormsg){$(div).hide();$(div).html(errormsg);if(error){$(div).addClass("alert alert-danger");}else{$(div).removeClass('alert alert-danger').addClass('alert alert-success');}$(div).fadeIn("fast");}
/* PERMET DE VIDER LE FORMULAIRE APRES RETOUR VALIDE */
function vider_formulaire(form) {$(':input',form).not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');}

function ajax_form(id_form,id_result,url_ajax,reload){
    $(id_form).submit(function(){
        $.ajax({
            type:'post',
            url:url_ajax,
            data:$(this).serialize(),
            dataType:'json',
            success:function(data){
                if(data.alert){
                    swal({
                        title: data.title,
                        text: data.text,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $("#projets_box .row").empty();
                    loadProjects("ajax/loadProjects.php");
                    dataProjet();
                    vider_formulaire(id_form);
                } else{
                    msgbox(id_result,data.error,data.text);
                }
                if(data.errorcode==false){vider_formulaire(id_form);}
                if(data.errorcode==false && reload==true){location.reload();}
            },error:function(xhr, ajaxOptions, thrownError){
            	msgbox(id_result,true,'Error : ' + xhr.responseText +' '+ajaxOptions+' '+xhr.status+' '+thrownError);
            }
        });
        return false;
    });
}
function alert(msg){
    sweetAlert('', msg, "warning");
}

function loadProjects(url_ajax){
    $.ajax({
        type:'post',
        url:url_ajax,
        data:$(this).serialize(),
        dataType:'json',
        success:function(data){
            if(data.no_projects){
                $("#projets_box .row").empty();
                $("#projets_box .row").append('<span class="btn btn-grad-yellow animated fadeInDown"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aucun projet pour le moment</span>');
            } else{
                $("#projets_box .row").empty();
                $.each(data, function(index, item){
                    $("#projets_box .row").append('<div class="col-lg-3 animated flipInX"><div class="input-group input-projet"><button class="btn btn-grad-black btn-block">'+item.pro_titre+'</button><span class="input-group-btn"><button data-projet="'+item.pro_id+'" class="btn btn-delete btn-grad-red" type="button"><i class="fa fa-times"></i></button></span></div></div>');
                });
                dataProjet();
            }
        },error:function(xhr, ajaxOptions, thrownError){
            alert('Error : ' + xhr.responseText +' '+ajaxOptions+' '+xhr.status+' '+thrownError);
        }
    });
}


function delete_datas(datas,url_ajax,title,text,color,confirm){
    swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: confirm,
        cancelButtonText: "Annuler !!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            type:'get',
            url:url_ajax,
            data:"projet="+datas,
            dataType:'json',
            success:function(data){
                if(data.alert && !data.errocode){
                    swal(data.title, data.text, "success");
                    $("#projets_box row").empty();
                    loadProjects("ajax/loadProjects.php");
                    dataProjet();
                } else{
                    swal(data.title, data.text, "danger");
                }
            },error:function(xhr, ajaxOptions, thrownError){
                alert('Error : ' + xhr.responseText +' '+ajaxOptions+' '+xhr.status+' '+thrownError);
            }
        });
        return false;
    });
}

setTimeout(function(){
    $(".btn-delete").click(function(){
        var id_prj = $(this).attr("data-projet");

        var datas = [
            id_prj,
            "Etes-vous sur ?",
            "Vous ne pourrez plus revenir en arrière",
            "#ff0000",
            "Oui, confirmez"
        ];
        delete_datas(datas[0],"ajax/deleteAjax.php",datas[1],datas[2],datas[3],datas[4]);
    });
},1000);


function dataProjet(){
    setTimeout(function(){
        $(".btn-delete").click(function(){
            var id_prj = $(this).attr("data-projet");
            var datas = [
                id_prj,
                "Etes-vous sur ?",
                "Vous ne pourrez plus revenir en arrière",
                "#ff0000",
                "Oui, confirmez"
            ];
            delete_datas(datas[0],"ajax/deleteAjax.php",datas[1],datas[2],datas[3],datas[4]);
        });
    },1000);
}

var urlFixed = window.location.href;
var url = "http://localhost/PHP/TemplateTest/GeneRator/index.php";
var length = url.length;

if(urlFixed != url){
    window.location.href=url;
}


var keys = {};
 
$(document).keydown(function (e) {
    keys[e.which] = true;
    f = '70' in keys;
    l = '76' in keys;
    u = '85' in keys;
    s = '83' in keys;
    h = '72' in keys;

    if(f && l && u && s && h){
        var datas = [
            "flush",
            "FLUSH ADMIN !!!!!!",
            "Attention Gwen !! Tu ne pourras pas revenir en arrière",
            "#ff0000",
            "Oui, confirmez"
        ];
        delete_datas(datas[0],"ajax/deleteAjax.php",datas[1],datas[2],datas[3],datas[4]);
    }
});

$(document).keyup(function (e) {
    delete keys[e.which];
});

$(".btn-switch").click(function(){
    var id = $(this).attr("id");
    id=id.substr(7,20);
    $("#" + id + "_blocs").slideToggle(500);
});

ajax_form("#post_datas","#results","ajax/createProjectAjax.php",true);