$(document).ready(function() {
  $('.comments').addClass('hide');
  commentButton();
  platformButton();
  heartButton();
  getPosts();
});

// Platform selector in poster
function platformButton() {
  $("#facebook").click(function() {
    $('#facebook').toggleClass('active');
  });
  $("#instagram").click(function() {
    $('#instagram').toggleClass('active');
  });
  $("#googleplus").click(function() {
    $('#googleplus').toggleClass('active');
  });
  $("#twitter").click(function() {
    $('#twitter').toggleClass('active');
  });
}

// Heart-It-interacties
function heartButton() {
  $(".heart-it").click(function() {
    $(this).toggleClass('active');
	like(userId, type, socialMedia, this.id)
  });
}

// Comment-It-interacties
function commentButton() {
  $("#comment-it").click(function() {
    $('#comment-it').toggleClass('active');
    $('.comments').toggleClass('hide');
  });
}

// Get Array of Posts
var getPosts function(userIds, until)
{
  $.ajax({
    url: ajaxhHandlerUrl,
    data: {
      method: getPosts,
      userIds: userIds,
      until: until
    },
    type: "GET",
    dataType : "json",
    success: function( json ) {
      var result = JSON.parse(json);
      for (i = 0; i < result.length; i++) {
        if (result[i].socialmedium == 'facebook') {
          var htmlcode_message = '<p>' + result[i].post.message + '</p>';
          $("div id=\"post\"").append(htmlcode_message);
          var htmlcode_author = '<p>' + result[i].post.id + '</p>';
          $("div id=\"author\"").append(htmlcode_author);
          var htmlcode_date = '<p>' + result[i].post.created_time + '</p>';
          $("div id=\"date\"").append(htmlcode_date);
        } else if (result[i].socialmedium == 'twitter') {
          var htmlcode_message = '<p>' + result[i].??? + '</p>';
          $("div id=\"post\"").append(htmlcode_message);
          var htmlcode_author = '<p>' + result[i].??? + '</p>';
          $("div id=\"author\"").append(htmlcode_author);
          var htmlcode_date = '<p>' + result[i].??? + '</p>';
          $("div id=\"date\"").append(htmlcode_date);

        } else if (result[i].socialmedium == 'googleplus') {
          var htmlcode_message = '<p>' + result[i].url + '</p>';
          $("div id=\"post\"").append(htmlcode_message);
          var htmlcode_author = '<p>' + result[i].actor.displayName + '</p>';
          $("div id=\"author\"").append(htmlcode_author);
          var htmlcode_date = '<p>' + result[i].published + '</p>';
          $("div id=\"date\"").append(htmlcode_date);
        } else if (result[i].socialmedium == 'instagram') {
          var htmlcode_message = '<p>' + result[i].images.standard_resolution.url + '</p>';
          $("div id=\"post\"").append(htmlcode_message);
          var htmlcode_author = '<p>' + result[i].data.user.username + '</p>';
          $("div id=\"author\"").append(htmlcode_author);
          var htmlcode_date = '<p>' + result[i].data.created_time + '</p>';
          $("div id=\"date\"").append(htmlcode_date);
        }
      }
    },
    error: function( xhr, status, errorThrown ) {
      alert( "Sorry, there was a problem!" );
      console.log( "Error: " + errorThrown );
      console.log( "Status: " + status );
      console.dir( xhr );
    },
  });
};

var postMessage function(userIds, text, socialMedia)
{
	$.ajax({
		// The URL for the request
		url: ajaxhHandlerUrl,
		// The data to send (will be converted to a query string)
		data: {
			method: postMessage,
			userIds: userIds,
			text: text,
			socialMedia: socialMedia
		},
		// Whether this is a POST or GET request
		type: "POST",
		// The type of data we expect back
		dataType : "json",
		// Code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			console.log("successfully posted text");
		},
		// Code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
	});
};

var like function(userId, type, socialMedia, id)
{
	$.ajax({
		// The URL for the request
		url: ajaxhHandlerUrl,
		// The data to send (will be converted to a query string)
		data: {
			method: like,
			userId: userId,
			type: type,
			socialMedia: socialMedia,
			id: id
		},
		// Whether this is a POST or GET request
		type: "POST",
		// The type of data we expect back
		dataType : "json",
		// Code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			console.log("successfully posted like");
		},
		// Code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
	});
};

var retweetTwit function(userId, id)
{
	$.ajax({
		// The URL for the request
		url: ajaxhHandlerUrl,
		// The data to send (will be converted to a query string)
		data: {
			method: retweetTwit,
			userId: userId,
			id: id
		},
		// Whether this is a POST or GET request
		type: "POST",
		// The type of data we expect back
		dataType : "json",
		// Code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			console.log("successfully retweeted tweet");
		},
		// Code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
	});
};

var commentPost function(userId, text, socialMedia, postId)
{
	$.ajax({
		// The URL for the request
		url: ajaxhHandlerUrl,
		// The data to send (will be converted to a query string)
		data: {
			method: comment,
			userId: userId,
			text: text,
			socialMedia: socialMedia,
			postId: postId
		},
		// Whether this is a POST or GET request
		type: "POST",
		// The type of data we expect back
		dataType : "json",
		// Code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			console.log("successfully posted comment");
		},
		// Code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
	});
};

var commentGet function(userid, socialMedia, postId)
{
	$.ajax({
		// The URL for the request
		url: ajaxhHandlerUrl,
		// The data to send (will be converted to a query string)
		data: {
			method: comment,
			userId: userId,
			socialMedia: socialMedia,
			postId: postId
		},
		// Whether this is a POST or GET request
		type: "GET",
		// The type of data we expect back
		dataType : "json",
		// Code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			console.log("successfully loaded comments");
		},
		// Code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},
	});
};
