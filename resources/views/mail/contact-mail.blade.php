<!DOCTYPE html>
<html>

<head>
    <title>New Contact Message</title>
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

        /* Mobile styling */
        @media screen and (max-width: 480px) {
            .mobile-padding {
                padding: 20px 15px !important;
            }

            /* Stacks the table columns vertically on mobile */
            .mobile-stack {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            /* Adjusts padding when stacked */
            .mobile-label {
                padding: 15px 15px 5px 15px !important;
            }

            .mobile-value {
                padding: 0px 15px 15px 15px !important;
            }

            /* Scales down the main header text slightly */
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

                    <tr>
                        <td align="center" valign="top" style="padding: 35px 20px; background-color: #F44336;"
                            bgcolor="#F44336">
                            <h1
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 25px; font-weight: 800; margin: 0; color: #ffffff;">
                                New Contact Message
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff"
                            class="mobile-padding">

                            <p
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; margin-top: 0; color: #333333;">
                                Hello Admin,</p>
                            <p
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; color: #777777; margin-bottom: 30px;">
                                You have received a new inquiry from your website's contact form. Here are the Details.
                            </p>

                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="background-color: #eeeeee; border-radius: 4px;">
                                <tr>
                                    <td class="mobile-stack mobile-label" width="35%" align="left" valign="top"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px;">
                                        Sender Name :-
                                    </td>
                                    <td class="mobile-stack mobile-value" width="65%" align="left" valign="top"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px;">
                                        {{ $name }}
                                    </td>
                                </tr>
                            </table>

                            <h3
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 800; color: #333333; margin: 30px 0 10px 0;">
                                Message :-
                            </h3>
                            <div
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; background-color: #f9f9f9; border-left: 4px solid #F44336; padding: 20px; color: #555555; font-style: italic;">
                                {{ $content }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding: 20px; background-color: #fafafa; border-top: 1px solid #eeeeee;"
                            bgcolor="#fafafa">
                            <p
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 20px; color: #999999; margin: 0;">
                                This is an automated email generated from the website contact form.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>
