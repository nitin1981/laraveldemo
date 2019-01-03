@include('emails.livery.html-header')
<p style="border-bottom: 1px solid #e0dada;"><img src="https://www.merrchant.com/public/homeasset/img/Logo_Merrchant.png"></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi {{ $data['real_name'] }},</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Click on below link to reset your password</p>
<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
  <tbody>
    <tr>
      <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
          <tbody>
            <tr>
              <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: rgb(140, 88, 173); border-radius: 5px; text-align: center;"><a href="{{ $link = url('password/resets',$data['token'])}}" target="_blank" style="display: inline-block; color: #ffffff; background-color: rgb(140, 88, 173); border: solid 1px #fff; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #fff;">Reset Password</a></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Good luck!</p>
@include('emails.livery.html-footer')