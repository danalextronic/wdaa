<div id="video-player">Loading Video Player</div>

<script>
	jwplayer("video-player").setup({
		file: "{{$url}}",
		image: "{{isset($image_url) ? $image_url : ''}}",
		width: "100%",
		aspectratio: "16:9",
		stretching: "exactfit"
	});
</script>
