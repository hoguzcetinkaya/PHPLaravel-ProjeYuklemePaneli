<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Hocalar;
use App\Models\Fakulte;
use App\Models\Bolum;
use App\Models\Ogrenciler;
use App\Models\Kullanicilar;
use App\Models\ProjeOnerileri;
use App\Models\Rapor1;
use App\Models\Rapor2;
use App\Models\Rapor3;
use App\Models\TezOnerileri;

use Illuminate\Http\Request;

class SayfaKontrol extends Controller
{
    function __construct()//hiçbir fonksiyon çağrılmadan çalışan fonksiyon
    {
       // moduller tablosundaki durumu 1 olan değerleri paylaş
        //moduller değişkenine moduller tablosundaki durumu 1 olan değerleri tanımla ve viewe gönder
    }

    public function anasayfa()
    {
        return view("admin.dinamik.anasayfa");
    }
    public function sablon()
    {
        return view("admin.girisler.girisEkrani");
    }
    public function hocaEkle($seflink)
    {
        $admin=Kullanicilar::where("seflink",$seflink)->first();
        $bolumlerTeknoloji=Bolum::where("fakulte_id",1)->get();
        if($admin->gorev==1)
        {
            return view("admin.dinamik.hocaEkle",compact('bolumlerTeknoloji'));
        }
        else
        {
            return view("admin.dinamik.anasayfa");
        }

    }
    public function hocaEklePost(Request $request)
    {

        $request->validate([
            "adsoyad"=>'required',
            "unvan"=>'required',
            "email"=>'required'
        ]);
        $hocaAdsoyad=$request->adsoyad;
        $hocaSeflink=Str::of($hocaAdsoyad)->slug('');
        $hocaUnvan=$request->unvan;
        $hocaEmail=$request->email;
        $hocaKontrol=Hocalar::whereEmail($hocaEmail)->first(); //bu isimde hoca var mı kontrol
        if($hocaKontrol)
        {
            return redirect()->back()->with("hata","Sistemde kayıtlı hoca girmek istediniz !!"); // redirect yönlendirme
        }
        else
        {
            $bolumID=$request->bolum_id;
            if($bolumID==1 || $bolumID==2 || $bolumID==3 || $bolumID==4)
            {
                $fakulteID=1;
                Hocalar::create([
                    "adsoyad"=>$hocaAdsoyad,
                    "seflink"=>$hocaSeflink,
                    "unvan"=>$hocaUnvan,
                    "email"=>$hocaEmail,
                    "fakulte_id"=>$fakulteID,
                    "bolum_id"=>$request->bolum_id,
                ]);
                Kullanicilar::create([
                    "email"=>$hocaEmail,
                    "sifre"=>"oguz123",
                    "gorev"=>2
                ]);

            }

        return redirect()->back()->with("basarili","İşleminiz Başarılı");

        }
    }

