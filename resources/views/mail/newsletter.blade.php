<!DOCTYPE html>
<html lang="en">

<head>
    <title>Newsletter</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #eeeeee;
        }

        @media screen and (max-width: 480px) {
            .mobile-padding {
                padding: 20px 15px !important;
            }

            .mobile-stack {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .mobile-label {
                padding: 15px 15px 5px 15px !important;
            }

            .mobile-value {
                padding: 0px 15px 15px 15px !important;
            }

            h1 {
                font-size: 24px !important;
            }
        }
    </style>
</head>

<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #eeeeee; padding: 40px 10px;" bgcolor="#eeeeee">

                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width:600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Header Section -->
                    <tr>
                        <td align="center" valign="top" style="padding: 35px 20px; background-color: #F44336;"
                            bgcolor="#F44336">
                            <h1
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 25px; font-weight: 800; margin: 0; color: #ffffff;">
                                Newsletter
                            </h1>
                        </td>
                    </tr>

                    <!-- Body Section -->
                    <tr>
                        <td align="left" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff"
                            class="mobile-padding">

                            <!-- Dynamic Mail Message Inserted Here -->
                            <div
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; color: #333333;">
                                {!! $mailMessage !!}
                            </div>

                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td align="center"
                            style="padding: 20px; background-color: #fafafa; border-top: 1px solid #eeeeee;"
                            bgcolor="#fafafa">
                            <p
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 20px; color: #999999; margin: 0;">
                                You are receiving this email because you are subscribed to our newsletter.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>
