<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pernyataan Keterlambatan</title>
    <style>
        #back-wrap {
            margin: 30px auto 0 auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }
        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }
        #receipt {
            box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
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
        #top {
            margin-top: 25px;
        }
        #top .info {
            text-align: left;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #eee;
        }
        .tabletitle {
            font-size: .5rem;
            background: #eee;
        }
        .service {
            border-bottom: 1px solid #eee;
        }
        .itemtext {
            font-size: .7rem;
        }
        #legalcopy {
            margin-top: 15px;
        }

        .btn-print {
            float: right;
            color: #333;
        }
        .atas {
            display: flex;
        }
        .siswa {
            margin-left: 35px;
        }
        .ps {
            margin-left: 35px;
        }
        .ortu {
            margin-left: 30%;
        }
        .kesiswaan {
            margin-left: 30%;
        }
        .bbawah {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="back-wrap">
        <a href="{{ route('late.rekapitulasi') }}" class="btn-back">Kembali</a>
        <a href="{{ route('late.download', ['id' => $lates->id]) }}" class="btn-print" onclick="setTanggal()">Cetak (.pdf)</a>
    </div>

    <div id="receipt">
        <center>
            <div class="info">
                <h2>SURAT PERNYATAAN <br> TIDAK AKAN DATANG TERLAMPAT KESEKOLAH</h2>
            </div>
        </center>
        <br>
        <div class="text">
            <p>Yang bertanda tangan di bawah ini :</p>
            <div id="mid">
                <div class="info">
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
                </div>
            </div>
            
        </div>
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
    <script src="{{ asset('js/tanggal.js') }}"></script>
</body>
</html>