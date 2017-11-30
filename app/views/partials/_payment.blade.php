<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Payment Details</h3>
	</div>
	<div class="panel-body">
		<ul>
			<li>
				<strong>Date</strong>
				{{$payment->date->format("m/d/Y")}}
			</li>

			@if(!isset($hide_user) || $hide_user === FALSE)
				<li>
					<strong>User</strong>
					{{link_to_route('profile', $payment->owner->display_name, $payment->owner->username)}}
				</li>
			@endif

			<li>
				<strong>Total</strong>
				${{$payment->total}}
			</li>
		</ul>
	</div>
</div>

<!-- BILLING DETAILS -->
@if(isset($billing->card))
	<div class="divider"></div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Billing Details</h3>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>Card Type</th>
					<th>Card Number</th>
					<th>Expires</th>
					<th>Amount Charged</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$billing->card->type}}</td>
					<td>
						xxxxxxxxxxxx{{$billing->card->last4}}
					</td>
					<td>
						{{$billing->card->exp_month}}/{{$billing->card->exp_year}}
					</td>
					<td>
						${{number_format($billing->amount / 100, 2)}}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif
