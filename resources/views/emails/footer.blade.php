<div style="text-align: left !important; width: 200px; display: block;">
	<h3 style="margin-bottom: 0px;">{{ config()->get('subscription.issuer.issuer_name') }}</h3>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix" style="border-bottom: 1px solid #d8d8d8">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<table class="w-100 text-color font-small font-light" style="text-align: left !important;">
	<tbody>
		<tr>
			<td class="text-left">
				© {{ date_format('Y') }} {{ config()->get('subscription.issuer.issuer_name') }}  | {{ config()->get('subscription.issuer.issuer_web') }}
			</td>
		</tr>
		<tr>
			<td class="text-left">
				{!! config()->get('subscription.issuer.issuer_name') !!} | {!! config()->get('subscription.issuer.issuer_address') !!}
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				For further information, feel free to contact our customer service via mail <strong><a name="email" style="color: inherit;">{{ config()->get('subscription.issuer.issuer_email') }}</a></strong> or WhatsApp (Chat Only) <strong>{!! config()->get('subscription.issuer.issuer_phone') !!}</strong>.
			</td>
		</tr>
	</tbody>
</table>