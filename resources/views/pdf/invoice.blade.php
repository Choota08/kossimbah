<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Booking Kos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #000;
            padding: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            width: 40%;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>STRUK BOOKING KOS</h2>

    <div class="box">
        <table>
            <tr>
                <td class="label">Nama User</td>
                <td>: {{ $booking->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>: {{ $booking->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Nama Kos</td>
                <td>: {{ $booking->kos->name }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Kos</td>
                <td>: {{ $booking->kos->address }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Mulai Sewa</td>
                <td>: {{ $booking->start_date }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Selesai Sewa</td>
                <td>: {{ $booking->end_date }}</td>
            </tr>
            <tr>
                <td class="label">Harga / Bulan</td>
                <td>
                    : Rp {{ number_format($booking->kos->price_per_month, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="label">Status Booking</td>
                <td>: {{ strtoupper($booking->status) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
