<!DOCTYPE html>
<html
    lang="en"
    xmlns="http://www.w3.org/1999/xhtml"
    xmlns:o="urn:schemas-microsoft-com:office:office"
>
​
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <title></title>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border: none;
            margin: 0;
        }
        div,
        td {
            padding: 0;
        }
        div {
            margin: 0 !important;
        }
    </style>
    {{-- <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript> --}}
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Trebuchet MS;
            margin: 0;
            padding: 0;
        }
        .bordered {
            border-collapse: separate !important;
            border-spacing: 0;
            border: solid #ccc 1px;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
        }
        .bordered td {
            border-top: 1px solid #ccc;
            /* padding: 10px; */
            text-align: left;
        }
        .bordered td {
            border-left: none;
        }
        .bordered tr:first-child td {
            border-top: none;
        }
        .bordered tr:last-child td:first-child {
            -moz-border-radius: 0 0 0 6px;
            -webkit-border-radius: 0 0 0 6px;
            border-radius: 0 0 0 6px;
        }
        .bordered tr:last-child td:last-child {
            -moz-border-radius: 0 0 6px 0;
            -webkit-border-radius: 0 0 6px 0;
            border-radius: 0 0 6px 0;
        }
        a {
            color: #0363ed;
        }
    </style>
</head>
​
<body
    style="
        margin: 0;
        padding: 0;
        word-spacing: normal;
        background-color: #F3F3F7;
    "
>
    <div
        role="article"
        aria-roledescription="email"
        lang="en"
        style="
            text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background-color: #F3F3F7;
        "
    >
        <table
            role="presentation"
            style="
                width: 100%;
                border: none;
                border-spacing: 0
            "
        >
            <tr>
                <td align="center" style="padding: 0">
                    <table
                        role="presentation"
                        align="center"
                        style="width:600px;"
                    >
                        <tr>
                            <td>
                                <table
                                    role="presentation"
                                    style="
                                        width: 94%;
                                        max-width: 592.5px;
                                        border: none;
                                        border-spacing: 0;
                                        text-align: left;
                                        font-size: 16px;
                                        line-height: 22px;
                                        color: #363636;
                                        background-color: #ffffff;
                                        box-shadow: 0px 3px 5px rgba(218, 219, 231, 0.2), 0px 1px 18px rgba(218, 219, 231, 0.12), 0px 6px 10px rgba(218, 219, 231, 0.8);
​
                                    "
                                >
                                    <tr>
                                        <td
                                            style="
                                            padding: 18px 26px 0;
                                            text-align: center;
                                            font-size: 24px;
                                            font-weight: bold;
                                        "
                                        >
                                          <img  width="60" height="60" src="{{ $message->embed(public_path().'/logo/luggage.png') }}">
                                          {{-- <h4 style="
                                          color: #02577A; display: inline;margin-left: 10px;  
                                          font-size: 2rem;"
                                          >Luggage</h4> --}}
                                        </td>
                                    </tr>

                                    

                                    @yield('content')

                                    <tr>
                                        <td
                                            style="
                                                text-align: center;
                                                font-style: normal;
                                                font-weight: normal;
                                                font-size: 12px;
                                                color: #8386af;
                                            "
                                        >
                                        
                                        {{ __('messages.footer1') }}
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td
                                            style="
                                                padding: 6px 36px 20px;
                                                text-align: center;
                                                font-style: normal;
                                                font-weight: normal;
                                                font-size: 12px;
                                                line-height: 19px;
                                                color: #8386af;
                                            "
                                        >
                                        {{ now()->year }} {{ __('messages.footer2') }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
​
</html>