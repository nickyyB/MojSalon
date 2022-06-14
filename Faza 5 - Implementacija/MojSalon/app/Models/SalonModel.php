<?php

namespace App\Models;

/*
 * Autor: Nikola Brkovic 0647/2014
 * Autor: Mihajlo Micic 0565/2017
 */

use CodeIgniter\Database\ConnectionInterface;

class SalonModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }


    function getSalon($user){
        $builder = $this->db->table('korisnik');
        $builder->where('kIme', $user->kIme);
        $builder->join('salon', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');
        return $builder->get()->getResult();
    }


    function getWorkingHrs($id){
        $builder=$this->db->table('radnovreme');
        $builder->where('idSalon', $id);
        return $builder->get()->getResult();
    }

    /**
     * brisanje aktivnog salona
     */

    function deleteUser($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->delete(['idKorisnik' => $query]);
        $this->db->transComplete();
    }

    function blocksalon($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->where('idKorisnik', $query);
        $builder->set('stanje', 0);
        $builder->update();
        $this->db->transComplete();
    }

    function unblocksalon($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->where('idKorisnik', $query);
        $builder->set('stanje', 1);
        $builder->update();
        $this->db->transComplete();
    }

    /**
     * pretraga salona po nazivu
     */
    function searchsalons($query)
    {
        $builder = $this->db->table('korisnik');
        $builder->join('salon', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');
        $builder->like('salon.naziv', $query);
        $users = $builder->get()->getResult();
        return $users;
    }

    /**
     * pretraga blokiranih salona po nazivu
     */
    function searchBlockedsalons($query)
    {
        $builder = $this->db->table('korisnik');
        $builder->join('salon', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=0');
        $builder->like('salon.naziv', $query);
        $users = $builder->get()->getResult();
        return $users;
    }



    /*Vraca listu aktivnih salona i njihove ocene --- Nikola*/
    function getActivesalons()
    {
        $builder = $this->db->table('salon');
        $builder->select('salon.*,COALESCE(avg(`komentar`.`ocena`), 0) as rejting');
        $builder->join('korisnik', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');
        $builder->join('komentar', 'salon.idSalon=komentar.idSalon', 'left');
        $builder->groupBy('salon.idsalon');
        $salons = $builder->get()->getResult();
        return $salons;
    }


    /**
     * blokirani saloni Micke
     */

    function getBlockedsalons()
    {
        $builder = $this->db->table('salon');
        $builder->join('korisnik', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=0');
        $salons = $builder->get()->getResult();
        return $salons;
    }


    function getSalonServices($id)
    {
        $builder = $this->db->table('usluga');
        return $builder->where('idSalon', $id)->get()->getResult();
    }

    function getSalonById($id)
    {
        $builder = $this->db->table('salon');
        return $builder->where('idSalon', $id)->get()->getResult();
    }
    /* Dohvatanje svih  rezervacija koje nisu potvrdjene --- Petar */

    function getNonConfAppointments($idSal)
    {
        $builder = $this->db->table('termin');
        $builder->select('`idTermin`, `termin`.`datum`, `termin`.`stanje`, `termin`.`cena`, `termin`.`naziv` as naziv, `usluga`.`idSalon`,
        `osnovni`.`ime`, `osnovni`.`prezime`,`korisnik`.`kIme`');
        $builder->join('usluga', 'usluga.idUsluga = termin.idUsluga');
        $builder->join('osnovni', 'osnovni.idOsnovni = termin.idOsnovni');
        $builder->join('korisnik', 'osnovni.idOsnovni=korisnik.idKorisnik');
        $builder->where('idSalon', $idSal);
        $builder->where('termin.stanje', 1);
        $builder->where('korisnik.stanje', 1);
        $builder->where('termin.datum >=', date('Y-m-d H:i:s'));
        $builder->orderBy('datum', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    
    /* Dohvatanje svih  rezervacija koje nisu potvrdjene po korisnickom imenu --- Petar */
    function getAppointsByUser($idSal, $user){

        $builder = $this->db->table('termin');
        $builder->select('`idTermin`, `termin`.`datum`, `termin`.`stanje`, `termin`.`cena`, `termin`.`naziv` as naziv, `usluga`.`idSalon`,
        `osnovni`.`ime`, `osnovni`.`prezime`,`korisnik`.`kIme`,`korisnik`.`stanje` as status,');
 
        $builder->join('usluga', 'usluga.idUsluga = termin.idUsluga');
        $builder->join('osnovni', 'osnovni.idOsnovni = termin.idOsnovni');
        $builder->join('korisnik', 'osnovni.idOsnovni=korisnik.idKorisnik');
        $builder->where('idSalon',$idSal);
        $builder->where('termin.stanje', 1);
        $builder->where('kIme', $user);
        $builder->where('korisnik.stanje', 1);
        $builder->where('termin.datum >=', date('Y-m-d H:i:s'));


        $builder->orderBy('datum', 'ASC');
       
        $query = $builder->get();
        return $query->getResult();

    }
    
    /* Prihvatanje rezervacije termina --- Petar */
    function acceptAppoint($id)
    {
        $data = [
            'stanje' => 2,

        ];


        $builder = $this->db->table('termin');

        $builder->set($data);
        $builder->where('idTermin', $id);


        $builder->where('termin.stanje', 1);
        $query = $builder->getCompiledUpdate();
        $this->db->query($query);
    }

    /* Odbijanje rezervacije termina --- Petar */
    function denyAppoint($id)
    {

        $data = [
            'stanje' => 3,

        ];


        $builder = $this->db->table('termin');

        $builder->set($data);
        $builder->where('idTermin', $id);


        $builder->where('termin.stanje', 1);
        $query = $builder->getCompiledUpdate();
        $this->db->query($query);
    }
    /* Dohvatanje usluge i njenog tipa po IdU --- Petar */

    function getServiceAndType($idU)
    {
        $builder = $this->db->table('usluga');
        $builder->select('`idUsluga`, `usluga`.`trajanje`, `usluga`.`cena`, `usluga`.`idTip`, `usluga`.`naziv` as nazivUsluge,`tipusluge`.`naziv` as naziv,');
        $builder->join('tipusluge', 'tipusluge.idTip=usluga.idTip');
        return $builder->where('idUsluga', $idU)->get()->getResult();
    }
    /* Dohvatanje svih  vrsta usluga --- Petar */


    function getAllTypes()
    {
        $builder = $this->db->table('tipusluge');
        return $builder->get()->getResult();
    }


    /*Pretraga salona po opstini, tipuUslguge, ceni --- Nikola*/
    function getSalonByName($query = "", $limit = 0, $start = 0, $state = 0, $type = 0, $priceFrom = 0, $priceTo = 999999)
    {
        $builder = $this->db->table('salon');

        $builder->join('korisnik', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');

        if ($type != 0) {
            if ($priceTo == 0) $priceTo = 999999;
            $builder->join('usluga', 'salon.idSalon = usluga.idSalon');
            $builder->join('tipusluge', 'usluga.idTip = tipusluge.idTip');

            $salons = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->where('usluga.idTip', $type)->where('usluga.cena >', $priceFrom)->where('usluga.cena <', $priceTo)->groupBy('salon.idsalon')->get()->getResult();
            $data['total_data'] = count($salons);

            $builder = $this->db->table('salon');
            $builder->select('salon.*,COALESCE(avg(`komentar`.`ocena`), 0) as rejting');
            $builder->join('korisnik', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');
            $builder->join('usluga', 'salon.idSalon = usluga.idSalon');
            $builder->join('tipusluge', 'usluga.idTip = tipusluge.idTip');
            $builder->join('komentar', 'salon.idSalon=komentar.idSalon', 'left');

            $salons = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->where('usluga.idTip', $type)->where('usluga.cena >', $priceFrom)->where('usluga.cena <', $priceTo)->groupBy('salon.idsalon')->limit($limit, $start)->get()->getResult();
        } elseif ($type == 0 and $priceTo != 0) {
            $builder->join('usluga', 'salon.idSalon = usluga.idSalon');
            $builder->join('tipusluge', 'usluga.idTip = tipusluge.idTip');
            $salons = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->where('usluga.cena >', $priceFrom)->where('usluga.cena <', $priceTo)->groupBy('salon.idsalon')->get()->getResult();
            $data['total_data'] = count($salons);

            $builder = $this->db->table('salon');
            $builder->select('salon.*,COALESCE(avg(`komentar`.`ocena`), 0) as rejting');
            $builder->join('korisnik', 'salon.idSalon = korisnik.idKorisnik AND korisnik.stanje=1');
            $builder->join('usluga', 'salon.idSalon = usluga.idSalon');
            $builder->join('tipusluge', 'usluga.idTip = tipusluge.idTip');
            $builder->join('komentar', 'salon.idSalon=komentar.idSalon', 'left');
            $salons = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->where('usluga.cena >', $priceFrom)->where('usluga.cena <', $priceTo)->groupBy('salon.idsalon')->limit($limit, $start)->get()->getResult();
        } else {
            $data['total_data'] = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->countAllResults('', false);
            $builder->select('salon.*,COALESCE(avg(`komentar`.`ocena`), 0) as rejting');
            $builder->join('komentar', 'salon.idSalon=komentar.idSalon', 'left');
            $salons = $builder->like('salon.naziv', $query)->like('salon.opstina', $state)->groupBy('salon.idsalon')->limit($limit, $start)->get()->getResult();
        }

        foreach ($salons as $salon) {
            $salon->logo = base64_encode($salon->logo);
        }

        $data['salons'] = $salons;
        $data['page'] = $start / $limit + 1;

        return $data;
    }

    /*Dohvatanje tipova usluga --- Nikola*/
    function getTypeOfServices()
    {
        $builder = $this->db->table('tipusluge');
        return $builder->get()->getResult();
    }

    /**Dohvatanje usluge --- Danica */
    function getServiceById($serviceId)
    {
        $builder = $this->db->table('usluga');
        $builder->where('idUsluga', $serviceId);
        return $builder->get()->getRow();
    }

    /**Dohvatanje radnog vremena za dan --- Danica */
    function getWorkingHours($salonId, $dayOfWeek)
    {
        $builder = $this->db->table('radnovreme');
        $builder->where('idSalon', $salonId);

        switch ($dayOfWeek) {
            case 0:
                $builder->select('ned as dan');
                break;
            case 1:
                $builder->select('pon as dan');
                break;
            case 2:
                $builder->select('uto as dan');
                break;
            case 3:
                $builder->select('sre as dan');
                break;
            case 4:
                $builder->select('cet as dan');
                break;
            case 5:
                $builder->select('pet as dan');
                break;
            case 6:
                $builder->select('sub as dan');
                break;
        }
        $workingHours = $builder->get()->getRow();
        if ($workingHours->dan == null) {
            return null;
        } else return explode("-", $workingHours->dan);
    }

    /**Dohvatanje zakazanih termina po tipu usluge i datumu --- Danica */
    function getAppointmentsByTypeAndDate($salonId, $typeId, $date)
    {
        $builder = $this->db->table('usluga');
        $builder->select('trajanje, datum');
        $builder->join('termin', "`usluga`.`idUsluga` = `termin`.`idUsluga`");
        $builder->where('idSalon', $salonId);
        $builder->where('idTip', $typeId);
        $builder->where('datum >=', "$date");
        $builder->where('datum <=', date('Y-m-d H:i:s', strtotime($date . ' +1 day')));
        $builder->groupStart();
        $builder->where('stanje', 2);
        $builder->orWhere('stanje', 1);
        $builder->groupEnd();
        return $builder->get()->getResult();
    }

  /* Update usluge(po IdU) --- Petar */
    function UpdateServiceById($idU, $naziv, $idTip, $cena, $trajanje)
    {
        $builder = $this->db->table('usluga');
        $data = [
            'naziv' => $naziv,
            'idTip' => $idTip,
            'cena' => $cena,
            'trajanje' => $trajanje
        ];
        $builder->set($data);



        $builder->where('idUsluga', $idU);
        $query1 = $builder->getCompiledUpdate();
        $this->db->transStart();

        $this->db->query($query1);

        $this->db->transComplete();
    }

    function getTypeIdbyName($naziv)
    {
        $builder = $this->db->table('tipusluge');
        return $builder->where('naziv', $naziv)->get()->getResult();
    }

    /* Dodavanje usluge --- Petar */

    function addService($naziv, $idSalon, $idTip, $cena, $trajanje)
    {
        $data = [
            'naziv' => $naziv,
            'idSalon' => $idSalon,
            'idTip' => $idTip,
            'cena' => $cena,
            'trajanje' => $trajanje
        ];


        $builder = $this->db->table('usluga');
        $builder->set($data);
        //$builder->insert();
        $query = $builder->getCompiledInsert();

        $this->db->transStart();
        $this->db->query($query);

        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }

    /* Brisanje usluge --- Petar */
    function deleteService($idU)
    {

        $builder = $this->db->table('usluga');

        $builder->where('idUsluga', $idU);

        $query = $builder->getCompiledDelete();
        $this->db->transStart();
        $this->db->query($query);

        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }


    function getUserById($id)
    {

        $builder = $this->db->table('korisnik');
        return $builder->where('idKorisnik', $id)->get()->getResult();
    }

    /**Dohvatanje slobodnih termina --- Danica */
    function getFreeSlots($serviceId, $date)
    {
        $service = $this->getServiceById($serviceId);
        $typeId = $service->idTip;
        $salon = $this->getSalonById($service->idSalon)[0];
        $dayOfWeek = date('w', strtotime($date));
        $slots = null;
        $workingHours = $this->getWorkingHours($salon->idSalon, $dayOfWeek);
        if ($workingHours == null) {
            return null;
        } else {
            $start = $workingHours[0];
            $start .= ":00";
            $end = $workingHours[1];
            $end .= ":00";
            for ($i = strtotime($start); $i < strtotime($end); $i += 900) {
                $slots[date("H:i", $i)] = 1;
                if (strtotime($end) - $i < $service->trajanje * 60)
                    $slots[date("H:i", $i)] = 0;
            }
            $appointments = $this->getAppointmentsByTypeAndDate($salon->idSalon, $typeId, $date);
            foreach ($appointments as $appointment) {
                $trajanje = $appointment->trajanje;
                $vreme = $appointment->datum;
                while ($trajanje > 0) {
                    $slots[date("H:i", strtotime($vreme))] = 0;
                    $vreme = date('Y-m-d H:i:s', strtotime($vreme . ' +15 minutes'));
                    $trajanje -= 15;
                }
            }
            return $slots;
        }
    }
    /* Dohvatanje podatka o salonu pomocu IdSalona --- Petar */


    function getSalonData($id)
    {
        $builder = $this->db->table('salon');
        $builder->where('kIme', $username);
        $builder->join('osnovni', 'osnovni.idOsnovni = salon.idSalon');
        return $builder->get()->getRow();
        #$bilder->join('osnovni', 'osnovni.idOsnovni = korisnik.idKorisnik');
    }

    
    
    

    /**
     * izmena podataka  salona
     * Mihajlo
     */


    function changeUserData($id, $phone, $name, $address, $munc)
    {

        $builder = $this->db->table('korisnik');
        $data = [
            'telefon' => $phone
        ];
        $builder->set($data);


   
        $builder->where('idKorisnik',$id);

        $query1 = $builder->getCompiledUpdate();
        $data2 = [
            'naziv' => $name,
            'opstina' => $munc,
            'adresa' => $address
        ];
        $builder->resetQuery();

        $builder = $this->db->table('salon');
        $builder->set($data2);
   
        $builder->where('idSalon',$id);

        $query2 = $builder->getCompiledUpdate();
        $this->db->transStart();
        $this->db->query($query1);
        $this->db->query($query2);
        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return false;
        } else return true;

    
    }


    /**
     * dohvatanje galerije salona
     * Mihajlo
     */

    function getGallery($id){
        $builder = $this->db->table('galerija');
        $builder->where('idSalon', $id);

        return $builder->get()->getResult();
    }


    /**
     * dodavanje slike u galeriju salona
     * Mihajlo
     */
    function addGallery($image){
        $this->db->transStart();
        $builder = $this->db->table('galerija');
        $builder->insert($image);
        $this->db->transComplete();
        return;
    }

    /**
     * dohvatanje slike pred brisanje
     * Mihajlo
     */
    function getImage($id){
        $builder = $builder = $this->db->table('galerija');
        $builder->where('idSlika', $id);

        return $builder->get()->getResult();
    }

    /**
     * brisanje slike
     * Mihajlo
     */
    function deleteImage($id){
        $builder = $this->db->table('galerija');
        
        $builder->where('idSlika',$id);
        
        $query = $builder->getCompiledDelete();
        $this->db->transStart();
        $this->db->query($query);
        
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }


    /**
     * dohvatanje komentara
     * Mihajlo
     */
    function getComments($id){
        $builder = $this->db->table('komentar');
        $builder->where('idSalon',$id);
        $builder->join('osnovni', 'osnovni.idOsnovni = komentar.idOsnovni');


        return $builder->get()->getResult();
    }

    /**
     * racunanje prosecne ocene 
     * Mihajlo
     */
    function getRating($comments){
        $sum = 0;
        foreach($comments as $comment):
            $sum+=$comment->ocena;
        endforeach;
        if($sum>0)
            $sum = $sum/count($comments);
        

        return $sum;
    }
}
