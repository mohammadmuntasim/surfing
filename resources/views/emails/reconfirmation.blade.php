<style type="text/css">
  body {
  padding: 0;
  margin: 0;
  }
  html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
  @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) { 
  *[class="table_width_100"] {
  width: 96% !important;
  }
  *[class="border-right_mob"] {
  border-right: 1px solid #dddddd;
  }
  *[class="mob_100"] {
  width: 100% !important;
  }
  *[class="mob_center"] {
  text-align: center !important;
  }
  *[class="mob_center_bl"] {
  float: none !important;
  display: block !important;
  margin: 0px auto;
  }	
  .iage_footer a {
  text-decoration: none;
  color: #929ca8;
  }
  img.mob_display_none {
  width: 0px !important;
  height: 0px !important;
  display: none !important;
  }
  img.mob_width_50 {
  width: 40% !important;
  height: auto !important;
  }
  }
  .table_width_100 {
  width: 680px;
  }
</style>
<div id="mailsub" class="notification" align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">
    <tr>
      <td align="center" bgcolor="#eff3f8">
        <!--[if gte mso 10]>
        <table width="680" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <![endif]-->
              <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
                <tr>
                  <td>
                    <!-- padding -->
                    <div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>
                  </td>
                </tr>
                <!--header -->
                <tr>
                  <td align="center" bgcolor="#3d88ed">
                    <!-- padding -->
                    <div style="height: 10px; line-height: 10px; font-size: 10px;"> </div>
                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left">
                          <!-- 
                            Item -->
                          <div class="mob_center_bl" style=" display: inline-block; text-align:center;width:100%;">
                            <table class="mob_center" width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;">
                              <tr>
                                <td align="left" valign="middle">
                                  <!-- padding -->
                                  <div style="height: 10px; line-height: 10px; font-size: 10px;"> </div>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                      <td align="center" valign="top" class="mob_center">
                                        <center style="width: 250px;display: inline-block;">
                                          <a href="{{url('/')}}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;width: 100%;
                                            float: left;">
                                          <img src="{{url('/')}}/storage/{{Voyager::setting('email_logo')}}" width="auto" height="auto" alt="Surf Health" border="0" /></a>
                                        </center>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <!-- Item END--><!--[if gte mso 10]>
                        </td>
                        <td align="right">
                          <![endif]--><!-- Item END-->
                        </td>
                      </tr>
                    </table>
                    <!-- padding -->
                   
                  </td>
                </tr>
                <!--header END-->
                <!--content 1 START-->
                <tr>
                 <td align="center" bgcolor="#fbfcfd" style="    border-bottom: 3px solid #3d88ed;">
                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td align="justify">
                            <!-- padding -->
                            <div style="height: 40px; line-height: 40px; font-size: 10px;">&nbsp;</div>
                            <div style="line-height: 44px;">
                              <font face="Arial, Helvetica, sans-serif" size="5" color="#57697e" style="font-size: 14px;">
                              <span style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                              Dear {{ $name }},
                              </span></font>
                            </div>
                            <!-- padding -->
                           
                          </td>
                        </tr>
                        <tr>
                          <td align="justify">
                            <div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
Please click the link below to activate your account:</div>
<div style="height: 40px; line-height: 40px; font-size: 10px;">&nbsp;</div>
                            <div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">                             
<a href="{{url('/user/confirmation')}}/{{$token}}" style="padding: 10px 20px 10px 20px;    background-color: #f99104;border-radius: 3px;    text-decoration: none;font-size: 18px; font-weight: 400;color:#fff;">Click here to activate your account</a>
                            </div>
                            <!-- padding -->
                            <div style="height: 40px; line-height: 40px; font-size: 10px;">&nbsp;</div>
                          </td>
                        </tr>
                        <tr style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">

                                    <td  style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0;padding:0 0 20px" valign="top"> Regards, <br>
                                        Surf Health Team </td>
                                </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <!--content 1 END -->
                <tr>
                  <td>
                    <!-- padding -->
                    <div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>
                  </td>
                </tr>
              </table>
              <!--[if gte mso 10]>
            </td>
          </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
  </table>
</div>
<br>
<br>
<center>
  <strong>Powered by <a href="{{url('/')}}" target="_blank">Surf Health</a></strong>
</center>
<br>
<br>