    public function ogrenciEkle($seflink)
    {
            $hocalarTeknoloji=Hocalar::where("fakulte_id",1)->get();
            $bolumlerTeknoloji=Bolum::where("fakulte_id",1)->get();
            $admin=Kullanicilar::where("seflink",$seflink)->first();
            if($admin->gorev==1)
            {
                return view("admin.dinamik.ogrenciEkle",compact(['hocalarTeknoloji','bolumlerTeknoloji']));
            }
            else
            {
                return view("admin.dinamik.anasayfa");
            }


    }
    public static function ogrenciEklePost(Request $request)
    {

        $request->validate([
            "ogr_no"=>'required',
            "adSoyad"=>'required',
            "email"=>'required',
            "telefon"=>'required',
            "sinif"=>'required'
        ]);
        $resimDosyasi=$request->file('resim');
        $ogrenciKontrol=Ogrenciler::where("ogr_no",$request->ogr_no)->first(); //bu numaralı öğrenci var mı
        if($ogrenciKontrol)
        {
            return redirect()->back()->with("hata","Sistemde kayıtlı öğrenci girmek istediniz !!"); // redirect yönlendirme
        }
        else
        {
            if($resimDosyasi)
            {
                $bolumID=$request->bolum_id;
                $resim=$resimDosyasi->getClientOriginalName();
                $resimDosyasi->move(public_path("images/".$request->ogr_no),$resim);
                if($bolumID==1 || $bolumID==2 || $bolumID==3 || $bolumID==4)
                {
                    $HocaAdet=0;
                    $fakulteID=1;
                    $hocalarTeknoloji=Hocalar::where("fakulte_id",$fakulteID)->get();

                    foreach($hocalarTeknoloji as $hoca)
                    {
                        $HocaAdet++; // random komutu 0 ile sayaç arasında
                    }
                    $hoca=Hocalar::where("id",$request->hoca)->first();

                    if($hoca)
                    {
                        $hocaID=$hoca->id;
                        $hocaSAYAC=$hoca->sayac;
                        $hocaSAYAC++;
                        $ogrenciSeflink=Str::of($request->adSoyad)->slug('');
                        Ogrenciler::create([
                            "ogr_no"=>$request->ogr_no,
                            "adSoyad"=>$request->adSoyad,
                            "seflink"=>$ogrenciSeflink,
                            "email"=>$request->email,
                            "telefon"=>$request->telefon,
                            "sinif"=>$request->sinif,
                            "resim"=>$resim,
                            "hoca_id"=>$hocaID,
                            "fakulte_id"=>$fakulteID,
                            "bolum_id"=>$bolumID,
                        ]);
                        Hocalar::where("id",$hocaID)->update([
                            "sayac"=>$hocaSAYAC,
                        ]);
                        Kullanicilar::create([
                            "email"=>$request->email,
                            "gorev"=>3
                        ]);

                    }

                }

            }
            else
            {
                $bolumID=$request->bolum_id;

                if($bolumID==1 || $bolumID==2 || $bolumID==3 || $bolumID==4)
                {
                    $HocaAdet=0;
                    $fakulteID=1;
                    $hocalarTeknoloji=Hocalar::where("fakulte_id",$fakulteID)->get();

                    foreach($hocalarTeknoloji as $hoca)
                    {
                        $HocaAdet++; // random komutu 0 ile sayaç arasında
                    }
                    $hoca=Hocalar::where("id",$request->hoca)->first();

                    if($hoca)
                    {
                        $hocaID=$hoca->id;
                        $hocaSAYAC=$hoca->sayac;
                        $hocaSAYAC++;
                        $ogrenciSeflink=Str::of($request->adSoyad)->slug('');
                        Ogrenciler::create([
                            "ogr_no"=>$request->ogr_no,
                            "adSoyad"=>$request->adSoyad,
                            "seflink"=>$ogrenciSeflink,
                            "email"=>$request->email,
                            "telefon"=>$request->telefon,
                            "sinif"=>$request->sinif,
                            "hoca_id"=>$hocaID,
                            "fakulte_id"=>$fakulteID,
                            "bolum_id"=>$bolumID,
                        ]);
                        Hocalar::where("id",$hocaID)->update([
                            "sayac"=>$hocaSAYAC,
                        ]);
                        Kullanicilar::create([
                            "email"=>$request->email,
                            "gorev"=>3
                        ]);

                    }

                }
            }
                return redirect()->back()->with("basarili","İşleminiz Başarılı");
        }
    }
//HOCANIN ÖĞRENCİLERİNİ LİSTELEMESİ İÇİN GEREKLİ
    public function ogrenciListele($Seflink)
    {
        $admin=Kullanicilar::where("seflink",$Seflink)->first();


            if($admin->gorev==2)
            {$hocaID=Hocalar::where("seflink",$Seflink)->first();
                $hocaOgrenciler=Ogrenciler::where("hoca_id",$hocaID->id)->get();
                return view("admin.dinamik.liste",compact('hocaOgrenciler'));
            }
            else
            {
                return view("admin.dinamik.anasayfa");
            }

    }



//HOCA ÖĞRENCİLERİ LİSTELEDİĞİNDE PROJELERE TIKLAYINCA AÇILACAK SAYFA
    public function projeListele($Seflink,$ogrenciID)
    {
        $ogrenciProjeBilgiler=ProjeOnerileri::where("ogr_id",$ogrenciID)->get();
        return view("admin.dinamik.projeListesi",compact('ogrenciProjeBilgiler'));
    }

