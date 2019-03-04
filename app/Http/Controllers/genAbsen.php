<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class genAbsen extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $kelas = $request->get("kelas");
        $tanggal = $request->get("tanggal");
        if($request->get("kelas") && $request->get("tanggal") != "" ) { 
        $request->session()->put('kelas',$request->get("kelas"));
        $request->session()->put('tanggal',$request->get("tanggal"));
        }
      
        $n = DB::table('KunciKelas')->where('kelas',session('kelas') )->value('n_key');
        $relativePrime = DB::table('KunciKelas')->where('kelas',session('kelas') )->value('rp_key');
        $d = DB::table('KunciKelas')->where('kelas',session('kelas')  )->value('d_key');

       
    
        $k = 1;
        $checkD = 1;
        // $a = 47;
        // $b = 71;
        // $relativePrime = 79;
        // $n = $a * $b;
        // $phiN = ($a-1)*($b-1);

        // while(bcmod($checkD,$relativePrime) != 0  ) {
        //     $k++; 
        //     $checkD = (1 + (bcmul($k,$phiN)));
        // }
        // $d = $checkD/$relativePrime;
        // echo $d."</br>";
        $plain = "success";
        $plainChar = str_split($plain);
        for($counter = 0 ; $counter < sizeof($plainChar) ; $counter++){
            $decPlain[$counter] = ord($plainChar[$counter]);    

        }

        for($counter = 0 ; $counter < sizeof($decPlain) ; $counter++){
            $cipher[$counter] = bcpowmod($decPlain[$counter],$relativePrime,$n);    
        

        }
        for($counter = 0 ; $counter < sizeof($decPlain) ; $counter++){
            $deCipher[$counter] = bcpowmod($cipher[$counter],$d,$n);    
        

        }

        $sess = md5(date("h:i:sa"));
        $cipher = implode(" ",$cipher);
        $plainDec = implode(" ",$decPlain);
        $qrString = '{"chal":"'.$cipher.'","sess":"'.$sess.'","hash":"'.md5($plainDec).'"}';
        $qrCode = new QrCode($qrString);
        $qrCode->setSize(500);
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setLogoSize(500, 400);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);
        $qrCode->writeFile('../public/qrCode'.'/'.$request->get("kelas").'.png');
        $qrData = $request->get("kelas");
        $request->session()->put('qrCode',$qrData);

        DB::table('absenSess')->updateOrInsert(
            ['kelas' => session('kelas'), 'tanggal' => session('tanggal')],
            ['sess' => $sess ]
        );
        return view('generatedQR',compact('qrData'));

    }
    private function primenumb($i)
    {
        $counter = 0; 
            for($j=1;$j<=$i;$j++){ 
                if($i % $j==0){ 
                    $counter++;
                    }
                }
                if($counter==2){
                    return true;
                  }
                else{
                    return false;
                  }
          } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
