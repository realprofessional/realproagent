<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Email Template</title>
    </head>
    <body>
        <div style="background-color: #E9EDF1; text-align:center;
             width: 100%; padding:50px 0;">
            <table width="100%" align="center" style=" padding: 0 50px 10px; text-align:left;  table-layout:fixed; font-family:Arial, Helvetica, sans-serif;background-color: #FFFFFF;
                   border: 1px solid #DDDDDD;  ">

                <tr>
                    <td valign="top">
                        <!-- Begin Header -->
                        <table width="100%" style="  border-bottom: 1px solid #EEEEEE; text-align: left; padding-top: 10px; ">
                            <!--#F76F24-->
                            <tr>
                                <td>
                                </td>
                            </tr>
                        </table>
                        <!-- End Header -->
                    </td>
                </tr>


                <tr>
                    <td valign="top">
                        <!-- Begin Middle Content -->
                        <table width="100%">
                            <tr>
                                <td valign="top" style="color: #000;font-size: 13px;padding: 10px 0 0;word-wrap: break-word;">
                                    <?php
                                    if (isset($firstname) && !empty($firstname)) {
                                        echo "Dear " . $firstname . ',';
                                    }
                                    ?>

                                </td>
                            </tr>

                            <tr>
                                <td valign="top" style="color: #000;font-size: 13px;padding: 10px 0 0;word-wrap: break-word;">
                                    There is a new reminder on following Project Task.
                                    Click on link to view it on your dashboard:

                                    <?php echo $link; ?>

                                </td>
                            </tr>


                            <tr>
                                <td valign="top" style="color: #000;font-size: 13px;padding: 10px 0 0;word-wrap: break-word;">
                                    <p> Message: </p>
                                    <?php
                                    if (isset($text) && !empty($text)) {
                                        echo $text;
                                    }
                                    ?>
                                </td>
                            </tr>


                            <tr>
                                <td valign="top" style="color: #000;font-size: 13px;padding: 10px 0 0;word-wrap: break-word;">
                                    <p> Best Regards: </p>
                                    Juan Gabriel <br>
                                    Century 21 Troop <br>
                                    www.juangabrielrealestate.com <br>
                                    BRE #01476399 <br>
                                    805-602-8728 <br>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size:12px;color:#000; line-height:18px;">
                                    <p style="margin:10px 0 0;">If you need any assistance, please submit an inquiry in the support tab or email us at <a href="mailto:info@realproagent.com" style="color:#000; text-decoration: underline;">info@realproagent.com</a>.</p>
                                    <!--<p style="margin:10px 0 0;">Have Fun at <?php echo SITE_TITLE; ?> !!</p>-->

                                </td>
                            </tr>
                        </table>
                        <!-- End Middle Content --> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- Begin Footer Notifications -->
                        <table width="100%" style="border-top:1px solid #ddd; text-align: center;">
                            <tr>
                                <td style="font-size:11px; line-height:18px;">
                                    <a style="margin-left:0px; display: inline-block; padding-top: 15px;" href="<?php echo HTTP_PATH; ?>">
                                        <img src="{{ URL::asset('public/img/front') }}/logo.png" alt="<?php echo SITE_TITLE; ?>" title="<?php echo SITE_TITLE; ?>" />
                                    </a>
                                </td>

                            </tr>
                        </table>
                        <!-- End Footer Notifications -->
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <!-- Begin Footer -->
                        <table width="100%" style="border-top:1px solid #ddd; background-color:#242424;">
                            <!--#F76F24-->

                        </table>
                        <!-- End Footer -->
                    </td>
                </tr>
            </table>

           




        </div>
    </body>
</html>
<?php
//exit; ?>