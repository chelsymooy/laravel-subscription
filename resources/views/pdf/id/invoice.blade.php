<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{$bill->no}} </title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.top table td.subtitle {
        padding-top: 8px;
        font-size: 20px;
        line-height: 20px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td class="title">
                              {{$bill->details['issuer_name']}}
                            </td>
                            
                            <td class="subtitle">
                                INVOICE <br/><small>#{{$bill->no}}</small>
                            </td>
                        </tr>
                    </table>
                    <hr style="height:.5px;border-width:0;color:#bbb;background-color:#bbb">
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td>
                              {{$bill->details['customer_name']}}<br/>
                              {{$bill->details['customer_address']}}<br/>
                              {{$bill->details['customer_phone']}}
                            </td>
                            
                            <td>
                                <strong>Dikeluarkan Tanggal:</strong> {{$bill->issued_at->format('M, d Y')}}<br/>
                                @if($bill->paid_at)
                                  <strong>Dibayar Tanggal:</strong> {{$bill->paid_at->format('M, d Y')}}
                                @else
                                  <strong>Belum Dibayar</strong>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Deskripsi
                </td>
                
                <td class="text-center" colspan="2">
                    Jumlah
                </td>
                
                <td class="text-right">
                    Harga @
                </td>
                
                <td class="text-right">
                    Diskon @
                </td>
                
                <td class="text-right">
                    Total
                </td>
            </tr>
            
            @foreach($bill->lines as $v)
            <tr class="details">
                <td>
                    {{$v['item']}}
                </td>
                
                <td class="text-right">
                    {{number_format($v['qty'], 0, '.', ',')}}
                </td>

                <td class="text-left">
                    {{$v['unit']}}
                </td>

                <td class="text-right">
                    Rp {{number_format($v['price'], 0, '.', ',')}}
                </td>

                <td class="text-right">
                    Rp {{number_format($v['discount'], 0, '.', ',')}}
                </td>
                <td class="text-right">
                    Rp {{number_format($v['qty'] * ($v['price'] - $v['discount']), 0, '.', ',')}}
                </td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td colspan="5"></td>
                <td class="text-right">
                   Rp {{ number_format($bill->total, 0, '.', ',') }}
                </td>
            </tr>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td style="font-size: 14px; line-height: 21px;">
                              <strong>Catatan:</strong>
                              <ol>
                                <li>Jatuh tempo pembayaran {{$bill->due_at->format('d/m/Y')}}</li>
                                <li>Setelah jatuh tempo pembayaran, Anda akan dikenakan denda sebesar Rp {{number_format($bill->details['penalty_rate'], 0, '.', ',')}} setiap {{$bill->details['penalty_period_val']}} {{$bill->details['penalty_period_opt']}}(s) atas tagihan ini.</li>
                              </ol>
                            </td>
                            
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="6" class="text-center">
                  <h5>Rekening Pembayaran :<br/> 
                    <strong>{{ $bill->details['bank_name'] }} {{$bill->details['account_no']}}</strong> ({{$bill->details['account_name']}}) 
                  </h5>
                  <h4><strong><i>Thank you!</i></strong></h4>
                </td>
            </tr>

            <tr class="information">
                <td colspan="6" class="text-center">
                  <hr style="height:.5px;border-width:0;color:#bbb;background-color:#bbb">
                  <h6 class="text-center">{{$bill->details['issuer_address']}} <br/>Phone {{$bill->details['issuer_phone']}}</h6>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
