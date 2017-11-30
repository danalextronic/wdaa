var base_url = window.location.protocol + "//" + window.location.hostname;

// extract data from one object into another
function extract(data, where) {
    for (var key in data) {
        where[key] = data[key];
    }
}


function isiOS()
{
    return (
        (navigator.platform.indexOf("iPhone") != -1) ||
        (navigator.platform.indexOf("iPod") != -1) ||
        (navigator.platform.indexOf("iPad") != -1)
    );
}

function loadVideo(e, link) {
	e.preventDefault();

	var url, title;

	if(this.href) {
		url = this.href;
	}
	else if(typeof link !== 'undefined' && typeof link.href !== 'undefined')  {
		url = link.href;
	}

	if(this.title) {
		title = this.title;
	}
	else if(typeof link !== 'undefined' && typeof link.title !== 'undefined') {
		title = link.title;
	}
	else {
		title = "Video";
	}

	if(url.length === 0) {
		return false;
	}

	if(isiOS()) {
		window.open(url, title);
		return false;
	}

	try {
		$.fancybox({
    		"title" : title,
    		"autoSize" : false,
    		"width" : "960px",
    		"height" : "540px",
    		"padding": 0,
    		"scrolling" : 'no',
    		"content": '<div id="video_container">Loading the player ... </div>',
			afterShow: function() {
	            jwplayer("video_container").setup({ 
	                file: ""+ url +"",
				    image: "",
				    width: '960px',
				    height : '540px',
				    fallback: 'false',
				    autostart: 'true',
				    primary: 'html5',
				    controls: 'true',
				    stretching : 'exactfit'
				});
			}
    	});
	}
	catch(e) {
		console.log(e.message);
	}

	return false;
}

$(document).ready(function() {
	$(".load_video").on('click', loadVideo);
});
