function htmlEncode(str){
    return String(str).replace(/[^\w. ]/gi, function(c){
        return '&#'+c.charCodeAt(0)+';';
    });
}

function editPost(data) {
    var id = $(data).data('id');
    var post = $(data).data('post');
    var image = $(data).data('image');

    $("#edit_post").val(post);
    $("#id").val(id);
    $('#edit_form').prop('action', '/posts/edit/'+id);

    if (image != '') {
      $("#edit_preview").removeClass("d-none");
      $("#btn").text("EDIT IMAGE");
      $("#image_edit").attr("src", '../../img/post_upload/'+image);
    } else {
      $("#edit_preview").addClass("d-none");
      $("#btn_remove").addClass("d-none");
      $("#image_edit").attr("src", null);
      $("#btn").text("ADD IMAGE");
    }
  }

  function remove_image() {
    $('#image_edit').attr('src', null);
    $("#edit_preview").addClass("d-none");
    $("#btn_remove").addClass("d-none");
    $('#btn').html('ADD IMAGE');
    $('#remove_image').val('removed');
  }

function deletePost(data) {
    var id = $(data).data('id');
    $('#delete_form').prop('action', '/posts/delete/'+id);
  }

function like(data) {
      var user_id = $(data).data('userid');
      var post_id = $(data).data('postid');
      var value = $(data).data('value');
      var btnLike = document.getElementById(post_id);

      if (isLogged_in == "") {
        window.location.href = "/users/login";
      }

      $.ajax({
        url: "/likes/add",
        data: {
          user_id: user_id,
          post_id: post_id,
          value: value,
        },
        type: "JSON",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
        },
        success: function(result) {
          let response = $.parseJSON(result);
          console.log(response);
          if (response['status'] == "UNLIKE") {
            btnLike.innerHTML = "LIKE"+" ("+response['count']+")";
          } else if (response['status'] == "LIKE") {
            btnLike.innerHTML = "UNLIKE"+" ("+response['count']+")";
            if (response['inserted_id'] != 0) {
              $(data).data('value', response['inserted_id']);
            }
          } else {
            window.location.href = "/users/login";
          }
        }
      });
  }

function addcomment(data) {

      var post_id = $(data).data('pid');
      var user_id = $(data).data('uid');
      var comment_id = "comment_"+post_id;
      var comment = document.getElementById(comment_id).value;
      var btncomment = "btncomment_"+post_id;
      var loading = '<i class="fa fa-spinner fa-spin"></i>';

      if(comment.length == 0){
          $('#emptyComment').remove();
          $('#'+comment_id).after('<div style="font-size:12px;color:red;" id="emptyComment">Comment is Required</div>').end();
      }
      else {
          $('#'+btncomment).html(loading);
          $('#'+btncomment).prop('disabled', true);
          $('#'+comment_id).next(".red").remove();

          $.ajax({
            url: "/comments/add",
            data: {
              post_id: post_id,
              user_id: user_id,
              comment: comment,
            },
            type: "JSON",
            method: "POST",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
            },
            success: function(result) {
              var pageURL = $(location).attr("pathname");
              if (pageURL.substring(0, 11) == "/posts/view") {
                location.reload();
              } else {
                // $('#comment_section').load(location.href + "#comment_section");
                location.reload();
              }
            }
          });
      }

  }

function edtcmmt(data) {
    var id = $(data).data('id');
    var comment = $(data).data('comment');
    $("#editC").text(comment);
    $('#comment_edit').attr('action', '/comments/edit/' + id);
  }

  function deleteComment() {
    var id = $("#comment_ids").val();

    $.ajax({
      url: "/comments/delete/"+id,
      type: "JSON",
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
      },
      success: function(result) {
          location.reload();
      }
    });

    // $('#delete_comment').attr('action', '/comments/delete/'+id);
  }

  function deleteid(id) {
    var id = $(id).data('id');
    $('#comment_ids').val(id);
  }


  // share
function share(data) {
  var id = $(data).data('postid');
  $.ajax({
    url: "/posts/view/"+id,
    type: "JSON",
    method: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
    },
    success: function(result) {

      let arr = $.parseJSON(result);
      var post = $("#spost");
      var fullname = $("#sname");
      var date = $("#sdate");
      var image = $("#simage");
      var profile = $("#sprofile");
      if (arr['status'] == 'found') {
        let users = arr['users'];
        var post_id = $("#post_id");
        users.forEach(function(item) {
            if (arr['post']['user_id'] == item['id']) {
              var d = new Date(arr['post']['created']);
              var day = d.getDate();
              var month = d.getMonth() + 1;
              var year = d.getFullYear();
              if (day < 10) {
                  day = "0" + day;
              }
              if (month < 10) {
                  month = "0" + month;
              }
              var date_formatted = day + "/" + month + "/" + year;

              profile.attr("src","../../img/upload/"+item['profile_path']);
              fullname.html(item['full_name']);
              date.html(date_formatted);
              post.html(htmlEncode(arr['post']['post']));
              post_id.val(arr['post']['id']);

              if (arr['post']['image_path'] != null) {
                image.removeClass('d-none');
                image.attr("src","../../img/post_upload/"+arr['post']['image_path']);
              } else {
                image.addClass('d-none');
              }
            }
            $('#btnShareCancel').addClass('col-6');
            $('#btnShareCancel').removeClass('col-12');
            $('#btnShare').removeClass('d-none');
            profile.removeClass('d-none');
            profile.removeClass('d-none');
        });
      } else {
        fullname.html("");
        date.html("");
        var content = "<center>Share Content Not Found</center>";
        post.html(content);
        profile.addClass('d-none');
        image.addClass('d-none');
        $('#btnShare').addClass('d-none');
        $('#btnShareCancel').removeClass('col-6');
        $('#btnShareCancel').addClass('col-12');
      }

    }
  });

}


function follow(data) {
  var following = $(data).data('following');
  var follower = $(data).data('follower');
  var followerdid = $(data).data('followedid');
  var value = $("#btnFollow").html();

  if (value == "Following") {
    $.ajax({
      url: "/followers/delete/"+followerdid,
      type: "JSON",
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
      },
      success: function(result) {
        let data = $.parseJSON(result);
        if (data['message'] == 'success') {
          if (data['data'] == 'unfollowed') {
            $("#btnFollow").html("Follow");
            location.reload();
          }
        }
      }
    });
  } else if (value == "Follow") {
    $.ajax({
      url: "/followers/add",
      data: {
        following_user	: following,
        follower_user: follower,
      },
      type: "JSON",
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
      },
      success: function(result) {
        let data = $.parseJSON(result);
        if (data['message'] == 'success') {
          if (data['data'] == 'followed') {
            $("#btnFollow").html("Following");
            location.reload();
          }
        }
      }
    });
  }

}

function unfollow(data) {
  var following = $(data).data('followedid');

  $.ajax({
    url: "/followers/delete/"+following,
    type: "JSON",
    method: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content'),
    },
    success: function(result) {
      let data = $.parseJSON(result);
      alert(data['data']);
      if (data['message'] == 'success') {
        if (data['data'] == 'unfollowed') {
          $("#btnunFollow").addClass("d-none");
        }
      }
    }
  });

}

function showComment(id) {
  var id = $(id).data('id');
  $("#post_"+id).removeClass('d-none');
  $("#comment_"+id).focus();
}

function loadMore(data) {
    var id = $(data).data('id');
    var content = ".content_"+id+":hidden";
    $(content).slice(0, 3).slideDown();
    if($(content).length == 0) {
      $("#loadMore_"+id).text("No More Comment").addClass("noContent");
    }
}
