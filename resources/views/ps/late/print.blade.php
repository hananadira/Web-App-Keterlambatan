<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pernyataan Keterlambatan</title>
    <style>
        .info {
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 500px;
            background: #fff;
        }
        h2 {
            font-size: .9rem;
        }
        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #eee;
        }
        .btn-print {
            float: right;
            color: #333;
        }
        .atas {
            display: flex;
        }
        .ortu {
            margin-left: 30%;
        }
        .kesiswaan {
            margin-left: 30%;
        }
        .siswa {
            margin-left: 8%;
        }
        .ps {
            margin-left: 8%;
        }
        .bbawah {
            display: flex;
        }
    </style>
</head>
<body>
        <a href="{{ route('ps.late.rekapitulasi') }}" class="btn-back">Kembali</a>
        <a href="{{ route('ps.late.download.ps', ['id' => $lates->id]) }}" class="btn-print" onclick="setTanggal()">Cetak (.pdf)</a>  

    <div class="info">
        <center>
            <h2>SURAT PERNYATAAN <br> TIDAK AKAN DATANG TERLAMPAT KESEKOLAH</h2>
        </center>
        <br>
            <p>Yang bertanda tangan di bawah ini :</p>
                    @if($lates instanceof \Illuminate\Database\Eloquent\Collection)
                        @foreach($lates as $late)
                        <p>
                            NIS     : {{ $late->student->nis }} <br>
                            Nama    : {{ $late->student->name }} <br>
                            Rombel  : {{ json_decode($late->student->rombel)->rombel ?? 'N/A' }} <br>
                            Rayon   : {{ json_decode($late->student->rayon)->rayon ?? 'N/A' }} 
                        </p>
                        <br>
                        @endforeach
                    @else
                        <p>
                            NIS     : {{ $lates->student->nis }} <br>
                            Nama    : {{ $lates->student->name }} <br>
                            Rombel  : {{ json_decode($lates->student->rombel)->rombel ?? 'N/A' }} <br>
                            Rayon   : {{ json_decode($lates->student->rayon)->rayon ?? 'N/A' }} 
                        </p>
                        <br>
                        <p>
                            Dengan ini menyatakan bahwa saya telah melakukan pelanggaran tata tertib sekolah, yaitu terlambat datang ke sekolah sebanyak {{ DB::table('lates')->where('name_id', $lates['student']['id'])->count() }} yang mana hal tersebut termasuk kedalam pelanggaran kedisiplinan. Saya berjanji tidak akan terlambat datang ke sekolah lagi. Apabila saya terlambat datang ke sekolah lagi saya siap diberikan sanksi yang sesuai dengan peraturan sekolah.
                        </p>
                        <br>
                        <p>Demikian surat pernyataan terlambat ini saya buat dengan penuh penyesalan.</p>
                    @endif
        <br>
        <div class="ttd">
            <p style="margin-left: 55%;" id="tanggalDiv">Bogor, </p>
            <div class="atas">
                <div class="siswa">
                    <p>Peserta Didik, </p>
                    <br><br>
                    <p>({{ $lates->student->nis }})</p>
                </div>
                <div class="ortu">
                    <p>Orang Tua/Wali Peserta Didik</p>
                    <br><br>
                    <p style="margin-left: 25%;">(....................)</p>
                </div>
            </div>
            <div class="bbawah">
                <div class="ps">
                    <p>Pembimbing Siswa, </p>
                    <br><br>
                    <p>({{ $lates->student->rayon->user->name }})</p>
                </div>
                <div class="kesiswaan">
                    <p>Kesiswaan, </p>
                    <br><br>
                    <p>(....................)</p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/tanggal.js') }}"></script>
</html>