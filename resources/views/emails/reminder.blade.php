<html>

<body
    style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table
        style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:left;"><img style="max-width: 150px;"
                        src="{{ asset('/frontend/images/fonterra.jpg') }}" alt="SDS Fonterra"></th>
                <th style="text-align:right;font-weight:400;">{{ Carbon\Carbon::now()->toDateTimeString() }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:150px">MSDS
                            {{ $details->chemical_common_name }} <b>{{ $details->cas_number }}</b> will expired in {{ $day }}
                            days at
                            {{ $details->expired_date }}</span>
                    </p><br>
                    <p style="font-size:14px;margin:0 0 6px 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Chemical Common Name</span>
                        {{ $details->chemical_common_name }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">CAS Number</span>
                        {{ $details->cas_number }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Trade Name</span>
                        {{ $details->trade_name }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Chemical Supplier</span>
                        {{ $details->chemical_supplier }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Chemical Location</span>
                        {{ $details->location_of_chemical }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Issued Date</span>
                        {{ $details->sds_issue_date }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Expired Date</span>
                        {{ $details->expired_date }}</p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Document</span>
                        <a href="{{ asset('dokumen/') . '/' . $details->path_pdf }}" target="_blank">Download Dokmen</a>
                    </p>
                </td>
            </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                    <strong style="display:block;margin:0 0 10px 0;">Regards</strong> Admin MSDS<br> PT Fonterra Brands
                    Manufacturing Indonesia<br> Kawasan Terpadu Indonesia China<br><br>
                    <b>Mobile Phone:</b> 0813 1913 1973<br>
                    <b>Email:</b> AlifRidho.Utama@fonterra.com
                </td>
            </tr>
        </tfooter>
    </table>
</body>

</html>
