@extends('layouts.email')

@section('subject')
	{{$subject}}
@stop

@section('content')
	<p>Below is a summary of your recent order on {{date('F, jS, Y \a\t g:iA')}}</p>


	<div style="padding:20px 0">
		<table style="width:400px; margin:0 auto; text-align:left" border="1">
			<thead>
				<tr>
					<th>Name</th>
					<th>Cost</th>
				</tr>
			</thead>
			<tbody>
				@foreach($items as $item)
				<tr>
					<td>{{$item->package->name}}</td>
					<td>
						<span style="{{($item->final_cost) ? 'text-decoration:line-through' : 'font-weight:bold'}}">${{$item->cost}}</span>
						@if($item->final_cost)
							<span style="font-weight:bold">${{$item->final_cost}}</span>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>


	<div style="margin:20px">
		@unless($coupons->isEmpty())
		<div style="float:left">
			<strong>Applied Coupons:</strong>
			@foreach($coupons as $c)
				{{$c->coupon->name}} ({{$c->coupon->discountString()}})
			@endforeach
		</div>
		@endunless

		<div style="float:right">
			<strong>Total Cost:</strong>
			{{$items->totalCost()}}
		</div>
	</div>
	<div style="clear:both"></div>


	<hr style="width:100%" />

	<div style="padding:20px 0">
		<h3>Billing Information</h3>

		<table class="itemlist">
			<col width="75px" />
			<col width="325px" />
			<tr>
				<td class="label">Name:</td>
				<td class="content">
					{{$user->display_name}}<br />
					({{$user->email}})
				</td>
			</tr>
			<tr>
				<td class="label">Address:</td>
				<td class="content">
					{{$user->address}}<br />
					@if(isset($user->address2)){{$user->address2}}<br />@endif
					{{$user->city}}, {{$user->state}} {{$user->zipcode}}
				</td>
			</tr>
			@if($billing)
			<tr>
				<td class="label">Card:</td>
				<td class="content">{{$billing->type}}</td>
			</tr>
			<tr>
				<td class="label">Number:</td>
				<td class="content">xxxxxxxxxxxx{{$billing->last4}}</td>
			</tr>
			<tr>
				<td class="label">Expires:</td>
				<td class="content">{{$billing->exp_month}} / {{$billing->exp_year}}</td>
			</tr>
			@endif
		</table>
	</div>
@stop