    //ÖĞRENCİNİN PROJE ÖNERİSİ YAPMASI İÇİN GEREKLİ KODLAR
    public function projeOnerisi($seflink)
    {

        return view("admin.dinamik.projeOneri");
    }
    public function projeOnerisiPost(Request $request,$seflink)
    {
        $ogrenci=Kullanicilar::where("seflink",$seflink)->first();
        $ogrenciEmail=$ogrenci->email;
        $ogrenciDetay=Ogrenciler::where("email",$ogrenciEmail)->first();
        $ogrenciID=$ogrenciDetay->id;
        $ogrenciHocaID=$ogrenciDetay->hoca_id;
        $request->validate([
            "baslik"=>'required',
            "konu"=>'required',
            "yontem"=>'required',
            "anahtar"=>'required',
        ]);

        $baslikSeflink=Str::of($request->baslik)->slug('');
        ProjeOnerileri::create([
            "baslik"=>$request->baslik,
            "seflink"=>$baslikSeflink,
            "konu"=>$request->konu,
            "yontem"=>$request->yontem,
            "anahtar"=>$request->anahtar,
            "ogr_id"=>$ogrenciID,
            "hoca_id"=>$ogrenciHocaID
        ]);


        return redirect()->route("projeOnerisi",$ogrenci->seflink)->with("basarili","İşleminiz Başarılı");
    }
    public function projeOnayRed($ogrenciID)
    {
        $ogrenciProje=ProjeOnerileri::where("ogr_id",$ogrenciID)->first();
        if($ogrenciProje->durum==1)
        {
            $durum=2;
        }
        else
        {
            $durum=1;
        }
        ProjeOnerileri::where("ogr_id",$ogrenciID)->update([
            "durum"=>$durum
        ]);
        return redirect()->back()->with("basarili","İşleminiz Başarılı");
    }
    //HOCA ÖĞRENCİLERİ LİSTELEDİĞİNDE RAPORLARA TIKLAYINCA AÇILACAK SAYFA
    public function rapor1Listele($Seflink,$ogrenciID)
    {

        $ogrenciRaporBilgiler=Rapor1::where("ogr_id",$ogrenciID)->first();
        return view("admin.dinamik.raporListesi",compact('ogrenciRaporBilgiler'));

    }
    public function rapor2Listele($Seflink,$ogrenciID)
    {

        $ogrenciRaporBilgiler2=Rapor2::where("ogr_id",$ogrenciID)->first();
        return view("admin.dinamik.raporListesi",compact('ogrenciRaporBilgiler2'));

    }
    public function rapor3Listele($Seflink,$ogrenciID)
    {

        $ogrenciRaporBilgiler3=Rapor3::where("ogr_id",$ogrenciID)->first();
        return view("admin.dinamik.raporListesi",compact('ogrenciRaporBilgiler3'));

    }
    public function rapor1OnayRed($ogrenciID)
    {
        $ogrenciRapor=Rapor1::where("ogr_id",$ogrenciID)->first();
        $ogrenciHoca=Hocalar::where("id",$ogrenciRapor->hoca_id)->first();
        if($ogrenciRapor->durum==2)
        {
            $durum=1;
        }
        else
        {
            $durum=2;
        }
        Rapor1::where("ogr_id",$ogrenciID)->update([
            "durum"=>$durum
        ]);
        return redirect()->back();
    }
    public function rapor2OnayRed($ogrenciID)
    {
        $ogrenciRapor=Rapor2::where("ogr_id",$ogrenciID)->first();
        $ogrenciHoca=Hocalar::where("id",$ogrenciRapor->hoca_id)->first();
        if($ogrenciRapor->durum==2)
        {
            $durum=1;
        }
        else
        {
            $durum=2;
        }
        Rapor2::where("ogr_id",$ogrenciID)->update([
            "durum"=>$durum
        ]);
        return redirect()->back();
    }
    public function rapor3OnayRed($ogrenciID)
    {
        $ogrenciRapor=Rapor3::where("ogr_id",$ogrenciID)->first();
        $ogrenciHoca=Hocalar::where("id",$ogrenciRapor->hoca_id)->first();
        if($ogrenciRapor->durum==2)
        {
            $durum=1;
        }
        else
        {
            $durum=2;
        }
        Rapor3::where("ogr_id",$ogrenciID)->update([
            "durum"=>$durum
        ]);
        return redirect()->back();
    }
    public function rapor1($seflink)
    {
        $admin=Kullanicilar::where("seflink",$seflink)->first();
        if($admin->gorev==1)
        {
          return redirect()->back();
        }
        elseif ($admin->gorev==2) {
                  return redirect()->back();
        }
        else {

          $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
          $ogrenciID=$ogrenci->id;
          $proje=ProjeOnerileri::where("ogr_id",$ogrenciID)->first();
          if($proje && $proje->durum==1)
          {

              return view("admin.dinamik.rapor1",compact('ogrenci'));


          }
          else
          {
              return redirect()->back();
          }
        }


    }
    public function rapor2($seflink)
    {
        $admin=Kullanicilar::where("seflink",$seflink)->first();
        if($admin->gorev==1)
        {
          return redirect()->back();
        }
        elseif ($admin->gorev==2) {
                  return redirect()->back();
        }
        else
        {
          $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
          $ogrenciID=$ogrenci->id;
          $proje=ProjeOnerileri::where("ogr_id",$ogrenciID)->first();
          $rapor1=Rapor1::where("ogr_id",$ogrenciID)->first();
          if($rapor1 && $rapor1->durum==1)
          {

                  return view("admin.dinamik.rapor2");

          }
          else
          {
              return view("admin.dinamik.anasayfa");
          }
        }



    }
    public function rapor3($seflink)
    {
      $admin=Kullanicilar::where("seflink",$seflink)->first();
      if($admin->gorev==1)
      {
        return redirect()->back();
      }
      elseif ($admin->gorev==2) {
                return redirect()->back();
      }
      else {
        $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
        $ogrenciID=$ogrenci->id;
        $proje=ProjeOnerileri::where("ogr_id",$ogrenciID)->first();
        $rapor1=Rapor1::where("ogr_id",$ogrenciID)->first();
        $rapor2=Rapor2::where("ogr_id",$ogrenciID)->first();
        if($rapor2 && $rapor2->durum==1)
        {

                return view("admin.dinamik.rapor3");

        }
        else
        {
            return view("admin.dinamik.anasayfa");
        }
      }



    }
    public function rapor1Post(Request $request,$seflink)
    {
        $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
        $proje=ProjeOnerileri::where("ogr_id",$ogrenci->id)->first();
        $request->validate([
            "dosya"=>'required'
        ]);
        $pdfDosyasi=$request->file('dosya');
        if($pdfDosyasi)
        {
            $pdf=$pdfDosyasi->getClientOriginalName();
            $pdfDosyasi->move(public_path("pdf/"),$pdf);
            Rapor1::create([
                "dosya"=>$pdf,
                "ogr_id"=>$ogrenci->id,
                "hoca_id"=>$ogrenci->hoca_id,
                "proje_id"=>$proje->id
            ]);
            return redirect()->back()->with("basarili","İşleminiz başarılı");
        }


    }
    public function rapor2Post(Request $request,$seflink)
    {
        $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
        $proje=ProjeOnerileri::where("ogr_id",$ogrenci->id)->first();
        $request->validate([
            "dosya"=>'required'
        ]);
        $pdfDosyasi=$request->file('dosya');
        if($pdfDosyasi)
        {
            $pdf=$pdfDosyasi->getClientOriginalName();
            $pdfDosyasi->move(public_path("pdf/"),$pdf);
            Rapor2::create([
                "dosya"=>$pdf,
                "ogr_id"=>$ogrenci->id,
                "hoca_id"=>$ogrenci->hoca_id,
                "proje_id"=>$proje->id
            ]);
            return redirect()->back()->with("basarili","İşleminiz başarılı");
        }


    }
    public function rapor3Post(Request $request,$seflink)
    {
        $ogrenci=Ogrenciler::where("seflink",$seflink)->first();
        $proje=ProjeOnerileri::where("ogr_id",$ogrenci->id)->first();
        $request->validate([
            "dosya"=>'required'
        ]);
        $pdfDosyasi=$request->file('dosya');
        if($pdfDosyasi)
        {
            $pdf=$pdfDosyasi->getClientOriginalName();
            $pdfDosyasi->move(public_path("pdf/"),$pdf);
            Rapor3::create([
                "dosya"=>$pdf,
                "ogr_id"=>$ogrenci->id,
                "hoca_id"=>$ogrenci->hoca_id,
                "proje_id"=>$proje->id
            ]);
            return redirect()->back()->with("basarili","İşleminiz başarılı");
        }


    }
    public function tezOnerisi($seflink)
    {
      $admin=Kullanicilar::where("seflink",$seflink)->first();
      if($admin->gorev==1)
      {
        return redirect()->back();
      }
      elseif ($admin->gorev==2) {
                return redirect()->back();
      }
      else {
        $ogrenci=Kullanicilar::where("seflink",$seflink)->first();
        $ogrenciEmail=$ogrenci->email;
        $ogrenciDetay=Ogrenciler::where("email",$ogrenciEmail)->first();
        $ogrenciID=$ogrenciDetay->id;
        $ogrenciHocaID=$ogrenciDetay->hoca_id;
        $rapor3=Rapor3::where("ogr_id",$ogrenciID)->first();
        if($rapor3 && $rapor3->durum==1)
        {
            return view("admin.dinamik.tezOneri");
        }
        else
        {
            return redirect()->back();
        }
      }


    }
    public function tezOnerisiPost(Request $request,$seflink)
    {
        $ogrenci=Kullanicilar::where("seflink",$seflink)->first();
        $ogrenciEmail=$ogrenci->email;
        $ogrenciDetay=Ogrenciler::where("email",$ogrenciEmail)->first();
        $ogrenciID=$ogrenciDetay->id;
        $ogrenciHocaID=$ogrenciDetay->hoca_id;
        $rapor3=Rapor3::where("ogr_id",$ogrenciID)->first();
        $request->validate([
            "baslik"=>'required',
            "konu"=>'required',
            "dosya1"=>'required',
            "dosya2"=>'required',
        ]);
        $baslikSeflink=Str::of($request->baslik)->slug('');
        $dosya1=$request->file('dosya1');
        $dosya2=$request->file('dosya2');
        $pdf=$dosya1->getClientOriginalName();
            $dosya1->move(public_path("pdf/"),$pdf);
            $word=$dosya2->getClientOriginalName();
            $dosya2->move(public_path("pdf/"),$word);
        if($rapor3->durum==1)
        {

            if($dosya1)
            {
                if($dosya2)
                {
                    TezOnerileri::create([
                        "baslik"=>$request->baslik,
                        "seflink"=>$baslikSeflink,
                        "konu"=>$request->konu,
                        "dosya1"=>$pdf,
                        "dosya2"=>$word,
                        "ogr_id"=>$ogrenciID,
                        "hoca_id"=>$ogrenciHocaID
                    ]);
                    return redirect()->back()->with("basarili","İşleminiz başarılı");
                }
                else
                {
                    return redirect()->back()->with("hata","Yüklemek istediğiniz 2. dosya bulunamadı tekrar deneyiniz");
                }

            }
            else
            {
                return redirect()->back()->with("hata","Yüklemek istediğiniz 1. dosya bulunamadı tekrar deneyiniz");
            }


        }
        else
        {
            return redirect()->back()->with("hata","Raporlarınız tümü onaylı değildir");
        }

    }
    public function tezListele($Seflink,$ogrenciID)
    {

        $ogrenciTezler=TezOnerileri::where("ogr_id",$ogrenciID)->first();
        return view("admin.dinamik.tezListe",compact('ogrenciTezler'));

    }
    public function tezOnayRed($ogrenciID)
    {
        $ogrenciTez=TezOnerileri::where("ogr_id",$ogrenciID)->first();
        $ogrenciHoca=Hocalar::where("id",$ogrenciTez->hoca_id)->first();
        if($ogrenciTez->durum==2)
        {
            $durum=1;
        }
        else
        {
            $durum=2;
        }
        TezOnerileri::where("ogr_id",$ogrenciID)->update([
            "durum"=>$durum
        ]);
        return redirect()->back();
    }
    public function indirme($dosyaAdi)
    {
        $yol=public_path('pdf/'.$dosyaAdi);
        return response()->download($yol);
    }
}
