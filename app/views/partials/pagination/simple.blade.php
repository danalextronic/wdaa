<ul class="pager">
	@if(!empty($previous_link))
		<li class="previous">
			<a href="{{$previous_link}}">&larr; Previous</a>
		</li>
	@endif

	@if(!empty($next_link))
		<li class="next">
			<a href="{{$next_link}}">Next &rarr;</a>
		</li>
	@endif
</ul>
