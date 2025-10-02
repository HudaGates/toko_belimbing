<!--CONTENT INIT -->
<tr>

    <td align="left" style=" font-size:0px;padding:10px 25px;word-break:break-word;">

        <div
            style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
            Purchase Order
        </div>

    </td>
</tr>
<tr>
    <td align="left" style="font-size:0px;padding:10px 25px 0px;word-break:break-word;">
        <div
            style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:14px;line-height:22px;text-align:left;color:#525252;">
            <p>Dear, <br>
                <b><?= $supplier_name ?></b> <br>
                <?= $supplier_address ?>
            </p>

        </div>
    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:5px 25px;word-break:break-word;">
        <div
            style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:14px;line-height:22px;text-align:left;color:#525252;">
            <p>
                Dengan email ini kami kirimkan Nomor PO YOSKA :
            </p>

            <h6 style="font-size: 16px; margin: 8px; font-weight: bold;"><?= $po_no ?></h6>

            <p>
                Berdasarkan nomor PO diatas kami mengajukan pemesanan barang untuk keperluan operasional.
                Untuk rincian barang yang kami pesan, dapat dilihat pada tombol portal dibawah ini:
            </p>

        </div>

    </td>
</tr>

<tr>
    <td align="center"
        style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:50px;word-break:break-word;">

        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
            style="border-collapse:separate;line-height:100%;">
            <tr>
                <td align="center" bgcolor="#2F67F6" role="presentation"
                    style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
                    <p
                        style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                        <a href="<?= $link ?>" style="color:#fff; text-decoration:none">
                            Open Portal
                        </a>
                    </p>
                </td>
            </tr>
        </table>

    </td>
</tr>

<tr>
    <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">

        <div
            style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:12px;line-height:16px;text-align:left;color:#a2a2a2;">
            Catatan:
            <ul>
                <li>
                    Harap PO dibubuhkan sign dan stamp, lalu kirimkan kembali kepada kami sebagai bukti konfirmasi.
                </li>
                <li>
                    Pada saat pengiriman harus melampirkan copy P.O.
                </li>
                <li>
                    Waktu penerimaan barang, Senin – Jum’at (Pukul 09:00 – 15:00)
                </li>
            </ul>
        </div>

    </td>
</tr>
<!--CONTENT END -->